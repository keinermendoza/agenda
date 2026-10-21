<script setup lang="ts">
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { Trash2 } from '@lucide/vue'
import { destroy } from '@/routes/reservas'

import { Button } from '@/components/ui/button'
import {
    AlertDialog,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog'

const props = defineProps<{
    reservaId: number
}>()

const open = ref(false)
const processing = ref(false)

function confirmar() {
    router.delete(destroy(props.reservaId).url, {
        preserveScroll: true,
        onStart: () => (processing.value = true),
        onFinish: () => {
            processing.value = false
            open.value = false
        },
    })
}
</script>

<template>
    <AlertDialog v-model:open="open">
        <AlertDialogTrigger as-child>
            <Button variant="destructive" type="button">
                <Trash2 />
                Excluir reserva
            </Button>
        </AlertDialogTrigger>

        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>Excluir esta reserva?</AlertDialogTitle>
                <AlertDialogDescription>
                    Esta ação não pode ser desfeita. A reserva será removida
                    permanentemente.
                </AlertDialogDescription>
            </AlertDialogHeader>

            <AlertDialogFooter>
                <AlertDialogCancel :disabled="processing">
                    Cancelar
                </AlertDialogCancel>

                <Button
                    variant="destructive"
                    :disabled="processing"
                    @click="confirmar"
                >
                    {{ processing ? 'Excluindo...' : 'Sim, excluir' }}
                </Button>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
