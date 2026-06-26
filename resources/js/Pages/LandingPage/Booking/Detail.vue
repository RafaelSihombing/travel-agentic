<script setup>
import { Button } from "@/Components/ui/button";

import { Card, CardContent } from "@/Components/ui/card";

import { Badge } from "@/Components/ui/badge";

import { AlertTriangle, Printer, Share2 } from "lucide-vue-next";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { CircleAlert, Lightbulb, Search, Bell } from "lucide-vue-next";
import { Head, Link } from "@inertiajs/vue3";
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from "@/Components/ui/breadcrumb";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/Components/ui/table";

const getLogIcon = (event) => {
    switch (event) {
        case "flight_delayed":
            return CircleAlert;

        case "agent_analyzed":
            return Lightbulb;

        case "alternative_flight_found":
            return Search;

        case "recommendation_generated":
            return Bell;

        default:
            return CircleAlert;
    }
};

const getLogColor = (event) => {
    switch (event) {
        case "flight_delayed":
            return "border-red-500 text-red-500";

        case "agent_analyzed":
            return "border-emerald-500 text-emerald-500";

        case "alternative_flight_found":
            return "border-emerald-500 text-emerald-500";

        case "recommendation_generated":
            return "bg-emerald-600 text-white border-emerald-600";

        default:
            return "border-slate-300";
    }
};

const getLogTitle = (log) => {
    switch (log.recommendation_type) {
        case "alternative_flight":
            return "Penerbangan Alternatif Ditemukan";

        case "delay_warning":
            return "Peringatan Keterlambatan";

        case "compensation":
            return "Rekomendasi Kompensasi";

        case "refund":
            return "Rekomendasi Refund";

        case "info":
            return "Informasi Penerbangan";

        default:
            return "Aktivitas Agen";
    }
};

const formatDateTime = (date) => {
    if (!date) return "-";

    return new Date(date).toLocaleString("id-ID", {
        dateStyle: "long",
        timeStyle: "short",
    });
};

defineOptions({
    layout: GuestLayout,
});

const props = defineProps({
    booking: Object,
});
</script>

<template>
    <Head title="Detail Pemsanan" />

    <div class="mx-auto max-w-7xl px-6 py-8">
        <Breadcrumb class="mb-6">
            <BreadcrumbList>
                <BreadcrumbItem>
                    <BreadcrumbLink as-child>
                        <Link href="/"> Home </Link>
                    </BreadcrumbLink>
                </BreadcrumbItem>

                <BreadcrumbSeparator />

                <BreadcrumbItem>
                    <BreadcrumbLink as-child>
                        <Link :href="route('my-bookings.index')">
                            My Bookings
                        </Link>
                    </BreadcrumbLink>
                </BreadcrumbItem>

                <BreadcrumbSeparator />

                <BreadcrumbItem>
                    <BreadcrumbPage class="font-semibold text-emerald-600">
                        {{ props.booking.booking_code }}
                    </BreadcrumbPage>
                </BreadcrumbItem>
            </BreadcrumbList>
        </Breadcrumb>

        <!-- Header -->
        <div class="mb-8 flex items-start justify-between">
            <div>
                <h1 class="text-4xl font-bold">Detail Pemesanan</h1>

                <p class="mt-2 text-muted-foreground">
                    Lihat informasi pemesanan, data penumpang, status
                    penerbangan, serta rekomendasi perjalanan yang diberikan
                    oleh sistem.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <!-- Flight Delay -->
            <div class="xl:col-span-2 space-y-8">
                <Card
                    v-if="booking.recommendations.length"
                    class="border-red-200 bg-red-50/50"
                >
                    <CardContent class="p-8">
                        <div
                            class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between"
                        >
                            <!-- Content -->
                            <div class="flex gap-5">
                                <!-- Icon -->
                                <div
                                    class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-red-100"
                                >
                                    <AlertTriangle
                                        class="h-7 w-7 text-red-600"
                                    />
                                </div>

                                <div class="flex-1">
                                    <h2 class="text-3xl font-bold">
                                        {{ booking.recommendations[0].title }}
                                    </h2>

                                    <p
                                        class="mt-3 leading-relaxed text-muted-foreground"
                                    >
                                        {{ booking.recommendations[0].message }}
                                    </p>
                                </div>
                            </div>

                            <!-- Severity -->
                            <Badge
                                class="uppercase"
                                :class="{
                                    'bg-emerald-600 hover:bg-emerald-600':
                                        booking.recommendations[0].severity ===
                                        'low',

                                    'bg-yellow-500 hover:bg-yellow-500':
                                        booking.recommendations[0].severity ===
                                        'medium',

                                    'bg-orange-500 hover:bg-orange-500':
                                        booking.recommendations[0].severity ===
                                        'high',

                                    'bg-red-600 hover:bg-red-600':
                                        booking.recommendations[0].severity ===
                                        'critical',
                                }"
                            >
                                {{ booking.recommendations[0].severity }}
                            </Badge>
                        </div>

                        <!-- Rekomendasi -->
                        <Card class="mt-6 shadow-none">
                            <CardContent class="p-5">
                                <h4
                                    class="text-sm font-semibold text-muted-foreground"
                                >
                                    Rekomendasi Sistem
                                </h4>

                                <p class="mt-2 leading-relaxed">
                                    {{
                                        booking.recommendations[0]
                                            .suggested_action
                                    }}
                                </p>
                            </CardContent>
                        </Card>

                        <!-- Action -->
                        <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                            <Button
                                v-if="
                                    booking.recommendations[0]
                                        .recommendation_type ===
                                    'alternative_flight'
                                "
                                class="bg-emerald-600 hover:bg-emerald-700"
                            >
                                Lihat Penerbangan Alternatif
                            </Button>

                            <Button
                                v-else-if="
                                    booking.recommendations[0]
                                        .recommendation_type === 'refund'
                                "
                                variant="destructive"
                            >
                                Ajukan Refund
                            </Button>

                            <Button
                                v-else-if="
                                    booking.recommendations[0]
                                        .recommendation_type === 'compensation'
                                "
                                class="bg-orange-600 hover:bg-orange-700"
                            >
                                Klaim Kompensasi
                            </Button>

                            <Button v-else variant="outline">
                                Lihat Status Penerbangan
                            </Button>
                        </div>
                    </CardContent>
                </Card>

                <!-- Booking Summary -->
                <Card>
                    <CardContent class="p-8">
                        <!-- Airline Header -->

                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 rounded-lg border" />

                                <div>
                                    <h2 class="text-4xl font-semibold">
                                        {{ booking.flight.airline.name }}
                                    </h2>

                                    <p class="text-muted-foreground capitalize">
                                        {{ booking.flight.flight_number }}
                                        •
                                        {{ booking.seat_class }}
                                    </p>
                                </div>
                            </div>

                            <div class="text-right">
                                <Badge
                                    class="bg-emerald-100 text-emerald-700 capitalize"
                                >
                                    {{ booking.booking_status }}
                                    &
                                    {{ booking.payment_status }}
                                </Badge>

                                <p class="mt-3 text-sm text-muted-foreground">
                                    Booking Code:
                                    <strong>{{ booking.booking_code }}</strong>
                                </p>
                            </div>
                        </div>

                        <!-- Route -->

                        <div class="mt-12 flex items-center justify-between">
                            <div>
                                <h1 class="text-7xl font-bold">
                                    {{ booking.flight.departure_airport.code }}
                                </h1>

                                <p class="mt-2">
                                    {{ booking.flight.departure_airport.city }}
                                    ({{
                                        booking.flight.departure_airport.name
                                    }})
                                </p>

                                <p class="mt-3 text-xl font-medium">
                                    {{
                                        new Date(
                                            booking.flight.scheduled_departure,
                                        ).toLocaleString("id-ID", {
                                            dateStyle: "long",
                                            timeStyle: "short",
                                        })
                                    }}
                                </p>
                            </div>

                            <div class="flex flex-col items-center">
                                <p class="text-sm font-medium">
                                    {{ booking.flight.duration ?? "-" }}
                                </p>

                                <div
                                    class="my-3 h-px w-40 border-t border-dashed"
                                />

                                <p class="text-sm text-emerald-600">
                                    {{
                                        booking.flight.is_direct
                                            ? "✈ Penerbangan Langsung"
                                            : "✈ Transit"
                                    }}
                                </p>
                            </div>

                            <div class="text-right">
                                <h1 class="text-7xl font-bold">
                                    {{ booking.flight.arrival_airport.code }}
                                </h1>

                                <p class="mt-2">
                                    {{ booking.flight.arrival_airport.city }}
                                    ({{ booking.flight.arrival_airport.name }})
                                </p>

                                <p class="mt-3 text-xl font-medium">
                                    {{
                                        new Date(
                                            booking.flight.scheduled_arrival,
                                        ).toLocaleString("id-ID", {
                                            dateStyle: "long",
                                            timeStyle: "short",
                                        })
                                    }}
                                </p>
                            </div>
                        </div>

                        <!-- Detail -->

                        <div
                            class="mt-10 grid grid-cols-2 gap-6 border-t pt-8 lg:grid-cols-4"
                        >
                            <!-- Passenger -->

                            <div>
                                <p
                                    class="text-xs uppercase text-muted-foreground"
                                >
                                    Penumpang
                                </p>

                                <p class="mt-2 font-semibold">
                                    {{ booking.passenger_count }}
                                    Orang
                                </p>
                            </div>

                            <!-- Seat -->

                            <div>
                                <p
                                    class="text-xs uppercase text-muted-foreground"
                                >
                                    Kelas
                                </p>

                                <p class="mt-2 font-semibold capitalize">
                                    {{ booking.seat_class }}
                                </p>
                            </div>

                            <!-- Booking -->

                            <div>
                                <p
                                    class="text-xs uppercase text-muted-foreground"
                                >
                                    Status Booking
                                </p>

                                <p class="mt-2 font-semibold capitalize">
                                    {{ booking.booking_status }}
                                </p>
                            </div>

                            <!-- Payment -->

                            <div>
                                <p
                                    class="text-xs uppercase text-muted-foreground"
                                >
                                    Pembayaran
                                </p>

                                <p class="mt-2 font-semibold capitalize">
                                    {{ booking.payment_status }}
                                </p>
                            </div>
                        </div>

                        <!-- Footer -->

                        <div
                            class="mt-10 flex flex-col gap-3 border-t pt-8 sm:flex-row sm:justify-between sm:items-center"
                        >
                            <div>
                                <p class="text-muted-foreground">
                                    Total Pembayaran
                                </p>

                                <h2 class="text-4xl font-bold text-emerald-600">
                                    Rp
                                    {{
                                        Number(
                                            booking.total_price,
                                        ).toLocaleString("id-ID")
                                    }}
                                </h2>
                            </div>

                            <div class="flex flex-col gap-3 sm:flex-row">
                                <Button variant="outline">
                                    Download E-Ticket
                                </Button>

                                <Button variant="secondary">
                                    Hubungi Support
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Flight Status -->
                <Card>
                    <CardContent class="p-8">
                        <!-- Header -->
                        <div
                            class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"
                        >
                            <h2 class="text-3xl font-semibold">
                                Status Penerbangan
                            </h2>

                            <div
                                class="flex items-center gap-2 font-medium capitalize"
                                :class="{
                                    'text-emerald-600':
                                        booking.flight.flight_status.status ===
                                        'on_time',

                                    'text-blue-600':
                                        booking.flight.flight_status.status ===
                                        'boarding',

                                    'text-red-600':
                                        booking.flight.flight_status.status ===
                                        'delayed',

                                    'text-orange-600':
                                        booking.flight.flight_status.status ===
                                        'departed',

                                    'text-slate-600':
                                        booking.flight.flight_status.status ===
                                        'arrived',
                                }"
                            >
                                <span
                                    class="size-3 rounded-full"
                                    :class="{
                                        'bg-emerald-600':
                                            booking.flight.flight_status
                                                .status === 'on_time',

                                        'bg-blue-600':
                                            booking.flight.flight_status
                                                .status === 'boarding',

                                        'bg-red-600':
                                            booking.flight.flight_status
                                                .status === 'delayed',

                                        'bg-orange-600':
                                            booking.flight.flight_status
                                                .status === 'departed',

                                        'bg-slate-600':
                                            booking.flight.flight_status
                                                .status === 'arrived',
                                    }"
                                />

                                <template
                                    v-if="
                                        booking.flight.flight_status.status ===
                                        'delayed'
                                    "
                                >
                                    Delay
                                    {{
                                        booking.flight.flight_status
                                            .delay_minutes
                                    }}
                                    Menit
                                </template>

                                <template v-else>
                                    {{ booking.flight.flight_status.status }}
                                </template>
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div class="mt-10">
                            <div class="relative">
                                <!-- Background Line -->
                                <div
                                    class="absolute left-0 right-0 top-5 h-1 rounded-full bg-slate-200"
                                />

                                <!-- Progress -->
                                <div
                                    class="absolute left-0 top-5 h-1 rounded-full"
                                    :class="{
                                        'bg-emerald-600 w-full':
                                            booking.flight.flight_status
                                                .status === 'arrived',

                                        'bg-orange-500 w-2/3':
                                            booking.flight.flight_status
                                                .status === 'departed',

                                        'bg-red-500 w-1/2':
                                            booking.flight.flight_status
                                                .status === 'delayed',

                                        'bg-blue-500 w-1/4':
                                            booking.flight.flight_status
                                                .status === 'boarding',

                                        'bg-emerald-600 w-1/4':
                                            booking.flight.flight_status
                                                .status === 'on_time',
                                    }"
                                />

                                <div class="relative flex justify-between">
                                    <!-- Departure -->
                                    <div class="text-center">
                                        <div
                                            class="mx-auto flex size-10 items-center justify-center rounded-full bg-emerald-600 text-white"
                                        >
                                            ✓
                                        </div>

                                        <p class="mt-4 font-medium">
                                            {{
                                                new Date(
                                                    booking.flight
                                                        .scheduled_departure,
                                                ).toLocaleTimeString("id-ID", {
                                                    hour: "2-digit",
                                                    minute: "2-digit",
                                                })
                                            }}
                                        </p>

                                        <p
                                            class="text-sm text-muted-foreground"
                                        >
                                            Keberangkatan
                                        </p>
                                    </div>

                                    <!-- Current -->
                                    <div class="text-center">
                                        <div
                                            class="mx-auto flex size-12 items-center justify-center rounded-full border-4 border-red-200 bg-red-500 text-white"
                                        >
                                            ✈
                                        </div>

                                        <p
                                            class="mt-4 font-medium text-red-600"
                                        >
                                            {{
                                                booking.flight.flight_status
                                                    .delay_minutes
                                            }}
                                            Menit
                                        </p>

                                        <p class="text-sm text-red-500">
                                            {{
                                                booking.flight.flight_status
                                                    .status
                                            }}
                                        </p>
                                    </div>

                                    <!-- Arrival -->
                                    <div class="text-center">
                                        <div
                                            class="mx-auto flex size-10 items-center justify-center rounded-full bg-slate-200"
                                        >
                                            🛬
                                        </div>

                                        <p class="mt-4 font-medium">
                                            {{
                                                new Date(
                                                    booking.flight
                                                        .scheduled_arrival,
                                                ).toLocaleTimeString("id-ID", {
                                                    hour: "2-digit",
                                                    minute: "2-digit",
                                                })
                                            }}
                                        </p>

                                        <p
                                            class="text-sm text-muted-foreground"
                                        >
                                            Tiba
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Passenger Information -->
                <Card class="mt-8">
                    <CardContent class="p-0">
                        <!-- Header -->
                        <div class="border-b p-8">
                            <h2 class="text-3xl font-semibold">
                                Informasi Penumpang
                            </h2>
                        </div>

                        <!-- Desktop -->
                        <div class="hidden overflow-x-auto lg:block">
                            <Table>
                                <TableHeader>
                                    <TableRow class="bg-slate-50">
                                        <TableHead class="w-[35%]">
                                            Nama Lengkap
                                        </TableHead>

                                        <TableHead> Kewarganegaraan </TableHead>

                                        <TableHead> Tipe </TableHead>

                                        <TableHead> Nomor Identitas </TableHead>
                                    </TableRow>
                                </TableHeader>

                                <TableBody>
                                    <TableRow
                                        v-for="passenger in booking.passengers"
                                        :key="passenger.id"
                                    >
                                        <TableCell class="font-medium">
                                            {{ passenger.full_name }}
                                        </TableCell>

                                        <TableCell>
                                            {{ passenger.nationality }}
                                        </TableCell>

                                        <TableCell>
                                            <Badge
                                                variant="secondary"
                                                class="capitalize"
                                            >
                                                {{ passenger.passenger_type }}
                                            </Badge>
                                        </TableCell>

                                        <TableCell>
                                            {{ passenger.identity_number }}
                                        </TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>

                        <!-- Mobile -->
                        <div class="space-y-4 p-5 lg:hidden">
                            <Card
                                v-for="passenger in booking.passengers"
                                :key="passenger.id"
                            >
                                <CardContent class="space-y-3 p-5">
                                    <div>
                                        <p
                                            class="text-xs uppercase text-muted-foreground"
                                        >
                                            Nama Lengkap
                                        </p>

                                        <p class="font-semibold">
                                            {{ passenger.full_name }}
                                        </p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p
                                                class="text-xs uppercase text-muted-foreground"
                                            >
                                                Kewarganegaraan
                                            </p>

                                            <p>
                                                {{ passenger.nationality }}
                                            </p>
                                        </div>

                                        <div>
                                            <p
                                                class="text-xs uppercase text-muted-foreground"
                                            >
                                                Tipe
                                            </p>

                                            <Badge
                                                variant="secondary"
                                                class="mt-1 capitalize"
                                            >
                                                {{ passenger.passenger_type }}
                                            </Badge>
                                        </div>
                                    </div>

                                    <div>
                                        <p
                                            class="text-xs uppercase text-muted-foreground"
                                        >
                                            Nomor Identitas
                                        </p>

                                        <p>
                                            {{ passenger.identity_number }}
                                        </p>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>
                    </CardContent>
                </Card>

                <!-- Recommendation -->
                <Card>
                    <CardContent class="p-8">
                        <div class="mb-8 flex items-center gap-3">
                            <div
                                class="flex size-10 items-center justify-center rounded-full bg-emerald-100"
                            >
                                ✨
                            </div>

                            <h2 class="text-3xl font-semibold">
                                Agent Recommendation: Alternative Flight
                            </h2>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Current Flight -->

                            <div class="rounded-xl border bg-slate-50 p-6">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-muted-foreground">
                                        PENERBANGAN SAAT INI
                                    </p>

                                    <Badge variant="destructive">
                                        {{
                                            booking.flight.flight_status.status.toUpperCase()
                                        }}
                                    </Badge>
                                </div>

                                <h3 class="mt-8 text-2xl font-semibold">
                                    {{ booking.flight.flight_number }}
                                    -
                                    {{ booking.flight.airline.name }}
                                </h3>

                                <p class="mt-2 text-muted-foreground">
                                    {{
                                        new Date(
                                            booking.flight.scheduled_departure,
                                        ).toLocaleTimeString("id-ID", {
                                            hour: "2-digit",
                                            minute: "2-digit",
                                        })
                                    }}
                                    -
                                    {{
                                        new Date(
                                            booking.flight.scheduled_arrival,
                                        ).toLocaleTimeString("id-ID", {
                                            hour: "2-digit",
                                            minute: "2-digit",
                                        })
                                    }}
                                </p>
                            </div>

                            <!-- Alternative -->

                            <!-- Alternative Flight -->
                            <div
                                v-if="
                                    booking.flight.alternative_flights?.length
                                "
                                class="relative rounded-xl border-2 border-emerald-600 bg-emerald-50 p-6"
                            >
                                <Badge
                                    class="absolute -top-3 left-4 bg-emerald-600"
                                >
                                    Direkomendasikan
                                </Badge>

                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-muted-foreground">
                                        PENERBANGAN BARU
                                    </p>

                                    <Badge
                                        :variant="
                                            booking.flight
                                                .alternative_flights[0]
                                                .alternative_flight
                                                .flight_status.status ===
                                            'on_time'
                                                ? 'default'
                                                : 'secondary'
                                        "
                                    >
                                        {{
                                            booking.flight
                                                .alternative_flights[0]
                                                .alternative_flight
                                                .flight_status.status
                                        }}
                                    </Badge>
                                </div>

                                <h3 class="mt-8 text-2xl font-semibold">
                                    {{
                                        booking.flight.alternative_flights[0]
                                            .alternative_flight.flight_number
                                    }}
                                    -
                                    {{
                                        booking.flight.alternative_flights[0]
                                            .alternative_flight.airline.name
                                    }}
                                </h3>

                                <p class="mt-2 text-muted-foreground">
                                    {{
                                        new Date(
                                            booking.flight
                                                .alternative_flights[0]
                                                .alternative_flight
                                                .scheduled_departure,
                                        ).toLocaleTimeString("id-ID", {
                                            hour: "2-digit",
                                            minute: "2-digit",
                                        })
                                    }}

                                    -

                                    {{
                                        new Date(
                                            booking.flight
                                                .alternative_flights[0]
                                                .alternative_flight
                                                .scheduled_arrival,
                                        ).toLocaleTimeString("id-ID", {
                                            hour: "2-digit",
                                            minute: "2-digit",
                                        })
                                    }}
                                </p>
                            </div>

                            <!-- Tidak ada alternatif -->
                            <div
                                v-else
                                class="flex items-center justify-center rounded-xl border border-dashed p-6 text-center"
                            >
                                <div>
                                    <p class="font-semibold">
                                        Tidak ada penerbangan alternatif
                                    </p>

                                    <p
                                        class="mt-2 text-sm text-muted-foreground"
                                    >
                                        Sistem belum menemukan penerbangan lain
                                        yang sesuai.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- AI Message -->

                        <div
                            class="mt-8 flex items-center justify-between rounded-xl border p-6"
                        >
                            <div
                                class="max-w-xl border-l-4 border-emerald-200 pl-4 italic text-muted-foreground"
                            >
                                "{{ booking.recommendations[0].message }}"

                                <p
                                    class="mt-3 text-sm font-medium text-emerald-600"
                                >
                                    — FlightHub AI Agent
                                </p>
                            </div>

                            <Button
                                v-if="
                                    booking.recommendations[0]
                                        .recommendation_type ===
                                    'alternative_flight'
                                "
                                size="lg"
                            >
                                Rebook Sekarang
                            </Button>

                            <Button
                                v-else-if="
                                    booking.recommendations[0]
                                        .recommendation_type === 'compensation'
                                "
                                size="lg"
                                variant="secondary"
                            >
                                Klaim Kompensasi
                            </Button>

                            <Button
                                v-else-if="
                                    booking.recommendations[0]
                                        .recommendation_type === 'refund'
                                "
                                variant="destructive"
                                size="lg"
                            >
                                Ajukan Refund
                            </Button>
                        </div>
                    </CardContent>
                </Card>

                <!-- Activity Log -->
                <Card>
                    <CardContent class="p-8">
                        <h2 class="mb-8 text-3xl font-semibold">
                            Riwayat Aktivitas Agen
                        </h2>

                        <div class="space-y-8">
                            <div
                                v-for="(log, index) in booking.agent_logs"
                                :key="log.id"
                                class="relative flex gap-5"
                            >
                                <!-- Timeline -->

                                <div
                                    v-if="
                                        index !== booking.agent_logs.length - 1
                                    "
                                    class="absolute left-5 top-12 h-full w-px bg-slate-200"
                                ></div>

                                <!-- Icon -->

                                <div
                                    class="z-10 flex size-10 items-center justify-center rounded-full border-2 bg-white"
                                    :class="getLogColor(log.trigger_event)"
                                >
                                    <component
                                        :is="getLogIcon(log.trigger_event)"
                                        class="size-4"
                                    />
                                </div>

                                <!-- Content -->

                                <div class="flex-1 pb-6">
                                    <div
                                        class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between"
                                    >
                                        <h3 class="font-semibold">
                                            {{ getLogTitle(log) }}
                                        </h3>

                                        <Badge
                                            variant="outline"
                                            class="capitalize w-fit"
                                        >
                                            {{ log.severity }}
                                        </Badge>
                                    </div>

                                    <p
                                        class="mt-2 text-muted-foreground leading-relaxed"
                                    >
                                        {{ log.message }}
                                    </p>

                                    <div
                                        class="mt-4 flex flex-wrap items-center gap-4 text-sm text-muted-foreground"
                                    >
                                        <span>
                                            Trigger :
                                            <strong class="capitalize">
                                                {{
                                                    log.trigger_event.replaceAll(
                                                        "_",
                                                        " ",
                                                    )
                                                }}
                                            </strong>
                                        </span>

                                        <span v-if="log.delay_minutes">
                                            Delay :
                                            <strong>
                                                {{ log.delay_minutes }} Menit
                                            </strong>
                                        </span>
                                    </div>

                                    <p
                                        class="mt-3 text-xs text-muted-foreground"
                                    >
                                        {{ formatDateTime(log.created_at) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Summary -->

            <div>
                <Card>
                    <CardContent class="p-8">
                        <h2 class="text-2xl font-bold">Ringkasan</h2>

                        <div class="mt-8 space-y-6">
                            <!-- Booking Status -->
                            <div class="flex items-center justify-between">
                                <span class="text-muted-foreground">
                                    Status Booking
                                </span>

                                <Badge
                                    class="capitalize"
                                    :class="{
                                        'bg-emerald-600 hover:bg-emerald-600':
                                            booking.booking_status === 'booked',

                                        'bg-red-600 hover:bg-red-600':
                                            booking.booking_status ===
                                            'cancelled',

                                        'bg-slate-600 hover:bg-slate-600':
                                            booking.booking_status ===
                                            'completed',
                                    }"
                                >
                                    {{ booking.booking_status }}
                                </Badge>
                            </div>

                            <!-- Payment -->
                            <div class="flex items-center justify-between">
                                <span class="text-muted-foreground">
                                    Status Pembayaran
                                </span>

                                <Badge
                                    class="capitalize"
                                    :class="{
                                        'bg-emerald-600 hover:bg-emerald-600':
                                            booking.payment_status === 'paid',

                                        'bg-yellow-500 hover:bg-yellow-500':
                                            booking.payment_status ===
                                            'pending',

                                        'bg-red-600 hover:bg-red-600':
                                            booking.payment_status === 'failed',
                                    }"
                                >
                                    {{ booking.payment_status }}
                                </Badge>
                            </div>

                            <!-- Priority -->
                            <div class="flex items-center justify-between">
                                <span class="text-muted-foreground">
                                    Prioritas
                                </span>

                                <Badge
                                    class="uppercase"
                                    :class="{
                                        'bg-emerald-600':
                                            booking.recommendations[0]
                                                ?.severity === 'low',

                                        'bg-yellow-500':
                                            booking.recommendations[0]
                                                ?.severity === 'medium',

                                        'bg-orange-500':
                                            booking.recommendations[0]
                                                ?.severity === 'high',

                                        'bg-red-600':
                                            booking.recommendations[0]
                                                ?.severity === 'critical',
                                    }"
                                >
                                    {{ booking.recommendations[0]?.severity }}
                                </Badge>
                            </div>

                            <!-- Booking Code -->
                            <div class="flex items-center justify-between">
                                <span class="text-muted-foreground">
                                    Kode Booking
                                </span>

                                <span class="font-semibold">
                                    {{ booking.booking_code }}
                                </span>
                            </div>

                            <!-- Seat Class -->
                            <div class="flex items-center justify-between">
                                <span class="text-muted-foreground">
                                    Kelas
                                </span>

                                <span class="font-semibold capitalize">
                                    {{ booking.seat_class }}
                                </span>
                            </div>

                            <!-- Passenger -->
                            <div class="flex items-center justify-between">
                                <span class="text-muted-foreground">
                                    Total Penumpang
                                </span>

                                <span class="font-semibold">
                                    {{ booking.passenger_count }} Orang
                                </span>
                            </div>
                        </div>

                        <!-- Boarding Information -->

                        <div class="mt-8 rounded-xl bg-slate-50 p-5">
                            <h4 class="font-semibold">Informasi Boarding</h4>

                            <p
                                class="mt-2 text-sm leading-relaxed text-muted-foreground"
                            >
                                Boarding biasanya dimulai sekitar
                                <strong>45 menit</strong>
                                sebelum jadwal keberangkatan. Pastikan Anda
                                sudah berada di area keberangkatan sebelum

                                <strong>
                                    {{
                                        new Date(
                                            booking.flight.scheduled_departure,
                                        ).toLocaleTimeString("id-ID", {
                                            hour: "2-digit",
                                            minute: "2-digit",
                                        })
                                    }} </strong
                                >.
                            </p>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </div>
</template>
