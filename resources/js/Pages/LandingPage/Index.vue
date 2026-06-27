<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Checkbox } from "@/Components/ui/checkbox";

import { Card, CardContent } from "@/Components/ui/card";

import { Tabs, TabsList, TabsTrigger } from "@/Components/ui/tabs";

import { Star } from "lucide-vue-next";
import Select from "@/Components/ui/select/Select.vue";
import SelectTrigger from "@/Components/ui/select/SelectTrigger.vue";
import SelectContent from "@/Components/ui/select/SelectContent.vue";
import SelectItem from "@/Components/ui/select/SelectItem.vue";
import SelectValue from "@/Components/ui/select/SelectValue.vue";
import RecommendationCard from "@/Components/Landing/RecommendationCard.vue";
import { Badge } from "@/Components/ui/badge";

const props = defineProps({
    flights: { type: Array, default: () => [] },
    airports: { type: Array, default: () => [] },
    recommendations: { type: Array, default: () => [] },
});

const form = useForm({
    departure_airport_id: "",
    arrival_airport_id: "",
    scheduled_departure: "",
    return_date: "",
    passenger_count: "1",
    seat_class: "economy",
    direct_flight: false,

    ai_recommendation: true,
});

const searchFlight = () => {
    form.get(route("flights.search"));
};
</script>

<template>
    <Head title="Flight Booking" />

    <GuestLayout>
        <!-- HERO -->
        <section class="bg-gradient-to-r from-sky-500 to-blue-700">
            <div class="max-w-7xl mx-auto px-4 md:px-6 py-16 lg:py-24">
                <div class="grid lg:grid-cols-2 gap-8 items-center">
                    <div>
                        <h1 class="text-4xl lg:text-5xl font-bold text-white">
                            Find & Book Your Next Flight
                        </h1>

                        <p class="mt-4 text-base text-sky-100 max-w-lg">
                            Compare airlines, discover the best deals, and
                            travel smarter with real-time updates.
                        </p>
                    </div>

                    <div class="hidden lg:flex justify-center">
                        <img
                            src="/images/airplane.png"
                            alt="Airplane"
                            class="max-w-md"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- SEARCH -->
        <section class="relative z-20 -mt-8 md:-mt-12">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <Card class="shadow-xl">
                    <CardContent class="p-5 md:p-6">
                        <!-- TOP -->
                        <div
                            class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4"
                        >
                            <div class="flex items-center gap-3">
                                <Checkbox
                                    v-model:checked="form.direct_flight"
                                />

                                <span class="text-sm"> Direct Flight </span>
                            </div>
                            <div class="flex items-center gap-3">
                                <Checkbox
                                    v-model:checked="form.ai_recommendation"
                                />

                                <span class="text-sm flex items-center gap-1">
                                    AI Smart Recommendation

                                    <Badge class="bg-emerald-600 text-white">
                                        AI
                                    </Badge>
                                </span>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <!-- Passenger -->
                                <Select v-model="form.passenger_count">
                                    <SelectTrigger class="w-[150px]">
                                        <SelectValue placeholder="Passenger" />
                                    </SelectTrigger>

                                    <SelectContent>
                                        <SelectItem value="1">
                                            1 Adult
                                        </SelectItem>

                                        <SelectItem value="2">
                                            2 Adults
                                        </SelectItem>

                                        <SelectItem value="3">
                                            3 Adults
                                        </SelectItem>

                                        <SelectItem value="4">
                                            4 Adults
                                        </SelectItem>
                                    </SelectContent>
                                </Select>

                                <!-- Cabin -->
                                <Select v-model="form.seat_class">
                                    <SelectTrigger class="w-[150px]">
                                        <SelectValue
                                            placeholder="Cabin Class"
                                        />
                                    </SelectTrigger>

                                    <SelectContent>
                                        <SelectItem value="economy">
                                            Economy
                                        </SelectItem>

                                        <SelectItem value="business">
                                            Business
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <!-- FORM -->
                        <div
                            class="mt-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-12 gap-4"
                        >
                            <!-- FROM -->
                            <div class="xl:col-span-3">
                                <label class="mb-2 block text-sm font-medium">
                                    From
                                </label>

                                <Select v-model="form.departure_airport_id">
                                    <SelectTrigger class="h-11">
                                        <SelectValue
                                            placeholder="Departure Airport"
                                        />
                                    </SelectTrigger>

                                    <SelectContent>
                                        <SelectItem
                                            v-for="airport in airports"
                                            :key="airport.id"
                                            :value="String(airport.id)"
                                        >
                                            {{ airport.city }}
                                            ({{ airport.code }})
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>

                            <!-- TO -->
                            <div class="xl:col-span-3">
                                <label class="mb-2 block text-sm font-medium">
                                    To
                                </label>

                                <Select v-model="form.arrival_airport_id">
                                    <SelectTrigger class="h-11">
                                        <SelectValue
                                            placeholder="Destination Airport"
                                        />
                                    </SelectTrigger>

                                    <SelectContent>
                                        <SelectItem
                                            v-for="airport in airports"
                                            :key="airport.id"
                                            :value="String(airport.id)"
                                        >
                                            {{ airport.city }}
                                            ({{ airport.code }})
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>

                            <!-- DEPARTURE -->
                            <div class="xl:col-span-2">
                                <label class="mb-2 block text-sm font-medium">
                                    Departure
                                </label>

                                <Input
                                    type="date"
                                    class="h-11"
                                    v-model="form.scheduled_departure"
                                />
                            </div>

                            <!-- RETURN -->
                            <div class="xl:col-span-2">
                                <label class="mb-2 block text-sm font-medium">
                                    Return
                                </label>

                                <Input
                                    type="date"
                                    class="h-11"
                                    v-model="form.return_date"
                                />
                            </div>

                            <!-- BUTTON -->
                            <div class="xl:col-span-2 flex items-end">
                                <Button
                                    size="lg"
                                    class="w-full h-11"
                                    @click="searchFlight"
                                >
                                    Search Flight
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </section>

        <!-- AI SMART RECOMMENDATION -->
        <section class="py-20 bg-muted/20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Heading -->
                <div class="mx-auto max-w-3xl text-center">
                    <Badge
                        class="rounded-full bg-emerald-100 px-4 py-1 text-emerald-700 hover:bg-emerald-100"
                    >
                        ✨ Powered by FlightHub AI
                    </Badge>

                    <h2
                        class="mt-6 text-3xl font-bold tracking-tight md:text-5xl"
                    >
                        AI Smart Recommendation
                    </h2>

                    <p
                        class="mt-4 text-base leading-7 text-muted-foreground md:text-lg"
                    >
                        Travel Agentic menggunakan Autonomous Agent untuk
                        memberikan rekomendasi penerbangan terbaik berdasarkan
                        harga, jadwal, dan status penerbangan secara otomatis.
                    </p>
                </div>

                <!-- Cards -->
                <div class="mt-14 grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <RecommendationCard
                        v-for="recommendation in recommendations"
                        :key="recommendation.id"
                        :recommendation="recommendation"
                    />
                </div>
            </div>
        </section>
    </GuestLayout>
</template>
