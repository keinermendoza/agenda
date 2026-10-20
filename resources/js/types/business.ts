export type ReservaCalendar = {
    id: number
    cliente: string
    status: string
    start: string
    end: string | null
    title: string | null
}

export type ReservaBase = {
    id: number
    titulo: string
    cliente_id: number
    reserva_status_id: number
    começo: string,
    fim: string,
    preço: number,
    valor_pago: number,
    personalizado: boolean,
    notas: string
    created_at: string
    updated_at: string
}

export type Cliente = {
    id: number
    nome: string
    telefone: string
    data_contato: string
}

export type ReservaStatus = {
    id: number
    tipo: string
}

export type Reserva = ReservaBase & {
    cliente: Cliente
    status: ReservaStatus
}
