<!--
  ============================================================================
  ComboboxField.vue
  ============================================================================

  Campo de seleção com busca integrada (combobox), para listas grandes onde o
  componente <Select> padrão fica difícil de usar.

  Construído sobre os componentes Popover e Command do shadcn-vue (reka-ui).

  Criado por Claude (Anthropic).

  ----------------------------------------------------------------------------
  INSTALAÇÃO DAS DEPENDÊNCIAS
  ----------------------------------------------------------------------------
    npx shadcn-vue@latest add popover command

  ----------------------------------------------------------------------------
  PROPS
  ----------------------------------------------------------------------------
    v-model            (qualquer)  Valor selecionado, ou seja, o valor da
                                   propriedade definida em `optionValue`.
                                   Devolvido sem conversão de tipo.
    options            (Array)     Obrigatório. Lista de objetos.
                                   Ex.: [{ id: 1, nome: 'Ana' }]
    optionValue        (String)    Propriedade usada como valor.
                                   Padrão: 'id'
    optionLabel        (String)    Propriedade exibida e usada na busca.
                                   Padrão: 'name'
    id                 (String)    Id do botão, para ligar com <Label for>.
    placeholder        (String)    Texto quando não há seleção.
                                   Padrão: 'Selecione...'
    searchPlaceholder  (String)    Texto do campo de busca.
                                   Padrão: 'Buscar...'
    emptyText          (String)    Texto quando a busca não retorna resultados.
                                   Padrão: 'Nenhum resultado encontrado.'
    disabled           (Boolean)   Desabilita o seletor. Padrão: false

  ----------------------------------------------------------------------------
  EXEMPLO DE USO
  ----------------------------------------------------------------------------
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

  ----------------------------------------------------------------------------
  OBSERVAÇÕES
  ----------------------------------------------------------------------------
    - A comparação entre o valor do v-model e o das opções é feita com
      String() nos dois lados, evitando o problema 5 !== "5".
    - Por ser um botão e não um <input>, o atributo `required` do navegador
      não se aplica. A validação deve ser feita no backend (Laravel).
    - Largura do popover: usa a sintaxe do Tailwind v4
      `w-(--reka-popover-trigger-width)`. No Tailwind v3, use
      `w-[--reka-popover-trigger-width]`. Se o seu PopoverContent usa Radix,
      a variável é `--radix-popover-trigger-width`.
    - O `value` de cada CommandItem é o texto do rótulo, pois é por ele que o
      Command filtra. Se houver rótulos repetidos, use algo como
      `${rótulo} ${id}` para diferenciá-los.
  ============================================================================
-->

<script setup>
import { ref, computed } from 'vue';
import { Check, ChevronsUpDown } from '@lucide/vue';
import { cn } from '@/lib/utils';

import Button from '@/components/ui/button/Button.vue';
import Popover from '@/components/ui/popover/Popover.vue';
import PopoverTrigger from '@/components/ui/popover/PopoverTrigger.vue';
import PopoverContent from '@/components/ui/popover/PopoverContent.vue';
import Command from '@/components/ui/command/Command.vue';
import CommandInput from '@/components/ui/command/CommandInput.vue';
import CommandList from '@/components/ui/command/CommandList.vue';
import CommandEmpty from '@/components/ui/command/CommandEmpty.vue';
import CommandGroup from '@/components/ui/command/CommandGroup.vue';
import CommandItem from '@/components/ui/command/CommandItem.vue';

const props = defineProps({
    /** Lista de objetos a exibir. Ex.: [{ id: 1, nome: 'Ana' }] */
    options: {
        type: Array,
        required: true,
    },
    /** Nome da propriedade usada como valor (o que o v-model armazena). */
    optionValue: {
        type: String,
        default: 'id',
    },
    /** Nome da propriedade exibida na lista e usada na busca. */
    optionLabel: {
        type: String,
        default: 'name',
    },
    /** Id do botão, para associar com um <Label for="...">. */
    id: {
        type: String,
        default: undefined,
    },
    /** Texto mostrado quando nenhuma opção está selecionada. */
    placeholder: {
        type: String,
        default: 'Selecione...',
    },
    /** Texto de ajuda dentro do campo de busca. */
    searchPlaceholder: {
        type: String,
        default: 'Buscar...',
    },
    /** Texto mostrado quando a busca não encontra nada. */
    emptyText: {
        type: String,
        default: 'Nenhum resultado encontrado.',
    },
    /** Desabilita o seletor. */
    disabled: {
        type: Boolean,
        default: false,
    },
});

/**
 * v-model do componente.
 * Guarda o valor da opção exatamente como veio (número ou string).
 */
const model = defineModel({ default: null });

/** Controla se o popover está aberto. */
const open = ref(false);

/**
 * Indica se uma opção é a atualmente selecionada.
 * Compara com String() nos dois lados para evitar o problema 5 !== "5".
 */
const isSelected = (option) =>
    model.value !== null &&
    model.value !== '' &&
    String(option[props.optionValue]) === String(model.value);

/** Objeto da opção selecionada (ou undefined se não houver). */
const selectedOption = computed(() =>
    props.options.find((option) => isSelected(option)),
);

/** Atualiza o v-model com a opção escolhida e fecha o popover. */
const select = (option) => {
    model.value = option[props.optionValue];
    open.value = false;
};

/*
 * Criado por Claude (Anthropic).
 */
</script>

<template>
    <Popover v-model:open="open">
        <!-- Botão que abre o seletor e mostra a opção atual -->
        <PopoverTrigger as-child>
            <Button
                :id="id"
                type="button"
                variant="outline"
                role="combobox"
                :aria-expanded="open"
                :disabled="disabled"
                class="w-full justify-between font-normal"
            >
                <span
                    :class="cn('truncate', !selectedOption && 'text-muted-foreground')"
                >
                    {{ selectedOption ? selectedOption[optionLabel] : placeholder }}
                </span>
                <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
            </Button>
        </PopoverTrigger>

        <!-- Painel com campo de busca e lista de opções -->
        <PopoverContent class="w-(--reka-popover-trigger-width) p-0">
            <Command>
                <CommandInput :placeholder="searchPlaceholder" />
                <CommandList>
                    <CommandEmpty>{{ emptyText }}</CommandEmpty>
                    <CommandGroup>
                        <CommandItem
                            v-for="option in options"
                            :key="option[optionValue]"
                            :value="String(option[optionLabel])"
                            @select="select(option)"
                        >
                            <Check
                                :class="cn(
                                    'mr-2 h-4 w-4',
                                    isSelected(option) ? 'opacity-100' : 'opacity-0',
                                )"
                            />
                            {{ option[optionLabel] }}
                        </CommandItem>
                    </CommandGroup>
                </CommandList>
            </Command>
        </PopoverContent>
    </Popover>
</template>
