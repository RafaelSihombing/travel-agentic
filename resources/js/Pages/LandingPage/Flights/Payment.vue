<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";

import { Button } from "@/Components/ui/button";

import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
    CardDescription,
} from "@/Components/ui/card";

import { RadioGroup, RadioGroupItem } from "@/Components/ui/radio-group";

import { Label } from "@/Components/ui/label";

import {
    CreditCard,
    Wallet,
    QrCode,
    Landmark,
    ShieldCheck,
} from "lucide-vue-next";

import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    booking: Object,
});

const paymentMethod = ref("va");

const formatPrice = (price) => {
    return new Intl.NumberFormat("id-ID").format(price);
};

const payNow = () => {
    router.post(route("flights.payment.process"), {
        booking_id: props.booking.id,
    });
};
</script>

<template>
    <GuestLayout title="Payment">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold tracking-tight">Pembayaran</h1>

                <p class="mt-2 text-muted-foreground">
                    Pilih metode pembayaran untuk menyelesaikan pemesanan tiket
                    Anda.
                </p>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                <!-- Payment Method -->
                <div class="lg:col-span-2">
                    <Card class="overflow-hidden rounded-2xl shadow-lg">
                        <div
                            class="bg-gradient-to-r from-emerald-600 to-emerald-500 px-6 py-5 text-white"
                        >
                            <h2 class="text-xl font-bold">Metode Pembayaran</h2>

                            <p class="mt-1 text-sm text-emerald-100">
                                Pilih salah satu metode pembayaran yang
                                tersedia.
                            </p>
                        </div>

                        <CardContent class="p-6">
                            <RadioGroup default-value="va" class="space-y-4">
                                <Label
                                    class="flex items-center justify-between rounded-lg border p-4 cursor-pointer"
                                >
                                    <div class="flex items-center gap-3">
                                        <Landmark class="h-5 w-5" />

                                        <div>
                                            <p class="font-medium">
                                                Virtual Account
                                            </p>

                                            <p
                                                class="text-sm text-muted-foreground"
                                            >
                                                BCA, BNI, Mandiri
                                            </p>
                                        </div>
                                    </div>

                                    <RadioGroupItem value="va" />
                                </Label>

                                <Label
                                    class="flex items-center justify-between rounded-lg border p-4 cursor-pointer"
                                >
                                    <div class="flex items-center gap-3">
                                        <QrCode class="h-5 w-5" />

                                        <div>
                                            <p class="font-medium">QRIS</p>

                                            <p
                                                class="text-sm text-muted-foreground"
                                            >
                                                Scan QR Code
                                            </p>
                                        </div>
                                    </div>

                                    <RadioGroupItem value="qris" />
                                </Label>

                                <Label
                                    class="flex items-center justify-between rounded-lg border p-4 cursor-pointer"
                                >
                                    <div class="flex items-center gap-3">
                                        <Wallet class="h-5 w-5" />

                                        <div>
                                            <p class="font-medium">E-Wallet</p>

                                            <p
                                                class="text-sm text-muted-foreground"
                                            >
                                                GoPay, OVO, Dana
                                            </p>
                                        </div>
                                    </div>

                                    <RadioGroupItem value="wallet" />
                                </Label>

                                <Label
                                    class="flex items-center justify-between rounded-lg border p-4 cursor-pointer"
                                >
                                    <div class="flex items-center gap-3">
                                        <CreditCard class="h-5 w-5" />

                                        <div>
                                            <p class="font-medium">
                                                Credit Card
                                            </p>

                                            <p
                                                class="text-sm text-muted-foreground"
                                            >
                                                Visa, Mastercard
                                            </p>
                                        </div>
                                    </div>

                                    <RadioGroupItem value="card" />
                                </Label>
                            </RadioGroup>
                        </CardContent>
                    </Card>
                </div>

                <!-- Summary -->
                <div>
                    <Card
                        class="sticky top-24 overflow-hidden rounded-2xl shadow-lg"
                    >
                        <div
                            class="bg-gradient-to-r from-emerald-600 to-emerald-500 px-6 py-5 text-white"
                        >
                            <h2 class="text-xl font-bold">
                                Ringkasan Pembayaran
                            </h2>

                            <p class="mt-1 text-sm text-emerald-100">
                                Pastikan seluruh informasi sudah benar.
                            </p>
                        </div>

                        <CardContent class="space-y-5 p-6">
                            <div>
                                <p class="text-xs text-muted-foreground">
                                    Kelas
                                </p>

                                <p class="font-semibold capitalize">
                                    {{ booking.seat_class }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-muted-foreground">
                                    Maskapai
                                </p>

                                <p class="font-semibold">
                                    {{ booking.flight.airline.name }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-muted-foreground">
                                    Jumlah Penumpang
                                </p>

                                <p class="font-semibold">
                                    {{ booking.passenger_count }}
                                    Orang
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-muted-foreground">
                                    Nomor Penerbangan
                                </p>

                                <p class="font-semibold">
                                    {{ booking.flight.flight_number }}
                                </p>
                            </div>

                            <div class="border-t pt-4">
                                <div class="flex justify-between">
                                    <span>Tiket Pesawat</span>

                                    <span>
                                        Rp
                                        {{ formatPrice(booking.total_price) }}
                                    </span>
                                </div>
                            </div>

                            <div class="border-t pt-4">
                                <div
                                    class="flex justify-between text-lg font-bold"
                                >
                                    <span>Total Pembayaran</span>

                                    <span
                                        class="bg-gradient-to-r from-emerald-700 via-emerald-600 to-emerald-500 bg-clip-text text-transparent"
                                    >
                                        Rp
                                        {{ formatPrice(booking.total_price) }}
                                    </span>
                                </div>
                            </div>

                            <div
                                class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm flex gap-3"
                            >
                                <ShieldCheck
                                    class="mt-0.5 h-5 w-5 text-emerald-600"
                                />

                                <div>
                                    <p class="font-semibold text-emerald-700">
                                        Pembayaran Aman
                                    </p>

                                    <p class="text-muted-foreground">
                                        Seluruh transaksi dilindungi menggunakan
                                        sistem keamanan terenkripsi.
                                    </p>
                                </div>
                            </div>

                            <Button
                                size="lg"
                                class="w-full h-12 rounded-xl bg-gradient-to-r from-emerald-700 via-emerald-600 to-emerald-500"
                                @click="payNow"
                            >
                                Bayar Sekarang
                            </Button>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
