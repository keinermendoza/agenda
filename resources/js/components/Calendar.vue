<script setup lang="ts">
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import { show, create } from '@/routes/reservas'

import '@fullcalendar/vue3/skeleton.css'
import '@fullcalendar/vue3/themes/monarch/theme.css'
import '@fullcalendar/vue3/themes/monarch/palettes/red.css'
import FullCalendar from '@fullcalendar/vue3'
import themePlugin from '@fullcalendar/vue3/themes/monarch'
import dayGridPlugin from '@fullcalendar/vue3/daygrid'
import interactionPlugin from '@fullcalendar/vue3/interaction'
import { dataLonga } from '@/lib/utils'

import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
} from '@/components/ui/dialog'

import { Button } from '@/components/ui/button'
import { Plus } from '@lucide/vue'

import { ReservaCalendar } from '@/types/business'

const { reservas } = defineProps<{
    reservas: ReservaCalendar[]
}>()

const modalVisible = ref(false)
const dataSelecionada = ref('')

function abrirModal(data: string) {
    dataSelecionada.value = data
    modalVisible.value = true
}

function handleDataClick(info: { dataStr: string }) {
    abrirModal(info.dataStr)
}

function handleReservaClick(info: { event: { startStr: string } }) {
    abrirModal(info.event.startStr.slice(0, 10))
}

const reservasDoDia = computed(() => {
    return reservas.filter(reserva =>
        reserva.start.slice(0, 10) === dataSelecionada.value
    )
})
const calendarOptions = computed(() => ({
    plugins: [themePlugin, dayGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    locale: 'pt-br',
    events: reservas,
    dateClick: handleDataClick,
    eventClick: handleReservaClick,
}))
</script>

<template>
    <FullCalendar :options="calendarOptions" />

    <Dialog v-model:open="modalVisible">
    <DialogContent>

        <DialogHeader>
            <DialogTitle>
                Reservas de {{ dataSelecionada }}
            </DialogTitle>


            <DialogDescription>
                Reservas asociadas a este día.
            </DialogDescription>
        </DialogHeader>

        <p v-if="reservasDoDia.length === 0">
            Nenhuma reserva para este dia.
        </p>

        <ul v-else class="space-y-2">
            <li
        v-for="reserva in reservasDoDia"
        :key="reserva.id"
    >
                <Link
                    :href="show(reserva.id)"

                    class="block rounded-lg border bg-card p-4
                        transition-colors hover:bg-accent"
                >
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="font-medium">
                                {{ reserva.title }}
                            </h3>

                            <p class="mt-1 text-sm text-muted-foreground">
                                {{ reserva.cliente }}
                            </p>
                        </div>

                        <span class="shrink-0 text-sm text-muted-foreground">
                            {{ dataLonga(reserva.start) }}
                        </span>
                    </div>
                </Link>
            </li>
        </ul>
        <div class="mt-4 flex justify-end">
            <Button as-child>

                <Link :href="create({ query: { data: dataSelecionada } }).url">
                    <Plus class="mr-2 size-4" />
                    Adicionar reserva
                </Link>
            </Button>
        </div>
    </DialogContent>
</Dialog>
</template>
