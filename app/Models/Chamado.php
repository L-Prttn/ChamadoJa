<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chamado extends Model
{
    use HasFactory;

    protected $table = 'chamados';

    public const CREATED_AT = 'criado_em';

    public const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'solicitante_id',
        'categoria_id',
        'titulo',
        'descricao',
        'prioridade',
        'status',
    ];

    public function solicitante(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'solicitante_id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class, 'chamado_id');
    }

    public function historicoStatus(): HasMany
    {
        return $this->hasMany(HistoricoStatus::class, 'chamado_id');
    }
}