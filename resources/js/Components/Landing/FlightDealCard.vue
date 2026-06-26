<script setup>
import { Card, CardContent } from "@/Components/ui/card";

import { Badge } from "@/Components/ui/badge";

import { Button } from "@/Components/ui/button";

import { Plane, ChevronRight } from "lucide-vue-next";
</script>

<template>
    <Card class="hover:shadow-md transition-all duration-200">
        <CardContent class="p-4">
            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                <!-- Airline -->
                <div class="flex items-center gap-3 lg:w-64">
                    <img
                        src="/images/airlines/garuda.png"
                        alt="Garuda"
                        class="h-12 w-12 rounded-md border object-cover"
                    />

                    <div>
                        <h3 class="text-base font-semibold">
                            Garuda Indonesia
                        </h3>

                        <p class="text-sm text-muted-foreground">
                            GA-204 • B737-800
                        </p>
                    </div>
                </div>

                <!-- Route -->
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <!-- Departure -->
                        <div>
                            <div class="text-xl font-semibold">10:00</div>

                            <div class="text-sm text-muted-foreground">CGK</div>
                        </div>

                        <!-- Duration -->
                        <div class="flex-1 px-4 lg:px-8">
                            <div
                                class="text-center text-sm text-muted-foreground"
                            >
                                2h 0m
                            </div>

                            <div class="relative mt-2">
                                <div class="h-px bg-border" />

                                <Plane
                                    class="absolute left-1/2 top-0 -translate-x-1/2 -translate-y-1/2 h-4 w-4 text-primary"
                                />
                            </div>

                            <div
                                class="mt-2 text-center text-xs text-muted-foreground"
                            >
                                Non-stop
                            </div>
                        </div>

                        <!-- Arrival -->
                        <div>
                            <div class="text-xl font-semibold">12:00</div>

                            <div class="text-sm text-muted-foreground">DPS</div>
                        </div>
                    </div>
                </div>

                <!-- Price -->
                <div class="lg:w-44 text-left lg:text-right">
                    <div class="text-lg font-semibold text-primary">
                        Rp 1.200.000
                    </div>

                    <Badge variant="secondary" class="mt-2">
                        Delayed 90m
                    </Badge>
                </div>

                <!-- Action -->
                <Button size="icon" class="h-10 w-10 shrink-0">
                    <ChevronRight class="h-4 w-4" />
                </Button>
            </div>
        </CardContent>
    </Card>
</template>
