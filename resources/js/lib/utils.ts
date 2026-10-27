import type { InertiaLinkProps } from '@inertiajs/vue3';
import { clsx } from 'clsx';
import type { ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';
import { formatDate } from '@vueuse/core'

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function toUrl(href: NonNullable<InertiaLinkProps['href']>) {
    return typeof href === 'string' ? href : href?.url;
}


export function dataCurta(data: string | null): string {
    if (!data) return 'Não informado'

    const dataValida = new Date(data)

    if (Number.isNaN(dataValida.getTime())) return data

    return formatDate(dataValida, 'DD [de] MMMM')
}

export function dataLonga(data: string | null): string {
    if (!data) return 'Não informado'

    const dataValida = new Date(data)

    if (Number.isNaN(dataValida.getTime())) return data

    return formatDate(dataValida, 'DD [de] MMMM [ás] HH:mm a')
}

export function hora(data: string | null): string {
    if (!data) return 'Não informado'

    const dataValida = new Date(data)

    if (Number.isNaN(dataValida.getTime())) return data

    return formatDate(dataValida, 'HH:mm a')
}


export function moeda(valor: string | null): string {
    if (valor === null || valor === '') return 'Não informado'

    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
    }).format(Number(valor))
}
