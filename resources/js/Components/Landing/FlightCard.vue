<script setup>
import { router } from "@inertiajs/vue3";
import { Button } from "@/Components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";

import { Plane } from "lucide-vue-next";

const props = defineProps({
    flight: {
        type: Object,
        required: true,
    },

    search: {
        type: Object,
        required: true,
    },

    selectedFlight: {
        type: String,
        default: null,
    },
});
const emit = defineEmits(["toggle"]);

const formatPrice = (price) => {
    return new Intl.NumberFormat("id-ID").format(price);
};

const formatTime = (datetime) => {
    return new Date(datetime).toLocaleTimeString("id-ID", {
        hour: "2-digit",
        minute: "2-digit",
    });
};

const formatDate = (datetime) => {
    return new Date(datetime).toLocaleDateString("id-ID", {
        day: "2-digit",
        month: "short",
        year: "numeric",
    });
};

const getDuration = (departure, arrival) => {
    const start = new Date(departure);
    const end = new Date(arrival);

    const diff = end - start;

    const hours = Math.floor(diff / 1000 / 60 / 60);
    const minutes = Math.floor((diff / 1000 / 60) % 60);

    return `${hours}j ${minutes}m`;
};
</script>

<template>
    <Card
        class="hover:border-primary hover:shadow-md transition-all duration-300"
    >
        <CardContent class="p-5">
            <div
                class="flex flex-col lg:flex-row justify-between items-center gap-6"
            >
                <!-- Airline -->
                <div class="w-full lg:w-52">
                    <h3 class="font-semibold">
                        {{ flight.airline?.name }}
                    </h3>

                    <p class="text-sm text-muted-foreground">
                        {{ flight.flight_number }}
                    </p>
                </div>

                <!-- Route -->
                <div class="flex-1 w-full">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xl font-bold">
                                {{ formatTime(flight.scheduled_departure) }}
                            </p>

                            <p class="font-medium">
                                {{ flight.departure_airport?.code }}
                            </p>

                            <p class="text-xs text-muted-foreground">
                                {{ flight.departure_airport?.city }}
                            </p>
                        </div>

                        <div class="flex-1 px-6 text-center">
                            <p class="text-xs text-muted-foreground">
                                {{
                                    getDuration(
                                        flight.scheduled_departure,
                                        flight.scheduled_arrival,
                                    )
                                }}
                            </p>

                            <div class="relative my-2">
                                <div class="h-px bg-border"></div>

                                <Plane
                                    class="absolute left-1/2 top-0 -translate-x-1/2 -translate-y-1/2 h-4 w-4 text-primary"
                                />
                            </div>

                            <p class="text-xs text-muted-foreground">
                                Direct Flight
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-xl font-bold">
                                {{ formatTime(flight.scheduled_arrival) }}
                            </p>

                            <p class="font-medium">
                                {{ flight.arrival_airport?.code }}
                            </p>

                            <p class="text-xs text-muted-foreground">
                                {{ flight.arrival_airport?.city }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Price -->
                <div class="flex flex-col items-end gap-2 min-w-[180px]">
                    <p
                        class="bg-gradient-to-r from-emerald-700 via-emerald-600 to-emerald-500 bg-clip-text text-4xl font-bold text-transparent"
                    >
                        {{ formatPrice(flight.price) }}
                    </p>

                    <Button
                        @click.stop="emit('toggle', flight.id)"
                        variant="outline"
                        class="rounded-xl border-emerald-500 text-emerald-600 transition-all duration-300 hover:border-emerald-600 hover:bg-emerald-50 hover:text-emerald-700"
                    >
                        {{
                            selectedFlight === flight.id
                                ? "Hide Detail"
                                : "Pilih Penerbangan"
                        }}
                    </Button>
                </div>
            </div>
        </CardContent>

        <!-- Detail -->
        <div
            v-if="selectedFlight === flight.id"
            class="border-t bg-muted/20 p-6"
        >
            <div class="space-y-4">
                <div>
                    <h4 class="font-semibold">Departure</h4>

                    <p>
                        {{ flight.departure_airport?.name }}
                    </p>

                    <p class="text-sm text-muted-foreground">
                        {{ flight.departure_airport?.city }}
                        ({{ flight.departure_airport?.code }})
                    </p>

                    <p>
                        {{ formatDate(flight.scheduled_departure) }}
                        -
                        {{ formatTime(flight.scheduled_departure) }}
                    </p>
                </div>

                <div>
                    <h4 class="font-semibold">Arrival</h4>

                    <p>
                        {{ flight.arrival_airport?.name }}
                    </p>

                    <p class="text-sm text-muted-foreground">
                        {{ flight.arrival_airport?.city }}
                        ({{ flight.arrival_airport?.code }})
                    </p>

                    <p>
                        {{ formatDate(flight.scheduled_arrival) }}
                        -
                        {{ formatTime(flight.scheduled_arrival) }}
                    </p>
                </div>

                <Button
                    @click="
                        router.visit(
                            route('flights.passenger', {
                                flight: flight.id,
                                departure_airport_id:
                                    props.search.departure_airport.id,
                                arrival_airport_id: search.arrival_airport.id,
                                scheduled_departure: search.scheduled_departure,
                                passenger_count: search.passenger_count,
                                seat_class: search.seat_class,
                                direct_flight: search.direct_flight,
                                ai_recommendation: search.ai_recommendation,
                            }),
                        )
                    "
                >
                    Continue Booking
                </Button>
            </div>
        </div>
    </Card>
</template>
