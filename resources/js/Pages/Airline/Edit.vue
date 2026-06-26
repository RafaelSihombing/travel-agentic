<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";

import AppLayout from "@/Layouts/AppLayout.vue";
import BreadcrumbHeader from "@/Components/BreadcrumbHeader.vue";
import HeaderTitle from "@/Components/HeaderTitle.vue";
import InputError from "@/Components/InputError.vue";

import { Button } from "@/Components/ui/button";
import { Card, CardContent, CardHeader } from "@/Components/ui/card";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";

import { IconArrowBack, IconCheck, IconPlane } from "@tabler/icons-vue";

defineOptions({
    layout: AppLayout,
});

const props = defineProps({
    pageSettings: Object,
    items: Array,
    airline: Object,
});

// Ambil data airline dari Resource
const airline = props.airline.data;

const preview = ref(airline.logo ? `/storage/${airline.logo}` : null);

const form = useForm({
    code: airline.code,
    name: airline.name,
    country: airline.country ?? "Indonesia",
    logo: null,
    _method: props.pageSettings.method,
});

const onHandleSubmit = () => {
    form.post(props.pageSettings.action, {
        preserveScroll: true,
        preserveState: true,
        forceFormData: true,
    });
};

const onFileChange = (event) => {
    const file = event.target.files[0];

    if (!file) return;

    form.logo = file;

    preview.value = URL.createObjectURL(file);
};

const resetForm = () => {
    form.code = airline.code;
    form.name = airline.name;
    form.country = airline.country ?? "Indonesia";
    form.logo = null;

    preview.value = airline.logo ? `/storage/${airline.logo}` : null;
};
</script>

<template>
    <div class="flex w-full flex-col gap-y-6 pb-32">
        <BreadcrumbHeader :items="items" />

        <Card>
            <CardHeader>
                <div
                    class="flex flex-col items-start justify-between gap-y-4 lg:flex-row lg:items-center"
                >
                    <HeaderTitle
                        :title="pageSettings.title"
                        :sub-title="pageSettings.subtitle"
                        :icon="IconPlane"
                    />

                    <Button variant="emerald" size="xl" as-child>
                        <Link :href="route('airlines.index')">
                            <IconArrowBack class="size-4" />
                            Kembali
                        </Link>
                    </Button>
                </div>
            </CardHeader>

            <CardContent>
                <form class="space-y-4" @submit.prevent="onHandleSubmit">
                    <!-- CODE -->
                    <div class="flex flex-col gap-2">
                        <Label>Kode Maskapai</Label>

                        <Input v-model="form.code" placeholder="GA" />

                        <InputError :message="form.errors.code" />
                    </div>

                    <!-- NAME -->
                    <div class="flex flex-col gap-2">
                        <Label>Nama Maskapai</Label>

                        <Input
                            v-model="form.name"
                            placeholder="Garuda Indonesia"
                        />

                        <InputError :message="form.errors.name" />
                    </div>

                    <!-- COUNTRY -->
                    <div class="flex flex-col gap-2">
                        <Label>Negara</Label>

                        <Input v-model="form.country" placeholder="Indonesia" />

                        <InputError :message="form.errors.country" />
                    </div>

                    <!-- LOGO -->
                    <div class="flex flex-col gap-2">
                        <Label>Logo Maskapai</Label>

                        <Input
                            type="file"
                            accept="image/*"
                            @change="onFileChange"
                        />

                        <InputError :message="form.errors.logo" />
                    </div>

                    <!-- Preview -->
                    <div v-if="preview" class="space-y-2">
                        <Label>Preview Logo</Label>

                        <img
                            :src="preview"
                            class="h-24 rounded-lg border object-contain"
                        />
                    </div>

                    <!-- Button -->
                    <div
                        class="mt-8 flex flex-col gap-2 lg:flex-row lg:justify-end"
                    >
                        <Button
                            type="button"
                            variant="ghost"
                            size="xl"
                            @click="resetForm"
                        >
                            Reset
                        </Button>

                        <Button
                            type="submit"
                            variant="emerald"
                            size="xl"
                            :disabled="form.processing"
                        >
                            <IconCheck class="size-4" />
                            Update
                        </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </div>
</template>
