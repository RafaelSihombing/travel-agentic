<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";

import AppLayout from "@/Layouts/AppLayout.vue";

import Banner from "@/Components/Banner.vue";
import BreadcrumbHeader from "@/Components/BreadcrumbHeader.vue";
import HeaderTitle from "@/Components/HeaderTitle.vue";

import Filter from "@/Components/Datatable/Filter.vue";
import ShowFilter from "@/Components/Datatable/ShowFilter.vue";
import PaginationTable from "@/Components/Datatable/PaginationTable.vue";
import EmptyState from "@/Components/EmptyState.vue";

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

import { IconArrowsDownUp, IconRobot } from "@tabler/icons-vue";

defineOptions({
    layout: AppLayout,
});

const props = defineProps({
    recommendations: Object,
    pageSettings: Object,
    items: Array,
    state: Object,
});

const { data: recommendations, meta, links } = props.recommendations;

const params = reactive({
    ...props.state,
});

const onSortTable = (field) => {
    params.field = field;

    params.direction = params.direction === "asc" ? "desc" : "asc";

    router.get(route("agent-recommendations.index"), params, {
        preserveState: true,
        preserveScroll: true,
        only: ["recommendations"],
    });
};

const severityClass = (severity) => {
    return {
        low: "bg-green-100 text-green-700",
        medium: "bg-yellow-100 text-yellow-700",
        high: "bg-orange-100 text-orange-700",
        critical: "bg-red-100 text-red-700",
    }[severity];
};

const recommendationClass = (recommendation) => {
    return {
        info: "bg-sky-100 text-sky-700",
        delay_warning: "bg-yellow-100 text-yellow-700",
        compensation: "bg-purple-100 text-purple-700",
        alternative_flight: "bg-emerald-100 text-emerald-700",
        refund: "bg-red-100 text-red-700",
        rebooking: "bg-indigo-100 text-indigo-700",
    }[recommendation];
};
</script>

<template>
    <div class="flex flex-col w-full gap-y-6 pb-32">
        <BreadcrumbHeader :items="items" />

        <Banner
            :title="pageSettings.banner.title"
            :sub-title="pageSettings.banner.subtitle"
        />

        <Card>
            <CardHeader class="p-0">
                <div
                    class="flex flex-col items-start justify-between p-4 gap-y-4 lg:flex-row lg:items-center"
                >
                    <HeaderTitle
                        :title="pageSettings.title"
                        :sub-title="pageSettings.subtitle"
                        :icon="IconRobot"
                    />
                </div>

                <Filter v-model:params="params" :state="state" />

                <ShowFilter :params="params" />
            </CardHeader>

            <CardContent class="p-0 [&_td]:px-6 [&_th]:px-6">
                <EmptyState
                    v-if="recommendations.length === 0"
                    :icon="IconRobot"
                    title="Tidak Ada Rekomendasi"
                    subtitle="Belum ada rekomendasi yang dibuat oleh agent."
                />

                <Table v-else class="w-full">
                    <TableHeader>
                        <TableRow>
                            <TableHead>#</TableHead>

                            <TableHead> Booking </TableHead>

                            <TableHead> Flight </TableHead>

                            <TableHead> Type </TableHead>

                            <TableHead> Severity </TableHead>

                            <TableHead> Title </TableHead>

                            <TableHead> Suggested Action </TableHead>

                            <TableHead> Status </TableHead>

                            <TableHead>
                                <Button
                                    variant="ghost"
                                    @click="onSortTable('created_at')"
                                >
                                    Tanggal
                                    <IconArrowsDownUp class="ml-2 size-4" />
                                </Button>
                            </TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        <TableRow
                            v-for="(recommendation, index) in recommendations"
                            :key="recommendation.id"
                        >
                            <TableCell>
                                {{
                                    index +
                                    1 +
                                    (meta.current_page - 1) * meta.per_page
                                }}
                            </TableCell>

                            <TableCell>
                                {{ recommendation.booking?.booking_code }}
                                <br />
                                <small class="text-muted-foreground">
                                    {{ recommendation.booking?.contact_name }}
                                </small>
                            </TableCell>

                            <TableCell>
                                {{ recommendation.flight?.flight_number }}
                            </TableCell>

                            <TableCell>
                                <span
                                    class="px-2 py-1 text-xs rounded-full"
                                    :class="
                                        recommendationClass(
                                            recommendation.recommendation_type,
                                        )
                                    "
                                >
                                    {{ recommendation.recommendation_type }}
                                </span>
                            </TableCell>

                            <TableCell>
                                <span
                                    class="px-2 py-1 text-xs rounded-full"
                                    :class="
                                        severityClass(recommendation.severity)
                                    "
                                >
                                    {{ recommendation.severity }}
                                </span>
                            </TableCell>

                            <TableCell>
                                {{ recommendation.title }}
                            </TableCell>

                            <TableCell class="max-w-sm truncate">
                                {{ recommendation.suggested_action }}
                            </TableCell>

                            <TableCell>
                                <span
                                    v-if="recommendation.is_read"
                                    class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700"
                                >
                                    Dibaca
                                </span>

                                <span
                                    v-else
                                    class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700"
                                >
                                    Belum Dibaca
                                </span>
                            </TableCell>

                            <TableCell>
                                {{ recommendation.created_at }}
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

                    dari
                    {{ meta.total }}
                    Rekomendasi Agen
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
    </div>
</template>
