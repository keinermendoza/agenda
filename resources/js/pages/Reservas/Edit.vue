```vue
<script setup>
import { useForm, Head, usePage } from '@inertiajs/vue3';
import { index, update, show } from '@/routes/reservas';
import { dataCurta } from '@/lib/utils';

import Label from '@/components/ui/label/Label.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';

import Select from '@/components/ui/select/Select.vue';
import SelectContent from '@/components/ui/select/SelectContent.vue';
import SelectItem from '@/components/ui/select/SelectItem.vue';
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
import SelectValue from '@/components/ui/select/SelectValue.vue';

import ComboxField from '@/components/ComboxField.vue';

defineOptions({
    layout: {
        get breadcrumbs() {
        const page = usePage();
            return [
                { title: 'Reservas', href: index().url },
                { title: 'Ver reserva', href: show(page.props.reserva.id).url  },
                { title: 'Editar reserva', href: "#"  },

            ]
        }
    },
});

const props = defineProps({
    reserva: {
        type: Object,
        required: true,
    },
    clientes: {
        type: Array,
        required: true,
    },
    statuses: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    começo: props.reserva.começo,
    fim: props.reserva.fim,
    preço: props.reserva.preço,
    personalizado: Boolean(props.reserva.personalizado),
    reserva_status_id: props.reserva.reserva_status_id,
    cliente_id: props.reserva.cliente_id,
    notas: props.reserva.notas,
    valor_pago: props.reserva.valor_pago ?? '',
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        personalizado: data.personalizado ? 1 : 0,
    })).put(update(props.reserva.id).url);
};
</script>

<template>
    <Head title="Editar reserva" />

    <div class="max-w-6xl space-y-6 p-4 md:p-6">
        <div>
            <h1 class="text-xl font-semibold tracking-tight">
                Editar reserva para dia {{ dataCurta(form.começo) }}
            </h1>

            <p class="text-sm text-muted-foreground">
                Atualize os dados da reserva.
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <section class="space-y-6 rounded-xl border p-6">
                <div class="space-y-2">
                    <Label class="font-semibold text-lg" for="notas">
                        Informações
                    </Label>

                    <textarea
                        id="notas"
                        v-model="form.notas"
                        rows="4"
                        required
                        placeholder="todos os detalhes importantes da decoração"
                        class="flex min-h-24 w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                    />

                    <p v-if="form.errors.notas" class="text-sm text-destructive">
                        {{ form.errors.notas }}
                    </p>
                </div>
            </section>

            <!-- PREÇOS -->
            <section class="space-y-6 rounded-xl border p-6">
                <div>
                    <h2 class="font-semibold">Recebimento de pago</h2>
                    <p class="text-sm text-muted-foreground">
                        Atualize o preço da decoração e o valor recebido até agora
                    </p>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="space-y-2">
                        <Label for="preço">Preço (R$)</Label>
                        <Input
                            id="preço"
                            v-model="form.preço"
                            type="number"
                            min="0"
                            step="0.01"
                        />
                        <p v-if="form.errors.preço" class="text-sm text-destructive">
                            {{ form.errors.preço }}
                        </p>
                    </div>


                    <div class="space-y-2">
                        <Label for="valor_pago">Valor pago (R$)</Label>

                        <Input
                            id="valor_pago"
                            v-model="form.valor_pago"
                            type="number"
                            min="0"
                            step="0.01"
                            required
                        />

                        <p v-if="form.errors.valor_pago" class="text-sm text-destructive">
                            {{ form.errors.valor_pago }}
                        </p>
                    </div>
                </div>
            </section>

            <!-- DATAS -->
            <section class="space-y-6 rounded-xl border p-6">
                <div>
                    <h2 class="font-semibold">Data da reserva</h2>

                    <p class="text-sm text-muted-foreground">
                        Atualize o periodo da reserva.
                    </p>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="space-y-2">
                        <Label for="começo">Início</Label>

                        <Input
                            id="começo"
                            v-model="form.começo"
                            type="datetime-local"
                            required
                        />

                        <p v-if="form.errors.começo" class="text-sm text-destructive">
                            {{ form.errors.começo }}
                        </p>
                    </div>

                    <div class="space-y-2">
                        <Label for="fim">Fim</Label>

                        <Input
                            id="fim"
                            v-model="form.fim"
                            type="datetime-local"
                        />

                        <p v-if="form.errors.fim" class="text-sm text-destructive">
                            {{ form.errors.fim }}
                        </p>
                    </div>
                </div>
            </section>

            <!-- CLIENTE -->
            <!--
            TODO: deixando cliente para segunda versão
            <section class="space-y-6 rounded-xl border p-6">
                <div>
                    <h2 class="font-semibold">Cliente</h2>
                    <p class="text-sm text-muted-foreground">
                        Selecione ou cadastre o cliente
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="cliente_id">Selecionar cliente</Label>

                    <ComboboxField
                        id="cliente_id"
                        v-model="form.cliente_id"
                        :options="props.clientes"
                        option-label="nome"
                        placeholder="Selecione um cliente"
                        search-placeholder="Buscar cliente..."
                        empty-text="Nenhum cliente encontrado."
                    />

                    <p
                        v-if="form.errors.cliente_id"
                        class="text-sm text-destructive"
                    >
                        {{ form.errors.cliente_id }}
                    </p>
                </div>
            </section> -->

            <!-- STATUS & PERSONALIZADO -->
            <section class="space-y-6 rounded-xl border p-6">
                <div>
                    <h2 class="font-semibold">Status e personalização</h2>

                    <p class="text-sm text-muted-foreground">
                        Atualize o status da reserva eindique se otema é personalizado
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="reserva_status_id">Status da reserva</Label>

                    <Select v-model="form.reserva_status_id">
                        <SelectTrigger id="reserva_status_id" class="w-full">
                            <SelectValue placeholder="Selecione um status" />
                        </SelectTrigger>

                        <SelectContent>
                            <SelectItem
                                v-for="status in props.statuses"
                                :key="status.id"
                                :value="status.id"
                            >
                                {{ status.tipo }}
                            </SelectItem>
                        </SelectContent>
                    </Select>

                    <p
                        v-if="form.errors.reserva_status_id"
                        class="text-sm text-destructive"
                    >
                        {{ form.errors.reserva_status_id }}
                    </p>
                </div>

                <div class="flex items-start gap-3">
                    <Checkbox
                        id="personalizado"
                        v-model="form.personalizado"
                    />

                    <div class="space-y-1">
                        <Label for="personalizado">
                            Reserva personalizada
                        </Label>

                        <p class="text-sm text-muted-foreground">
                            Indica que a reserva inclui personalização.
                        </p>

                        <p
                            v-if="form.errors.personalizado"
                            class="text-sm text-destructive"
                        >
                            {{ form.errors.personalizado }}
                        </p>
                    </div>
                </div>
            </section>

            <div class="flex justify-end gap-3">
                <Button
                    type="button"
                    variant="outline"
                    :disabled="form.processing"
                    @click="form.reset()"
                >
                    Restaurar valores
                </Button>

                <Button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Salvando...' : 'Salvar alterações' }}
                </Button>
            </div>
        </form>
    </div>
</template>
```
