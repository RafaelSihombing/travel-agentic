<?php

namespace App\Services;

use App\Events\RecommendationCreated;
use App\Models\AgentLog;
use App\Models\AgentRecommendation;
use App\Models\AlternativeFlight;
use App\Models\Booking;
use App\Models\Flight;
use App\Models\FlightStatus;

class FlightDelayAgentService
{
    //  Agent
    public function handle(FlightStatus $flightStatus): void
    {

        $flight = $flightStatus->flight;

        // query booking
        $bookings = Booking::query()
            ->where('flight_id', $flight->id)
            ->where('booking_status', 'booked')
            ->where('payment_status', 'paid')
            ->get();

        $data = $this->buildRecommendation($flightStatus, $flight);

        // dd($bookings->count());

        // Agent Log
        foreach ($bookings as $booking) {
            AgentLog::create([
                'flight_id' => $flight->id,
                'booking_id' => $booking->id,
                'trigger_event' => 'flight_delayed',
                'delay_minutes' => $flightStatus->delay_minutes,
                'severity' => $data['severity'],
                'recommendation_type' => $data['recommendation_type'],
                'message' => sprintf('Booking %s terdampak delay penerbangan %s.', $booking->booking_code, $flight->flight_number)
            ]);

            $recommendation = AgentRecommendation::create([
                'booking_id' => $booking->id,
                'flight_id' => $flight->id,
                'recommendation_type' => $data['recommendation_type'],
                'severity' => $data['severity'],
                'title' => $data['title'],
                'message' => $data['message'],
                'suggested_action' => $data['suggested_action'],
                'is_read' => false,
            ]);

            event(
                new RecommendationCreated($recommendation)
            );
        }
    }

    // Rule Based Agent
    private function buildRecommendation(FlightStatus $flightStatus, Flight $flight): array
    {
        $delayMinutes = $flightStatus->delay_minutes;
        $alternativeFlight = $this->findAlternativeFlight($flight);

        if ($delayMinutes < 30) {
            return [
                'recommendation_type' => 'info',
                'severity' => 'low',
                'title' => 'Informasi Keterlambatan',
                'message' => sprintf('Penerbangan %s mengalami keterlambatan %d menit.', $flight->flight_number, $delayMinutes),
                'suggested_action' => 'Pantau informasi keberangkatan terbaru.',
            ];
        }

        if ($delayMinutes < 120) {
            return [
                'recommendation_type' => 'delay_warning',
                'severity' => 'medium',
                'title' => 'Peringatan Keterlambatan',
                'message' => sprintf('Penerbangan %s mengalami keterlambatan %d menit karena %s.', $flight->flight_number, $delayMinutes, $flightStatus->reason ?? 'alasan operasional'),
                'suggested_action' => 'Tetap berada di area keberangkatan dan pantau informasi terbaru.'
            ];
        }
        if ($delayMinutes < 240) {
            return [
                'recommendation_type' => 'compensation',
                'severity' => 'high',
                'title' => 'Rekomendasi Kompensasi',
                'message' => sprintf('Penerbangan %s mengalami keterlambatan %d menit.', $flight->flight_number, $delayMinutes),
                'suggested_action' => 'Berikan kompensasi berupa voucher makan atau opsi reschedule.'
            ];
        }

        if ($alternativeFlight) {
            $alternative = $alternativeFlight->alternativeFlight;

            return [
                'recommendation_type' => 'alternative_flight',
                'severity' => 'critical',
                'title' => 'Penerbangan Alternatif Tersedia',

                'message' => sprintf(
                    'Penerbangan %s mengalami keterlambatan %d menit. Sistem menemukan penerbangan alternatif %s.',
                    $flight->flight_number,
                    $delayMinutes,
                    $alternative->flight_number
                ),

                'suggested_action' => sprintf(
                    'Tawarkan rebooking ke penerbangan %s.',
                    $alternative->flight_number
                ),
            ];
        }
        return [
            'recommendation_type' => 'refund',
            'severity' => 'critical',
            'title' => 'Rekomendasi Refund',
            'message' => sprintf('Penerbangan %s mengalami keterlambatan sangat lama (%d menit).', $flight->flight_number, $delayMinutes),
            'suggested_action' => 'Sarankan refund atau rebooking penerbangan lain.'
        ];
    }

    private function findAlternativeFlight(Flight $flight): ?AlternativeFlight
    {

        return AlternativeFlight::query()
            ->where('original_flight_id', $flight->id)
            ->with('alternativeFlight')
            ->first();
    }
}
