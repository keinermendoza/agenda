<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Cliente;
use App\Models\ReservaStatus;

/**
 * @property int $id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string $começo
 * @property string|null $fim
 * @property numeric $preço
 * @property numeric $valor_pago
 * @property int $personalizado
 * @property int $cliente_id
 * @property int|null $reserva_status_id
 * @property string|null $notas
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereClienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereComeço($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereFim($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereNotas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva wherePersonalizado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva wherePreço($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereReservaStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereValorPago($value)
 * @mixin \Eloquent
 */
#[Fillable(['começo', 'fim', 'preço', 'valor_pago', 'personalizado', 'cliente_id', 'reserva_status_id', 'notas'])]
class Reserva extends Model
{
    use HasFactory;

    protected $appends = ['titulo'];
    protected function titulo(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->notas ?
                Str::substr($this->notas, 0, 12)
                : "(Sem titulo) reservado ". $this->created_at->locale('pt_BR')->translatedFormat('d M / H:m ')
        );
    }

    public function status()
    {
        return $this->belongsTo(ReservaStatus::class, "reserva_status_id");
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
