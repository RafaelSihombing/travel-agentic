<script setup>
import { Button } from "@/Components/ui/button";
import { Badge } from "@/Components/ui/badge";
import { Card } from "@/Components/ui/card";
import { format } from "date-fns";

import {
    IconPlane,
    IconBriefcase,
    IconCircleCheckFilled,
} from "@tabler/icons-vue";

const props = defineProps({
    recommendation: {
        type: Object,
        required: true,
    },
});

const formatPrice = (price) =>
    new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(price);

const formatTime = (date) => format(new Date(date), "HH:mm");
</script>

<template>
    <Card
        class="rounded-3xl border bg-white p-6 shadow-sm transition-all hover:shadow-lg"
    >
        <!-- Top -->
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-2">
                <Badge
                    class="rounded-full bg-emerald-600 text-white hover:bg-emerald-600"
                >
                    RECOMMENDED
                </Badge>

                <Badge variant="secondary" class="rounded-full"> DIRECT </Badge>
            </div>

            <div class="text-center">
                <div
                    class="flex h-14 w-14 items-center justify-center rounded-full border-2 border-emerald-500"
                >
                    <span class="text-xl font-bold text-emerald-600">{{
                        recommendation.score
                    }}</span>
                </div>

                <p class="mt-1 text-[10px] uppercase text-muted-foreground">
                    AI SCORE
                </p>
            </div>
        </div>

        <!-- Airline -->
        <div class="mt-8 flex items-center gap-4">
            <div
                class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-100"
            >
                <IconPlane class="h-6 w-6 text-sky-600" />
            </div>

            <div>
                <h3 class="font-semibold">
                    {{ recommendation.airline.name }}
                </h3>

                <p class="text-xs text-muted-foreground">
                    {{ recommendation.flight_number }}
                </p>
            </div>
        </div>

        <!-- Flight -->
        <div class="mt-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold">
                    {{ formatTime(recommendation.scheduled_departure) }}
                </h2>

                <p class="text-sm text-muted-foreground">
                    {{ recommendation.departure_airport.code }}
                </p>
            </div>

            <div class="mx-6 flex flex-1 items-center">
                <div class="h-px flex-1 border-t border-dashed"></div>

                <div
                    class="mx-4 flex h-10 w-10 items-center justify-center rounded-full bg-emerald-50"
                >
                    <IconPlane class="h-5 w-5 rotate-90 text-emerald-600" />
                </div>

                <div class="h-px flex-1 border-t border-dashed"></div>
            </div>

            <div class="text-right">
                <h2 class="text-3xl font-bold">
                    {{ formatTime(recommendation.scheduled_arrival) }}
                </h2>

                <p class="text-sm text-muted-foreground">
                    {{ recommendation.arrival_airport.code }}
                </p>
            </div>
        </div>

        <!-- Price -->
        <div class="mt-8 flex items-end justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-4xl font-bold">
                        {{ formatPrice(recommendation.price) }}
                    </h2>

                    <Badge
                        variant="secondary"
                        class="bg-emerald-100 text-emerald-700"
                    >
                        12% CHEAPER
                    </Badge>
                </div>

                <p class="mt-1 text-sm text-muted-foreground">
                    Economy Class • Per traveler
                </p>
            </div>

            <div class="flex items-center gap-3">
                <Button variant="ghost"> Details </Button>

                <Button as-child class="rounded-xl">
                    <Link :href="route('flights.passenger', recommendation.id)">
                        Book Now
                    </Link>
                </Button>
            </div>
        </div>

        <!-- AI Insight -->
        <div
            class="mt-8 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4"
        >
            <div
                class="flex h-10 w-10 items-center justify-center rounded-full bg-white"
            >
                <IconBriefcase class="h-5 w-5 text-emerald-600" />
            </div>

            <div class="text-sm leading-relaxed">
                <span class="font-semibold text-emerald-700">
                    AI Insight:
                </span>

                {{ recommendation.insight }}
            </div>
        </div>
    </Card>
</template>
