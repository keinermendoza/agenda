<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reserva;

/**
 * @property int $id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string $tipo
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservaStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservaStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservaStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservaStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservaStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservaStatus whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservaStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[Fillable(['tipo'])]
class ReservaStatus extends Model
{
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
