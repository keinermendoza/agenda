```vue
<script setup>
import { useForm } from '@inertiajs/vue3';
import { Head, Link } from '@inertiajs/vue3'

import { index, store } from '@/routes/reservas';

import Label from '@/components/ui/label/Label.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import { dataCurta } from '@/lib/utils';


defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Reservas', href: index().url },
            { title: 'Nova reserva', href: '#' },
        ],
    },
});

const props = defineProps({
    clientes: {
        type: Array,
        required: true,
    },
    statuses: {
        type: Array,
        required: true,
    },
    dataSelecionada: {
        type: String,
        default: '',
    }
});

console.log(props);

const form = useForm({
    começo: props.dataSelecionada,
    fim: '',
    preço: '',
    valor_pago: '',
    personalizado: false,
    notas: '',
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        personalizado: data.personalizado ? 1 : 0,
    })).post(store().url);
};
</script>

<template>

    <Head title="Nova reserva" />


    <div class="max-w-6xl space-y-6 p-4 md:p-6">
        <div>
            <h1 class="text-xl font-semibold tracking-tight">
                Nova reserva para dia {{ dataCurta(form.começo) }}
            </h1>
            <p class="text-sm text-muted-foreground">
                Preencha os dados para cadastrar uma reserva.
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <section class="space-y-6 rounded-xl border p-6">

                <div class="space-y-2">
                    <Label class="font-semibold text-lg" for="notas">Informações</Label>

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

            <section class="space-y-6 rounded-xl border p-6">
                <div>
                    <h2 class="font-semibold">Dados da reserva</h2>
                    <p class="text-sm text-muted-foreground">
                        Cliente, período e situação do agendamento.
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
                    Limpar
                </Button>

                <Button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Salvando...' : 'Salvar reserva' }}
                </Button>
            </div>
        </form>
    </div>
</template>
```
