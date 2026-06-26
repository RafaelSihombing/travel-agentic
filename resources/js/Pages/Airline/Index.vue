<script setup>
import { reactive, ref, computed, watch } from "vue";
import { Link, router } from "@inertiajs/vue3";

import AppLayout from "@/Layouts/AppLayout.vue";
import Banner from "@/Components/Banner.vue";
import BreadcrumbHeader from "@/Components/BreadcrumbHeader.vue";
import HeaderTitle from "@/Components/HeaderTitle.vue";
import Filter from "@/Components/Datatable/Filter.vue";
import ShowFilter from "@/Components/Datatable/ShowFilter.vue";

import { Button } from "@/Components/ui/button";
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
} from "@/Components/ui/card";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/Components/ui/table";

import {
    IconArrowsDownUp,
    IconPencil,
    IconPlane,
    IconPlus,
    IconTrash,
} from "@tabler/icons-vue";
import EmptyState from "@/Components/EmptyState.vue";
import { Tab } from "@headlessui/vue";

import { deleteAction } from "@/lib/utils";
import AlertAction from "@/Components/AlertAction.vue";
import PaginationTable from "@/Components/Datatable/PaginationTable.vue";

defineOptions({
    layout: AppLayout,
});

const props = defineProps({
    airlines: Object,
    pageSettings: Object,
    items: Array,
    state: Object,
});

// const { data: airlines, meta, links } = props.airlines;

const airlines = computed(() => props.airlines.data);
const meta = computed(() => props.airlines.meta);
const links = computed(() => props.airlines.links);

const params = reactive({
    ...props.state,
});

watch(
    params,
    (value) => {
        console.log("PARAMS =", value);
    },
    {
        deep: true,
    },
);

const onSortTable = (field) => {
    params.field = field;
    params.direction = params.direction === "asc" ? "desc" : "asc";

    router.get(route("airlines.index"), params, {
        preserveState: true,
        preserveScroll: true,
        only: ["airlines"],
    });
};

const openModal = ref(false);
const modalMode = ref("create");
const selectedAirport = ref(null);

const updateParams = (value) => {
    Object.assign(params, value);

    router.get(route("airlines.index"), value, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ["airlines", "state"],
    });
};
</script>

<template>
    <div class="flex flex-col w-full gap-y-6 pb-32">
        <!-- breadcrumb -->
        <BreadcrumbHeader :items="items" />

        <!-- banner -->
        <Banner
            :title="pageSettings.banner.title"
            :sub-title="pageSettings.banner.subtitle"
        />

        <!-- Table -->
        <Card>
            <!-- header -->
            <CardHeader class="p-0">
                <div
                    class="flex flex-col items-start justify-between p-4 gap-y-4 lg:flex-row lg:items-center"
                >
                    <HeaderTitle
                        :title="pageSettings.title"
                        :sub-title="pageSettings.subtitle"
                        :icon="IconPlane"
                    />

                    <Button variant="emerald" size="xl" as-child>
                        <Link :href="route('airlines.create')">
                            <IconPlus class="size-4" />
                            Tambah
                        </Link>
                    </Button>
                </div>

                <Filter
                    :params="params"
                    :state="state"
                    @update:params="updateParams"
                />
                <ShowFilter :params="params" />
            </CardHeader>

            <CardContent
                class="p-0 [&_td]:whitespace-nowrap [&_td]:px-6 [&_th]:px-6"
            >
                <EmptyState
                    v-if="airlines.length === 0"
                    :icon="IconPlane"
                    title="Tidak ada Bandara"
                    subtitle="Mulailah dengan menambahkan data bandara"
                />

                <!-- table Bandara -->
                <Table v-else class="w-full">
                    <TableHeader>
                        <TableRow>
                            <TableHead>#</TableHead>

                            <TableHead>Gambar</TableHead>

                            <TableHead>
                                <Button
                                    variant="ghost"
                                    class="inline-flex group"
                                    @click="onSortTable('code')"
                                >
                                    Kode
                                    <IconArrowsDownUp class="ml-2 size-4" />
                                </Button>
                            </TableHead>

                            <TableHead>
                                <Button
                                    variant="ghost"
                                    class="inline-flex group"
                                    @click="onSortTable('name')"
                                >
                                    Nama Bandara
                                    <IconArrowsDownUp class="ml-2 size-4" />
                                </Button>
                            </TableHead>

                            <TableHead>
                                <Button
                                    variant="ghost"
                                    class="inline-flex group"
                                    @click="onSortTable('city')"
                                >
                                    Kota
                                    <IconArrowsDownUp class="ml-2 size-4" />
                                </Button>
                            </TableHead>

                            <TableHead>Negara</TableHead>
                            <TableHead>Dibuat</TableHead>
                            <TableHead>Aksi</TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        <TableRow
                            v-for="(airline, index) in airlines"
                            :key="airline.id"
                        >
                            <TableCell>
                                {{
                                    index +
                                    1 +
                                    (meta.current_page - 1) * meta.per_page
                                }}
                            </TableCell>

                            <TableCell>
                                <img
                                    v-if="airline.image"
                                    :src="airline.image"
                                    :alt="airline.name"
                                    class="object-cover w-12 h-12 rounded-lg"
                                />

                                <div
                                    v-else
                                    class="flex items-center justify-center w-12 h-12 rounded-lg bg-muted"
                                >
                                    <IconPlane
                                        class="size-5 text-muted-foreground"
                                    />
                                </div>
                            </TableCell>

                            <TableCell class="font-medium">
                                {{ airline.code }}
                            </TableCell>

                            <TableCell>
                                {{ airline.name }}
                            </TableCell>

                            <TableCell>
                                {{ airline.city }}
                            </TableCell>

                            <TableCell>
                                {{ airline.country }}
                            </TableCell>

                            <TableCell>
                                {{ airline.created_at }}
                            </TableCell>

                            <TableCell>
                                <div class="flex items-center gap-x-1">
                                    <Button variant="blue" size="sm" as-child>
                                        <Link
                                            :href="
                                                route(
                                                    'airlines.edit',
                                                    airline.id,
                                                )
                                            "
                                        >
                                            <IconPencil class="size-4" />
                                        </Link>
                                    </Button>

                                    <AlertAction
                                        :action="
                                            () =>
                                                deleteAction(
                                                    route(
                                                        'airlines.destroy',
                                                        airline.id,
                                                    ),
                                                )
                                        "
                                    >
                                        <Button variant="red" size="sm">
                                            <IconTrash class="size-4" />
                                        </Button>
                                    </AlertAction>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </CardContent>

            <CardFooter
                class="flex flex-col items-center justify-between w-full py-3 border-t gap-y-2 lg:flex-row"
            >
                <p class="text-sm text-muted-foreground">
                    Menampilkan
                    <span class="font-medium text-emerald-600">
                        {{ meta.from ?? 0 }}
                    </span>
                    dari {{ meta.total }} Bandara
                </p>

                <div class="overflow-x-auto">
                    <PaginationTable
                        v-if="meta.has_pages"
                        :meta="meta"
                        :links="links"
                    />
                </div>
            </CardFooter>
        </Card>

        <Create
            v-model:open="openModal"
            :mode="modalMode"
            :airline="selectedAirport"
        />
    </div>
</template>
