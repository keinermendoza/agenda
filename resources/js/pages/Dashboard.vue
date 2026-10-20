<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { dashboard } from '@/routes';
import Calendar from '@/components/Calendar.vue';
import { ReservaCalendar } from '@/types/business';
defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Menu',
                href: dashboard(),
            },
        ],
    },
});

const { reservas } = defineProps<{
    reservas: ReservaCalendar[]
}>()

</script>

<template>
    <Head title="Menu" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div>
            <Calendar :reservas="reservas" />
        </div>
        <div
            class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
        >
            <PlaceholderPattern />
        </div>
    </div>
</template>
