<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class ReservaCalendarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "cliente" => $this->cliente->nome ?? "não especificado",
            "status" => $this->status->tipo,
            "start" => $this->começo,
            "end" => $this->fim,
            "title" => $this->titulo,
            "atualizado" => $this->updated_at,
        ];
    }
}
