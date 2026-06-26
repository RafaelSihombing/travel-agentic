<script setup>
import { AlertTriangle } from "lucide-vue-next";
import { Button } from "@/Components/ui/button";
import { Card, CardContent } from "@/Components/ui/card";

defineProps({
    recommendation: Object,
});
</script>

<template>
    <Card class="border-red-200 bg-red-50">
        <CardContent class="p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-start gap-4">
                    <AlertTriangle class="size-8 text-red-500" />

                    <div>
                        <h2 class="text-2xl font-semibold text-red-700">
                            Flight Delay Detected
                        </h2>

                        <p class="mt-2">
                            {{ recommendation.message }}
                        </p>

                        <div class="mt-4 rounded-lg border bg-white p-4">
                            <p class="text-sm text-muted-foreground">
                                Suggested Action
                            </p>

                            <p class="font-medium">
                                {{ recommendation.suggested_action }}
                            </p>
                        </div>
                    </div>
                </div>

                <Button> View Alternative Flight </Button>
            </div>
        </CardContent>
    </Card>
</template>
