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
    alternatives: Object,
    pageSettings: Object,
    items: Array,
    state: Object,
});

const alternatives = computed(() => props.alternatives.data);
const meta = computed(() => props.alternatives.meta);
const links = computed(() => props.alternatives.links);

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

    router.get(route("alternatives.index"), params, {
        preserveState: true,
        preserveScroll: true,
        only: ["alternatives"],
    });
};

const openModal = ref(false);
const modalMode = ref("create");
const selectedAirport = ref(null);

const updateParams = (value) => {
    Object.assign(params, value);

    router.get(route("alternatives.index"), value, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ["alternatives", "state"],
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
                        <Link :href="route('alternatives.create')">
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
                    v-if="alternatives.length === 0"
                    :icon="IconTicket"
                    title="Belum ada Booking"
                    subtitle="Belum ada transaksi pemesanan tiket."
                />

                <!-- table Bandara -->
                <Table v-else class="w-full">
                    <TableHeader>
                        <TableRow>
                            <TableHead>#</TableHead>

                            <TableHead>Original Flight</TableHead>

                            <TableHead>Alternative Flight</TableHead>

                            <TableHead>Reason</TableHead>

                            <TableHead>Created</TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        <TableRow
                            v-for="(item, index) in alternatives"
                            :key="item.id"
                        >
                            <TableCell>
                                {{
                                    index +
                                    1 +
                                    (meta.current_page - 1) * meta.per_page
                                }}
                            </TableCell>

                            <TableCell>
                                <div class="flex flex-col">
                                    <span>
                                        {{ item.original_flight.flight_number }}
                                    </span>

                                    <span class="text-xs text-muted-foreground">
                                        {{ item.original_flight.route }}
                                    </span>
                                </div>
                            </TableCell>

                            <TableCell>
                                <div class="flex flex-col">
                                    <span>
                                        {{
                                            item.alternative_flight
                                                .flight_number
                                        }}
                                    </span>

                                    <span class="text-xs text-muted-foreground">
                                        {{ item.alternative_flight.route }}
                                    </span>
                                </div>
                            </TableCell>

                            <TableCell>
                                {{ item.reason }}
                            </TableCell>

                            <TableCell>
                                {{ item.created_at }}
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
                    dari {{ meta.total }} Booking
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
