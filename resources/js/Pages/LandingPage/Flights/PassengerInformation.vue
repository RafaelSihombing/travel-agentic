<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";

import { useForm } from "@inertiajs/vue3";

import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import InputError from "@/Components/InputError.vue";

import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";

import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";

const props = defineProps({
    flight: {
        type: Object,
        required: true,
    },

    search: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    flight_id: props.flight.id,

    // ===== Search =====
    passenger_count: props.search.passenger_count,
    seat_class: props.search.seat_class,
    direct_flight: props.search.direct_flight,
    ai_recommendation: props.search.ai_recommendation,

    // ===== Contact =====
    contact_name: "",
    contact_email: "",
    contact_phone: "",

    // ===== Passenger =====
    passengers: Array.from({ length: props.search.passenger_count }, () => ({
        full_name: "",
        passenger_type: "adult",
        identity_type: "nik",
        identity_number: "",
    })),
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

const submit = () => {
    form.post(route("flights.review"));
};
</script>
<template>
    <GuestLayout title="Passenger Information">
        <div class="max-w-6xl mx-auto px-4 py-6">
            <!-- Header -->
            <h1 class="text-3xl font-bold">Informasi Penumpang</h1>

            <p class="mt-2 text-muted-foreground">
                Silakan lengkapi data penumpang sebelum melanjutkan ke halaman
                konfirmasi.
            </p>

            <div class="grid lg:grid-cols-3 gap-6 mt-4">
                <!-- Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Contact -->
                    <Card class="overflow-hidden rounded-2xl shadow-lg">
                        <!-- Header -->
                        <div
                            class="bg-gradient-to-r from-emerald-600 to-emerald-500 px-6 py-5 text-white"
                        >
                            <h2 class="text-xl font-bold">Informasi Kontak</h2>

                            <p class="mt-1 text-sm text-emerald-100">
                                Silakan isi informasi kontak yang akan digunakan
                                untuk menerima konfirmasi pemesanan tiket.
                            </p>
                        </div>

                        <CardContent class="space-y-5 p-6">
                            <!-- Nama Kontak -->
                            <div>
                                <label
                                    class="mb-2 block text-sm font-semibold text-foreground"
                                >
                                    Nama Lengkap
                                    <span class="text-red-500">*</span>
                                </label>

                                <Input
                                    v-model="form.contact_name"
                                    placeholder="Masukkan nama lengkap"
                                    class="h-11 rounded-xl"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.contact_name"
                                />
                            </div>

                            <!-- Email -->
                            <div>
                                <label
                                    class="mb-2 block text-sm font-semibold text-foreground"
                                >
                                    Alamat Email
                                    <span class="text-red-500">*</span>
                                </label>

                                <Input
                                    v-model="form.contact_email"
                                    type="email"
                                    placeholder="contoh@email.com"
                                    class="h-11 rounded-xl"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.contact_email"
                                />
                            </div>

                            <!-- Nomor Telepon -->
                            <div>
                                <label
                                    class="mb-2 block text-sm font-semibold text-foreground"
                                >
                                    Nomor Telepon
                                    <span class="text-red-500">*</span>
                                </label>

                                <Input
                                    v-model="form.contact_phone"
                                    placeholder="08xxxxxxxxxx"
                                    class="h-11 rounded-xl"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.contact_phone"
                                />
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Passenger -->
                    <Card
                        v-for="(passenger, index) in form.passengers"
                        :key="index"
                        class="overflow-hidden rounded-2xl shadow-lg"
                    >
                        <!-- Header -->
                        <div
                            class="bg-gradient-to-r from-emerald-600 to-emerald-500 px-6 py-5 text-white"
                        >
                            <h2 class="text-xl font-bold">
                                Penumpang {{ index + 1 }}
                            </h2>

                            <p class="mt-1 text-sm text-emerald-100">
                                Silakan lengkapi data identitas penumpang sesuai
                                dengan dokumen yang akan digunakan saat
                                melakukan perjalanan.
                            </p>
                        </div>

                        <CardContent class="space-y-5 p-6">
                            <!-- Nama Lengkap -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold">
                                    Nama Lengkap
                                    <span class="text-red-500">*</span>
                                </label>

                                <Input
                                    v-model="passenger.full_name"
                                    placeholder="Masukkan nama lengkap"
                                    class="h-11 rounded-xl"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="
                                        form.errors[
                                            `passengers.${index}.full_name`
                                        ]
                                    "
                                />
                            </div>

                            <!-- Jenis Identitas -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold">
                                    Jenis Identitas
                                    <span class="text-red-500">*</span>
                                </label>

                                <Select v-model="passenger.identity_type">
                                    <SelectTrigger class="h-11 rounded-xl">
                                        <SelectValue
                                            placeholder="Pilih jenis identitas"
                                        />
                                    </SelectTrigger>

                                    <SelectContent>
                                        <SelectItem value="nik">
                                            KTP / NIK
                                        </SelectItem>

                                        <SelectItem value="passport">
                                            Paspor
                                        </SelectItem>
                                    </SelectContent>
                                </Select>

                                <InputError
                                    class="mt-2"
                                    :message="
                                        form.errors[
                                            `passengers.${index}.identity_type`
                                        ]
                                    "
                                />
                            </div>

                            <!-- Nomor Identitas -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold">
                                    Nomor Identitas
                                    <span class="text-red-500">*</span>
                                </label>

                                <Input
                                    v-model="passenger.identity_number"
                                    placeholder="Masukkan nomor identitas"
                                    class="h-11 rounded-xl"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="
                                        form.errors[
                                            `passengers.${index}.identity_number`
                                        ]
                                    "
                                />
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Booking Summary -->

                <div>
                    <Card
                        class="sticky top-24 overflow-hidden rounded-2xl shadow-lg"
                    >
                        <!-- Header -->
                        <div
                            class="bg-gradient-to-r from-emerald-600 to-emerald-500 px-6 py-5 text-white"
                        >
                            <h2 class="text-xl font-bold">
                                Ringkasan Pemesanan
                            </h2>

                            <p class="mt-1 text-sm text-emerald-100">
                                Pastikan kembali detail penerbangan Anda sebelum
                                melanjutkan ke halaman konfirmasi.
                            </p>
                        </div>

                        <CardContent class="space-y-5 p-6">
                            <!-- Rute -->
                            <div
                                class="flex items-center justify-between rounded-xl border bg-muted/30 p-4"
                            >
                                <div>
                                    <p class="text-xs text-muted-foreground">
                                        Rute Penerbangan
                                    </p>

                                    <p class="mt-1 font-semibold">
                                        {{ flight.departure_airport.code }}
                                        →
                                        {{ flight.arrival_airport.code }}
                                    </p>
                                </div>

                                <Plane class="h-5 w-5 text-emerald-600" />
                            </div>

                            <!-- Maskapai -->
                            <div class="rounded-xl border bg-muted/30 p-4">
                                <p class="text-xs text-muted-foreground">
                                    Maskapai
                                </p>

                                <p class="mt-1 font-semibold">
                                    {{ flight.airline.name }}
                                </p>
                            </div>

                            <!-- Nomor Penerbangan -->
                            <div class="rounded-xl border bg-muted/30 p-4">
                                <p class="text-xs text-muted-foreground">
                                    Nomor Penerbangan
                                </p>

                                <p class="mt-1 font-semibold">
                                    {{ flight.flight_number }}
                                </p>
                            </div>

                            <!-- Jadwal -->
                            <div
                                class="flex items-center justify-between rounded-xl border bg-muted/30 p-4"
                            >
                                <div>
                                    <p class="text-xs text-muted-foreground">
                                        Keberangkatan
                                    </p>

                                    <p class="mt-1 font-semibold">
                                        {{
                                            formatTime(
                                                flight.scheduled_departure,
                                            )
                                        }}
                                    </p>
                                </div>

                                <div class="text-right">
                                    <p class="text-xs text-muted-foreground">
                                        Kedatangan
                                    </p>

                                    <p class="mt-1 font-semibold">
                                        {{
                                            formatTime(flight.scheduled_arrival)
                                        }}
                                    </p>
                                </div>
                            </div>

                            <!-- Jumlah Penumpang -->
                            <div class="rounded-xl border bg-muted/30 p-4">
                                <p class="text-xs text-muted-foreground">
                                    Jumlah Penumpang
                                </p>

                                <p class="mt-1 font-semibold">
                                    {{ search.passenger_count }}
                                    {{
                                        Number(search.passenger_count) > 1
                                            ? "Penumpang"
                                            : "Penumpang"
                                    }}
                                </p>
                            </div>

                            <!-- Kelas -->
                            <div class="rounded-xl border bg-muted/30 p-4">
                                <p class="text-xs text-muted-foreground">
                                    Kelas Kabin
                                </p>

                                <p class="mt-1 font-semibold capitalize">
                                    {{ search.seat_class }}
                                </p>
                            </div>

                            <!-- Tanggal -->
                            <div class="rounded-xl border bg-muted/30 p-4">
                                <p class="text-xs text-muted-foreground">
                                    Tanggal Keberangkatan
                                </p>

                                <p class="mt-1 font-semibold">
                                    {{ search.scheduled_departure }}
                                </p>
                            </div>

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
                                        Rp
                                        {{
                                            formatPrice(
                                                flight.price *
                                                    search.passenger_count,
                                            )
                                        }}
                                    </p>
                                </div>
                            </div>

                            <!-- Tombol -->
                            <Button
                                type="button"
                                class="h-11 w-full rounded-xl bg-gradient-to-r from-emerald-600 via-emerald-500 to-green-500 text-white shadow-md transition-all duration-300 hover:scale-[1.02] hover:from-emerald-700 hover:via-emerald-600 hover:to-green-600"
                                @click="submit"
                            >
                                Lanjut ke Konfirmasi
                            </Button>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
