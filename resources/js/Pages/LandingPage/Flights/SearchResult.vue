<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";

import { Button } from "@/Components/ui/button";
import { Checkbox } from "@/Components/ui/checkbox";

import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";

import { Separator } from "@/Components/ui/separator";

import {
    Sheet,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from "@/Components/ui/sheet";

import { Plane, Filter, Wifi, Briefcase, Popcorn } from "lucide-vue-next";
import { computed, ref } from "vue";
import FlightCard from "@/Components/Landing/FlightCard.vue";

const selectedFlight = ref(null);

const toggleFlight = (id) => {
    selectedFlight.value = selectedFlight.value === id ? null : id;
};

const props = defineProps({
    flights: Array,
    search: Object,
});

const airlines = computed(() => {
    const unique = [];

    props.flights.forEach((flight) => {
        if (!unique.find((a) => a.id === flight.airline.id)) {
            unique.push(flight.airline);
        }
    });

    return unique;
});

const formatPrice = (price) => {
    return new Intl.NumberFormat("id-ID").format(price);
};

const formatTime = (datetime) => {
    return new Date(datetime).toLocaleTimeString("id-ID", {
        hour: "2-digit",
        minute: "2-digit",
    });
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString("id-ID", {
        day: "2-digit",
        month: "long",
        year: "numeric",
    });
};
</script>

<template>
    <GuestLayout title="Flight Search">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <!-- Search Summary -->
            <Card class="mb-6 border-0 bg-emerald-600 text-white shadow-lg">
                <CardContent class="p-4">
                    <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                        <div>
                            <p class="text-xs text-emerald-100">Departure</p>

                            <p class="font-semibold">
                                {{ search.departure_airport.city }}
                                ({{ search.departure_airport.code }})
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-emerald-100">Arrival</p>

                            <p class="font-semibold">
                                {{ search.arrival_airport.city }}
                                ({{ search.arrival_airport.code }})
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-emerald-100">Date</p>

                            <p class="font-semibold">
                                {{ formatDate(search.scheduled_departure) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-emerald-100">Passenger</p>

                            <p class="font-semibold">
                                {{ search.passenger_count }}
                                {{
                                    Number(search.passenger_count) > 1
                                        ? "Adults"
                                        : "Adult"
                                }}
                            </p>
                        </div>
                    </div>
                </CardContent>
            </Card>

            <!-- Mobile Filter -->
            <div class="mb-4 lg:hidden">
                <Sheet>
                    <SheetTrigger as-child>
                        <Button variant="outline">
                            <Filter class="w-4 h-4 mr-2" />
                            Filters
                        </Button>
                    </SheetTrigger>

                    <SheetContent side="left">
                        <SheetHeader>
                            <SheetTitle> Filters </SheetTitle>
                        </SheetHeader>

                        <div class="mt-6 space-y-6">
                            <div>
                                <h3 class="font-medium mb-3">Flight Type</h3>

                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <Checkbox />
                                        <span class="text-sm">
                                            Direct Flight
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <Checkbox />
                                        <span class="text-sm">
                                            Transit 1x
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <Checkbox />
                                        <span class="text-sm">
                                            Transit 2x
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </SheetContent>
                </Sheet>
            </div>

            <!-- Content -->
            <div class="grid lg:grid-cols-12 gap-6">
                <!-- Sidebar -->
                <!-- Sidebar -->
                <div class="hidden lg:block lg:col-span-3">
                    <Card
                        class="sticky top-24 overflow-hidden rounded-2xl shadow-lg"
                    >
                        <!-- Header -->
                        <div
                            class="bg-gradient-to-r from-emerald-600 to-emerald-500 px-6 py-5 text-white"
                        >
                            <h2 class="text-xl font-bold">Current Search</h2>

                            <p class="mt-1 text-sm text-emerald-100">
                                Your selected travel preferences
                            </p>
                        </div>

                        <CardContent class="space-y-6 p-6">
                            <!-- Flight -->
                            <div>
                                <h3
                                    class="mb-4 border-l-4 border-emerald-500 pl-3 text-sm font-semibold uppercase tracking-wide text-emerald-700"
                                >
                                    Flight
                                </h3>

                                <div
                                    class="flex items-center gap-3 rounded-xl border bg-emerald-50 p-4"
                                >
                                    <Checkbox
                                        :checked="search.direct_flight"
                                        disabled
                                    />

                                    <span class="font-medium">
                                        {{
                                            search.direct_flight
                                                ? "Direct Flight"
                                                : "Transit Flight"
                                        }}
                                    </span>
                                </div>
                            </div>

                            <Separator />

                            <!-- Airlines -->
                            <div>
                                <h3
                                    class="mb-4 border-l-4 border-emerald-500 pl-3 text-sm font-semibold uppercase tracking-wide text-emerald-700"
                                >
                                    Airlines
                                </h3>

                                <div
                                    v-for="airline in airlines"
                                    :key="airline.id"
                                    class="flex items-center gap-3 rounded-lg px-2 py-2 transition hover:bg-muted"
                                >
                                    <Checkbox />

                                    <span class="text-sm font-medium">
                                        {{ airline.name }}
                                    </span>
                                </div>
                            </div>

                            <Separator />

                            <!-- Cabin -->
                            <div>
                                <h3
                                    class="mb-4 border-l-4 border-emerald-500 pl-3 text-sm font-semibold uppercase tracking-wide text-emerald-700"
                                >
                                    Cabin Class
                                </h3>

                                <div
                                    class="rounded-xl border bg-emerald-50 p-4"
                                >
                                    <p class="text-xs text-muted-foreground">
                                        Selected Cabin
                                    </p>

                                    <p
                                        class="mt-1 text-lg font-semibold capitalize"
                                    >
                                        {{ search.seat_class }}
                                    </p>
                                </div>
                            </div>

                            <Separator />

                            <!-- Passenger -->
                            <div>
                                <h3
                                    class="mb-4 border-l-4 border-emerald-500 pl-3 text-sm font-semibold uppercase tracking-wide text-emerald-700"
                                >
                                    Passenger
                                </h3>

                                <div
                                    class="rounded-xl border bg-emerald-50 p-4"
                                >
                                    <p class="text-xs text-muted-foreground">
                                        Total Passenger
                                    </p>

                                    <p class="mt-1 text-lg font-semibold">
                                        {{ search.passenger_count }}
                                        {{
                                            Number(search.passenger_count) > 1
                                                ? "Adults"
                                                : "Adult"
                                        }}
                                    </p>
                                </div>
                            </div>

                            <Separator />

                            <!-- AI -->
                            <div>
                                <h3
                                    class="mb-4 border-l-4 border-emerald-500 pl-3 text-sm font-semibold uppercase tracking-wide text-emerald-700"
                                >
                                    AI Recommendation
                                </h3>

                                <div
                                    class="flex items-center gap-3 rounded-xl border bg-emerald-50 p-4"
                                >
                                    <Checkbox
                                        :checked="search.ai_recommendation"
                                        disabled
                                    />

                                    <span class="font-medium">
                                        {{
                                            search.ai_recommendation
                                                ? "Enabled"
                                                : "Disabled"
                                        }}
                                    </span>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Results -->
                <div class="lg:col-span-9">
                    <Card class="overflow-hidden rounded-2xl shadow-lg">
                        <!-- Header -->
                        <div
                            class="bg-gradient-to-r from-emerald-600 to-emerald-500 px-6 py-5 text-white"
                        >
                            <h2 class="text-xl font-bold">Available Flights</h2>

                            <p class="mt-1 text-sm text-emerald-100">
                                Choose the best flight based on your search
                            </p>
                        </div>

                        <CardContent class="p-6">
                            <div v-if="flights.length">
                                <FlightCard
                                    v-for="flight in flights"
                                    :key="flight.id"
                                    :flight="flight"
                                    :search="search"
                                    :selected-flight="selectedFlight"
                                    @toggle="toggleFlight"
                                />
                            </div>

                            <div
                                v-else
                                class="flex flex-col items-center justify-center py-20"
                            >
                                <Plane
                                    class="mb-4 h-12 w-12 text-muted-foreground"
                                />

                                <h3 class="text-xl font-semibold">
                                    No Flights Found
                                </h3>

                                <p
                                    class="mt-2 text-center text-muted-foreground"
                                >
                                    No flights are available for the selected
                                    route and departure date.
                                </p>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
