<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";

import { Button } from "@/Components/ui/button";

import { Card, CardContent } from "@/Components/ui/card";

import { Badge } from "@/Components/ui/badge";

import { CheckCircle2, Plane, Ticket, Calendar, User } from "lucide-vue-next";

const props = defineProps({
    booking: Object,
});

const formatPrice = (price) => {
    return new Intl.NumberFormat("id-ID").format(price);
};

const formatDate = (datetime) => {
    return new Date(datetime).toLocaleDateString("id-ID", {
        day: "2-digit",
        month: "long",
        year: "numeric",
    });
};

const formatTime = (datetime) => {
    return new Date(datetime).toLocaleTimeString("id-ID", {
        hour: "2-digit",
        minute: "2-digit",
    });
};
</script>
<template>
    <GuestLayout title="Booking Success">
        <div class="max-w-5xl mx-auto px-4 py-10">
            <!-- Success Header -->
            <div class="text-center mb-10">
                <div class="flex justify-center mb-5">
                    <div
                        class="flex h-24 w-24 items-center justify-center rounded-full bg-emerald-100"
                    >
                        <CheckCircle2 class="h-14 w-14 text-emerald-600" />
                    </div>
                </div>

                <Badge class="bg-emerald-600 text-white">
                    Pembayaran Berhasil
                </Badge>

                <h1 class="mt-4 text-3xl font-bold">Pemesanan Berhasil 🎉</h1>

                <p class="mt-2 text-muted-foreground">
                    Tiket penerbangan Anda berhasil dipesan.
                </p>
            </div>

            <!-- Booking Card -->
            <Card class="overflow-hidden rounded-2xl shadow-lg">
                <CardContent class="space-y-6 mt-4">
                    <!-- Booking Code -->
                    <div class="rounded-xl border bg-muted/40 p-5">
                        <div class="flex items-center justify-between">
                            <span class="font-medium"> Total Pembayaran </span>

                            <span
                                class="bg-gradient-to-r from-emerald-700 via-emerald-600 to-emerald-500 bg-clip-text text-2xl font-bold text-transparent"
                            >
                                Rp {{ formatPrice(booking.total_price) }}
                            </span>
                        </div>
                    </div>

                    <!-- Flight -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="rounded-xl border p-5">
                            <div class="mb-3 flex items-center gap-2">
                                <Plane class="h-5 w-5 text-emerald-600" />

                                <span class="font-semibold"> Penerbangan </span>
                            </div>

                            <p class="font-bold">
                                {{ booking.flight.airline.name }}
                            </p>

                            <p class="text-sm text-muted-foreground">
                                {{ booking.flight.flight_number }}
                            </p>

                            <p class="mt-3">
                                {{ booking.flight.departure_airport.code }}
                                →
                                {{ booking.flight.arrival_airport.code }}
                            </p>
                        </div>

                        <div class="rounded-xl border p-5">
                            <div class="mb-3 flex items-center gap-2">
                                <Calendar class="h-5 w-5 text-emerald-600" />

                                <span class="font-semibold"> Jadwal </span>
                            </div>

                            <p class="font-bold">
                                {{
                                    formatDate(
                                        booking.flight.scheduled_departure,
                                    )
                                }}
                            </p>

                            <p class="text-sm text-muted-foreground">
                                {{
                                    formatTime(
                                        booking.flight.scheduled_departure,
                                    )
                                }}
                                -
                                {{
                                    formatTime(booking.flight.scheduled_arrival)
                                }}
                            </p>
                        </div>

                        <div
                            v-for="passenger in booking.passengers"
                            :key="passenger.id"
                            class="rounded-xl border p-5"
                        >
                            <div class="mb-3 flex items-center gap-2">
                                <User class="h-5 w-5 text-emerald-600" />

                                <span class="font-semibold"> Penumpang </span>
                            </div>

                            <p class="font-bold">
                                {{ passenger.full_name }}
                            </p>

                            <p class="text-sm text-muted-foreground">
                                {{ passenger.identity_type.toUpperCase() }}

                                :

                                {{ passenger.identity_number }}
                            </p>
                        </div>

                        <div class="rounded-xl border p-5">
                            <div class="mb-3 flex items-center gap-2">
                                <Ticket class="h-5 w-5 text-emerald-600" />

                                <span class="font-semibold"> Status </span>
                            </div>

                            <Badge class="bg-emerald-600 text-white">
                                {{ booking.booking_status }}
                            </Badge>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </GuestLayout>
</template>
