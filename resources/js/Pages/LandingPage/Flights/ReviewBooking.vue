<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";

import { Button } from "@/Components/ui/button";
import { router } from "@inertiajs/vue3";

import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
    CardDescription,
} from "@/Components/ui/card";

import { Badge } from "@/Components/ui/badge";

import {
    Plane,
    User,
    CreditCard,
    ShieldCheck,
    Briefcase,
} from "lucide-vue-next";

const props = defineProps({
    flight: Object,
    booking: Object,
    search: Object,
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

const getDuration = (departure, arrival) => {
    const start = new Date(departure);
    const end = new Date(arrival);

    const diff = end - start;

    const hours = Math.floor(diff / 1000 / 60 / 60);
    const minutes = Math.floor((diff / 1000 / 60) % 60);

    return `${hours}h ${minutes}m`;
};

// const submit = () => {
//     router.post(route("flights.payment"), {
//         ...props.booking,

//         passenger_count: props.search.passenger_count,
//         seat_class: props.search.seat_class,
//         direct_flight: props.search.direct_flight,
//         ai_recommendation: props.search.ai_recommendation,
//     });
// };

const submit = () => {
    router.post(route("flights.payment"), {
        ...props.booking,

        passenger_count: props.search.passenger_count,
        seat_class: props.search.seat_class,

        direct_flight: props.search.direct_flight,
        ai_recommendation: props.search.ai_recommendation,
    });
};

const totalPrice = props.flight.price * props.booking.passengers.length;
</script>

<template>
    <GuestLayout title="Review Booking">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold tracking-tight">
                    Konfirmasi Pemesanan
                </h1>

                <p class="mt-3 max-w-2xl text-muted-foreground">
                    Periksa kembali informasi penerbangan, data kontak, dan data
                    penumpang sebelum melanjutkan ke proses pembayaran.
                </p>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <!-- LEFT -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Informasi Penerbangan -->
                    <Card class="overflow-hidden rounded-2xl shadow-lg">
                        <!-- Header -->
                        <div
                            class="bg-gradient-to-r from-emerald-600 to-emerald-500 px-6 py-5 text-white"
                        >
                            <div class="flex items-center gap-3">
                                <Plane class="h-6 w-6" />

                                <div>
                                    <h2 class="text-xl font-bold">
                                        Informasi Penerbangan
                                    </h2>

                                    <p class="mt-1 text-sm text-emerald-100">
                                        Berikut detail penerbangan yang telah
                                        Anda pilih.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <CardContent class="p-6">
                            <div
                                class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between"
                            >
                                <!-- Airline -->
                                <div class="min-w-[220px]">
                                    <h3 class="text-lg font-bold">
                                        {{ flight.airline.name }}
                                    </h3>

                                    <p class="text-sm text-muted-foreground">
                                        {{ flight.flight_number }}
                                    </p>
                                </div>

                                <!-- Route -->
                                <div class="flex-1">
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div>
                                            <p class="text-3xl font-bold">
                                                {{
                                                    formatTime(
                                                        flight.scheduled_departure,
                                                    )
                                                }}
                                            </p>

                                            <p class="font-semibold">
                                                {{
                                                    flight.departure_airport
                                                        .code
                                                }}
                                            </p>

                                            <p
                                                class="text-sm text-muted-foreground"
                                            >
                                                {{
                                                    flight.departure_airport
                                                        .city
                                                }}
                                            </p>
                                        </div>

                                        <div class="mx-8 flex-1 text-center">
                                            <p
                                                class="text-xs text-muted-foreground"
                                            >
                                                {{
                                                    getDuration(
                                                        flight.scheduled_departure,
                                                        flight.scheduled_arrival,
                                                    )
                                                }}
                                            </p>

                                            <div class="relative my-3">
                                                <div
                                                    class="h-px bg-border"
                                                ></div>

                                                <Plane
                                                    class="absolute left-1/2 top-0 h-5 w-5 -translate-x-1/2 -translate-y-1/2 text-emerald-600"
                                                />
                                            </div>

                                            <p
                                                class="text-xs text-muted-foreground"
                                            >
                                                Penerbangan Langsung
                                            </p>
                                        </div>

                                        <div class="text-right">
                                            <p class="text-3xl font-bold">
                                                {{
                                                    formatTime(
                                                        flight.scheduled_arrival,
                                                    )
                                                }}
                                            </p>

                                            <p class="font-semibold">
                                                {{
                                                    flight.arrival_airport.code
                                                }}
                                            </p>

                                            <p
                                                class="text-sm text-muted-foreground"
                                            >
                                                {{
                                                    flight.arrival_airport.city
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Data Penumpang -->
                    <Card class="overflow-hidden rounded-2xl shadow-lg">
                        <!-- Header -->
                        <div
                            class="bg-gradient-to-r from-emerald-600 to-emerald-500 px-6 py-5 text-white"
                        >
                            <div class="flex items-center gap-3">
                                <User class="h-6 w-6" />

                                <div>
                                    <h2 class="text-xl font-bold">
                                        Data Penumpang
                                    </h2>

                                    <p class="mt-1 text-sm text-emerald-100">
                                        Pastikan seluruh data penumpang telah
                                        sesuai dengan dokumen identitas.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <CardContent class="space-y-5 p-6">
                            <div
                                v-for="(passenger, index) in booking.passengers"
                                :key="index"
                                class="rounded-2xl border bg-muted/30 p-5"
                            >
                                <div
                                    class="mb-4 flex items-center justify-between"
                                >
                                    <h3 class="text-lg font-semibold">
                                        Penumpang {{ index + 1 }}
                                    </h3>

                                    <Badge
                                        class="bg-emerald-100 text-emerald-700 hover:bg-emerald-100"
                                    >
                                        Dewasa
                                    </Badge>
                                </div>

                                <div class="grid gap-5 md:grid-cols-2">
                                    <div>
                                        <p
                                            class="text-xs text-muted-foreground"
                                        >
                                            Nama Lengkap
                                        </p>

                                        <p class="mt-1 font-medium">
                                            {{ passenger.full_name }}
                                        </p>
                                    </div>

                                    <div>
                                        <p
                                            class="text-xs text-muted-foreground"
                                        >
                                            Jenis Identitas
                                        </p>

                                        <p class="mt-1 font-medium">
                                            {{
                                                passenger.identity_type ===
                                                "nik"
                                                    ? "KTP / NIK"
                                                    : "Paspor"
                                            }}
                                        </p>
                                    </div>

                                    <div class="md:col-span-2">
                                        <p
                                            class="text-xs text-muted-foreground"
                                        >
                                            Nomor Identitas
                                        </p>

                                        <p class="mt-1 font-medium">
                                            {{ passenger.identity_number }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- RIGHT -->
                <div>
                    <Card
                        class="sticky top-24 overflow-hidden rounded-2xl shadow-lg"
                    >
                        <!-- Header -->
                        <div
                            class="bg-gradient-to-r from-emerald-600 to-emerald-500 px-6 py-5 text-white"
                        >
                            <h2 class="text-xl font-bold">
                                Ringkasan Pembayaran
                            </h2>

                            <p class="mt-1 text-sm text-emerald-100">
                                Berikut rincian biaya yang akan dibayarkan untuk
                                pemesanan penerbangan Anda.
                            </p>
                        </div>

                        <CardContent class="space-y-5 p-6">
                            <!-- Harga Tiket -->
                            <div
                                class="flex items-center justify-between rounded-xl border bg-muted/30 p-4"
                            >
                                <div>
                                    <p class="text-xs text-muted-foreground">
                                        Harga Tiket
                                    </p>

                                    <p class="mt-1 font-semibold">
                                        {{ flight.airline.name }}
                                    </p>
                                </div>

                                <span class="font-semibold">
                                    Rp {{ formatPrice(flight.price) }}
                                </span>
                            </div>

                            <!-- Pajak -->
                            <div
                                class="flex items-center justify-between rounded-xl border bg-muted/30 p-4"
                            >
                                <div>
                                    <p class="text-xs text-muted-foreground">
                                        Pajak Bandara
                                    </p>

                                    <p class="mt-1 font-semibold">
                                        Biaya wajib bandara
                                    </p>
                                </div>

                                <span class="font-semibold"> Rp 150.000 </span>
                            </div>

                            <!-- Biaya Layanan -->
                            <div
                                class="flex items-center justify-between rounded-xl border bg-muted/30 p-4"
                            >
                                <div>
                                    <p class="text-xs text-muted-foreground">
                                        Biaya Layanan
                                    </p>

                                    <p class="mt-1 font-semibold">
                                        Biaya administrasi
                                    </p>
                                </div>

                                <span class="font-semibold"> Rp 50.000 </span>
                            </div>

                            <!-- Asuransi -->
                            <div
                                class="flex items-center justify-between rounded-xl border bg-muted/30 p-4"
                            >
                                <div>
                                    <p class="text-xs text-muted-foreground">
                                        Asuransi Perjalanan
                                    </p>

                                    <p class="mt-1 font-semibold">
                                        Perlindungan selama perjalanan
                                    </p>
                                </div>

                                <span class="font-semibold"> Rp 25.000 </span>
                            </div>

                            <!-- Divider -->
                            <div class="border-t border-dashed"></div>

                            <!-- Total -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-muted-foreground">
                                        Total Pembayaran
                                    </p>

                                    <p
                                        class="bg-gradient-to-r from-emerald-700 via-emerald-600 to-emerald-500 bg-clip-text text-3xl font-bold text-transparent"
                                    >
                                        Rp {{ formatPrice(totalPrice) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Informasi -->
                            <div
                                class="flex gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4"
                            >
                                <ShieldCheck
                                    class="mt-0.5 h-5 w-5 text-emerald-600"
                                />

                                <div>
                                    <p class="font-medium text-emerald-700">
                                        Pembayaran Aman
                                    </p>

                                    <p
                                        class="mt-1 text-sm text-muted-foreground"
                                    >
                                        Seluruh proses pemesanan dan pembayaran
                                        dilindungi dengan sistem keamanan
                                        FlightHub.
                                    </p>
                                </div>
                            </div>

                            <!-- Tombol -->
                            <Button
                                size="lg"
                                class="h-11 w-full rounded-xl bg-gradient-to-r from-emerald-600 via-emerald-500 to-green-500 text-white shadow-md transition-all duration-300 hover:scale-[1.02] hover:from-emerald-700 hover:via-emerald-600 hover:to-green-600"
                                @click="submit"
                            >
                                <CreditCard class="mr-2 h-4 w-4" />

                                Lanjut ke Pembayaran
                            </Button>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
