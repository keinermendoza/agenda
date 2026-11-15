<script setup lang="ts">
import {
    Card,
} from '@/components/ui/card'
interface Props {
    ingressos?: number
}

const props = defineProps<Props>();
</script>

<template>
    <Card class="p-6 w-fit gap-2">
        <p class="font-light italic">Ingressos do Mês</p>
        <p class="text-[hsl(335,89%,50%)] text-2xl font-bold">{{props.ingressos}}</p>
    </Card>
</template>
