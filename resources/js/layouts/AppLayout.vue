<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItem } from '@/types';
import FlashMessage from '@/components/FlashMessage.vue';
const { breadcrumbs = [] } = defineProps<{
    breadcrumbs?: BreadcrumbItem[];
}>();
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage />
        <slot />
    </AppLayout>
</template>
