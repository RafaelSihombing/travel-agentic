<script setup>
import { Card, CardContent } from "@/Components/ui/card";

import { Button } from "@/Components/ui/button";

import { Badge } from "@/Components/ui/badge";

import { Tabs, TabsList, TabsTrigger } from "@/Components/ui/tabs";

import {
    Plane,
    CheckCircle2,
    XCircle,
    Sparkles,
    AlertTriangle,
} from "lucide-vue-next";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Link } from "@inertiajs/vue3";

defineOptions({
    layout: GuestLayout,
});

defineProps({
    bookings: Object,
});
</script>

<template>
    <div class="mx-auto max-w-7xl px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold">My Bookings</h1>

            <p class="text-muted-foreground mt-2">
                Manage and track all your flight reservations.
            </p>
        </div>

        <!-- Stats -->
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <Card>
                <CardContent class="p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-muted-foreground">
                            Upcoming Flights
                        </p>

                        <h2 class="text-4xl font-bold mt-2">04</h2>
                    </div>

                    <Plane class="size-10 text-emerald-500" />
                </CardContent>
            </Card>

            <Card>
                <CardContent class="p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-muted-foreground">
                            Completed Trips
                        </p>

                        <h2 class="text-4xl font-bold mt-2">12</h2>
                    </div>

                    <CheckCircle2 class="size-10 text-blue-500" />
                </CardContent>
            </Card>

            <Card>
                <CardContent class="p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-muted-foreground">Cancelled</p>

                        <h2 class="text-4xl font-bold mt-2">01</h2>
                    </div>

                    <XCircle class="size-10 text-red-500" />
                </CardContent>
            </Card>

            <Card>
                <CardContent class="p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-muted-foreground">
                            Recommendations
                        </p>

                        <h2 class="text-4xl font-bold mt-2">03</h2>
                    </div>

                    <Sparkles class="size-10 text-amber-500" />
                </CardContent>
            </Card>
        </div>

        <!-- Tabs -->
        <Card class="mb-6">
            <CardContent class="p-4">
                <Tabs default-value="all">
                    <TabsList>
                        <TabsTrigger value="all"> All Bookings </TabsTrigger>

                        <TabsTrigger value="ongoing"> Ongoing </TabsTrigger>

                        <TabsTrigger value="unpaid"> Unpaid </TabsTrigger>

                        <TabsTrigger value="history"> History </TabsTrigger>
                    </TabsList>
                </Tabs>
            </CardContent>
        </Card>

        <!-- Booking List -->
        <div class="space-y-6">
            <Card
                v-for="booking in bookings.data"
                :key="booking.id"
                class="overflow-hidden"
            >
                <CardContent class="p-0">
                    <div class="grid lg:grid-cols-[250px_1fr]">
                        <!-- Left -->
                        <div
                            class="flex flex-col items-center justify-center border-r p-8"
                        >
                            <div class="size-20 rounded-xl bg-muted" />

                            <h3 class="mt-4 text-xl font-semibold">
                                {{ booking.flight.airline }}
                            </h3>

                            <p class="text-muted-foreground">
                                {{ booking.flight.flight_number }}
                            </p>
                        </div>

                        <!-- Right -->
                        <div class="p-8">
                            <!-- Badges -->
                            <div class="flex items-center gap-2 mb-6">
                                <Badge>
                                    {{ booking.booking_status }}
                                </Badge>

                                <Badge variant="secondary">
                                    {{ booking.payment_status }}
                                </Badge>

                                <Badge variant="outline">
                                    {{ booking.seat_class }}
                                </Badge>
                            </div>

                            <div class="flex items-center justify-between">
                                <!-- Departure -->
                                <div>
                                    <h2 class="text-5xl font-bold">
                                        {{ booking.flight.departure }}
                                    </h2>

                                    <p class="text-muted-foreground">
                                        Departure
                                    </p>
                                </div>

                                <!-- Flight Path -->
                                <div class="flex-1 px-10">
                                    <div class="relative">
                                        <div
                                            class="h-1 rounded-full bg-muted"
                                        />

                                        <Plane
                                            class="absolute left-1/2 top-1/2 size-5 -translate-x-1/2 -translate-y-1/2 text-emerald-500"
                                        />
                                    </div>
                                </div>

                                <!-- Arrival -->
                                <div>
                                    <h2 class="text-5xl font-bold">
                                        {{ booking.flight.arrival }}
                                    </h2>

                                    <p class="text-muted-foreground">Arrival</p>
                                </div>
                            </div>

                            <div class="mt-8 flex items-end justify-between">
                                <div class="grid grid-cols-3 gap-10">
                                    <div>
                                        <p
                                            class="text-sm text-muted-foreground"
                                        >
                                            Passengers
                                        </p>

                                        <p class="font-semibold">
                                            {{ booking.passenger_count }}
                                            Persons
                                        </p>
                                    </div>

                                    <div>
                                        <p
                                            class="text-sm text-muted-foreground"
                                        >
                                            Booking
                                        </p>

                                        <p class="font-semibold">
                                            {{ booking.booking_code }}
                                        </p>
                                    </div>

                                    <div>
                                        <p
                                            class="text-sm text-muted-foreground"
                                        >
                                            Total Paid
                                        </p>

                                        <p
                                            class="text-3xl font-bold text-emerald-600"
                                        >
                                            Rp
                                            {{
                                                Number(
                                                    booking.total_price,
                                                ).toLocaleString("id-ID")
                                            }}
                                        </p>
                                    </div>
                                </div>

                                <Button as-child>
                                    <Link
                                        :href="
                                            route(
                                                'my-bookings.show',
                                                booking.id,
                                            )
                                        "
                                    >
                                        <Button> View Detail </Button>
                                    </Link>
                                </Button>
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>

            <!-- Recommendation -->
            <Card class="border-red-200 bg-red-50">
                <CardContent class="flex items-center justify-between p-6">
                    <div class="flex items-center gap-4">
                        <div class="rounded-xl bg-red-100 p-3">
                            <AlertTriangle class="size-6 text-red-500" />
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-red-700">
                                Flight JT203 is delayed by 180 minutes
                            </h3>

                            <p class="text-red-600">
                                Agent Recommendation: Rebook to GA101 for a
                                faster connection.
                            </p>
                        </div>
                    </div>

                    <Button variant="outline"> View Recommendation </Button>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
