<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentarios';

    public const CREATED_AT = 'criado_em';

    public const UPDATED_AT = null;

    protected $fillable = [
        'chamado_id',
        'usuario_id',
        'conteudo',
    ];

    public function chamado(): BelongsTo
    {
        return $this->belongsTo(Chamado::class, 'chamado_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}