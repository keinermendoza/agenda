<script setup>
import { watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { Toaster } from '@/components/ui/sonner';

const page = usePage();

watch(
    () => page.props.flash,
    (flash) => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    },
    { immediate: true },
);
</script>

<template>
    <Toaster position="top-right" rich-colors />
</template>
