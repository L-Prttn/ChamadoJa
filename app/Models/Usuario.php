<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;

    protected $table = 'usuarios';

    public const CREATED_AT = 'criado_em';

    public const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'nome',
        'email',
        'senha_hash',
        'tipo',
    ];

    protected $hidden = [
        'senha_hash',
    ];

    public function getAuthPassword(): ?string
    {
        return $this->senha_hash;
    }

    public function chamados(): HasMany
    {
        return $this->hasMany(Chamado::class, 'solicitante_id');
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class, 'usuario_id');
    }

    public function historicoStatus(): HasMany
    {
        return $this->hasMany(HistoricoStatus::class, 'usuario_id');
    }
}
