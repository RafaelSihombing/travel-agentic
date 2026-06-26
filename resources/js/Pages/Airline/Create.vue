<script setup>
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
});

const form = useForm({
    code: "",
    name: "",
    country: "Indonesia",
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
    form.logo = event.target.files[0];
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
                        <Label for="code">Kode Maskapai</Label>

                        <Input
                            id="code"
                            v-model="form.code"
                            type="text"
                            placeholder="Contoh: GA"
                        />

                        <InputError :message="form.errors.code" />
                    </div>

                    <!-- NAME -->
                    <div class="flex flex-col gap-2">
                        <Label for="name">Nama Maskapai</Label>

                        <Input
                            id="name"
                            v-model="form.name"
                            type="text"
                            placeholder="Contoh: Garuda Indonesia"
                        />

                        <InputError :message="form.errors.name" />
                    </div>

                    <!-- COUNTRY -->
                    <div class="flex flex-col gap-2">
                        <Label for="country">Negara</Label>

                        <Input
                            id="country"
                            v-model="form.country"
                            type="text"
                            placeholder="Contoh: Indonesia"
                        />

                        <InputError :message="form.errors.country" />
                    </div>

                    <!-- LOGO -->
                    <div class="flex flex-col gap-2">
                        <Label for="logo">Logo Maskapai</Label>

                        <Input
                            id="logo"
                            type="file"
                            accept="image/*"
                            @change="onFileChange"
                        />

                        <InputError :message="form.errors.logo" />
                    </div>

                    <div
                        class="flex flex-col gap-2 mt-8 lg:flex-row lg:justify-end"
                    >
                        <Button
                            type="button"
                            variant="ghost"
                            size="xl"
                            @click="form.reset()"
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
                            Submit
                        </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </div>
</template>
