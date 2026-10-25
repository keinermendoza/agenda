<script setup lang="ts">
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { show, create, index } from '@/routes/reservas'

import '@fullcalendar/vue3/skeleton.css'
import '@fullcalendar/vue3/themes/monarch/theme.css'
import '@fullcalendar/vue3/themes/monarch/palettes/red.css'
import FullCalendar from '@fullcalendar/vue3'
import themePlugin from '@fullcalendar/vue3/themes/monarch'
import dayGridPlugin from '@fullcalendar/vue3/daygrid'
import interactionPlugin from '@fullcalendar/vue3/interaction'
import { dataLonga, hora } from '@/lib/utils'

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

const props = defineProps<{
    reservas: ReservaCalendar[],
    mesTexto?: string
}>()

const modalVisible = ref(false)
const dataSelecionada = ref('')

function abrirModal(data: string) {
    dataSelecionada.value = data
    modalVisible.value = true
}

function handleDataClick(info: { dateStr: string }) {
    abrirModal(info.dateStr)
}

function handleReservaClick(info: { event: { startStr: string } }) {
    abrirModal(info.event.startStr.slice(0, 10))
}

const reservasDoDia = computed(() => {
    return props.reservas.filter(reserva =>
        reserva.start.slice(0, 10) === dataSelecionada.value
    )
})

function onDatesSet(info: DatesSetArg) {
  // currentStart = primer día del mes mostrado (no el de la semana previa)
  const d = info.view.currentStart
  const mesRenderizado = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}`

  // Si el mes visible ya es el que tenemos del servidor, no pedir nada
  if (mesRenderizado === props.mesTexto) return

  router.get(
    index(),
    { 'mesTexto' : mesRenderizado },
    {
      only: ['reservas', 'mesTexto'],
      preserveState: true,
      preserveScroll: true,
      replace: true,
    },
  )
}

const calendarOptions = computed(() => ({
    plugins: [themePlugin, dayGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    locale: 'pt-br',
    events: props.reservas,
    datesSet: onDatesSet,
    dateClick: handleDataClick,
    eventClick: handleReservaClick,
    headerToolbar: {
    left: 'prev,next today',
    center: 'title',
    right: '',
  },
  buttonText: {
    today: 'Hoy',
  },
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

                            <!--
                            TODO: deixando implementação de cliente para segunda versão
                            <p class="mt-1 text-sm text-muted-foreground">
                                <span>Cliente: </span>{{ reserva.cliente }}
                            </p> -->
                        </div>

                        <span class="shrink-0 text-sm text-muted-foreground">
                            {{ hora(reserva.start) }}
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
