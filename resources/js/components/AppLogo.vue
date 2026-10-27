<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
const name = usePage().props.name;
</script>

<template>
     <img src="/android-chrome-192x192.png" alt="logo" class="size-10">
    <div class="ml-1 grid flex-1 text-left text-sm">
        <span class="mb-0.5 truncate leading-tight font-semibold">{{
            name
        }}</span>
    </div>
</template>
