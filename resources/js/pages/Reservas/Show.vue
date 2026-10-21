
<script setup lang="ts">
import { index, edit } from '@/routes/reservas'
import { Head, Link } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Separator } from '@/components/ui/separator'
import { Reserva } from '@/types/business'
import { dataCurta, dataLonga, hora, moeda } from '@/lib/utils'

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Reservas',
                href: index(),
            },
            {
                title: 'Ver reserva',
                href: '#',
            },
        ],
    },
})



const { reserva } = defineProps<{
    reserva: Reserva
}>()



</script>

<template>
    <Head :title="`Reserva #${reserva.id}`" />

    <div class="flex flex-col gap-6 p-4 md:p-6">
        <!-- Cabeçalho -->
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div class="space-y-1">
                <p class="text-sm text-muted-foreground">
                    {{ dataCurta(reserva.começo) }}
                </p>

                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-2xl font-semibold tracking-tight">
                        {{ reserva.titulo }}
                    </h1>

                    <Badge variant="outline">
                        {{ reserva.status.tipo }}
                    </Badge>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                <Button variant="outline" as-child>
                    <Link :href="index()">
                        Voltar
                    </Link>
                </Button>

                <Button as-child>
                    <Link :href="edit({reserva: reserva.id})">
                        Editar reserva
                    </Link>
                </Button>
            </div>
        </div>

        <Separator />

        <!-- Resumo financeiro -->
        <div class="grid gap-4 sm:grid-cols-2">
            <Card>
                <CardHeader class="pb-2">
                    <CardDescription>Preço decoração</CardDescription>
                    <CardTitle class="text-2xl">
                        {{ reserva.preço }}
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <p class="text-sm text-muted-foreground">
                        Valor total da decoração
                    </p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="pb-2">
                    <CardDescription>Cliente até agora pagou</CardDescription>
                    <CardTitle class="text-2xl">
                        {{ reserva.valor_pago }}
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <p class="text-sm text-red-500">
                        <template v-if="reserva.preço !== null && reserva.valor_pago !== null">
                            Aguardando o pago restate de:
                            {{ String(Number(reserva.preço) - Number(reserva.valor_pago)) }}
                        </template>
                        <template v-else>
                            Valores não informados
                        </template>
                    </p>
                </CardContent>
            </Card>
        </div>

        <Card>
            <CardHeader>
                <CardTitle>Notas</CardTitle>
            </CardHeader>

            <CardContent>
                <p
                    v-if="reserva.notas"
                    class="text-sm leading-6 whitespace-pre-wrap"
                >
                    {{ reserva.notas }}
                </p>

                <p v-else class="text-sm text-muted-foreground">
                    Sem detalhes da decoração
                </p>
            </CardContent>
        </Card>

        <!-- Dados da reserva -->
        <Card>
            <CardHeader>
                <CardTitle>Outras informações</CardTitle>
            </CardHeader>

            <CardContent class="grid gap-6 sm:grid-cols-2">
                <div class="space-y-1">
                    <p class="text-sm text-muted-foreground">Cliente</p>
                    <p >
                        {{ reserva.cliente.nome }}
                    </p>
                    <p >
                        {{ reserva.cliente.telefone }}
                    </p>
                </div>

                <div class="space-y-1">
                    <p class="text-sm text-muted-foreground">Personalizado</p>
                    <p class="font-medium">
                        {{ reserva.personalizado ? 'Sim' : 'Não' }}
                    </p>
                </div>

                <div class="space-y-1">
                    <p class="text-sm text-muted-foreground">Passa recolhendo</p>
                    <p class="font-medium">
                        {{ dataLonga(reserva.começo) }}
                    </p>
                </div>

                <div class="space-y-1">
                    <p class="text-sm text-muted-foreground">Vem trazer</p>
                    <p class="font-medium">
                        {{ dataLonga(reserva.fim) }}
                    </p>
                </div>
            </CardContent>
        </Card>

        <p
            v-if="reserva.updated_at"
            class="text-xs text-muted-foreground"
        >
            Última atualização: {{ dataLonga(reserva.updated_at) }}
        </p>
    </div>
</template>
