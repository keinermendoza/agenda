<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\EndereçoFactory;
/**
 * @property int $id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string $endereço
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereço newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereço newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereço query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereço whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereço whereEndereço($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereço whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereço whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[Fillable(['endereço'])]
class Endereço extends Model
{
    /** @use HasFactory<EndereçoFactory> */
    use HasFactory;

    public function clientes ()
    {
        return $this->belongsToMany(Cliente::class);
    }
}
