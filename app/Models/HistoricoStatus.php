<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricoStatus extends Model
{
    use HasFactory;

    protected $table = 'historico_status';

    public const CREATED_AT = 'criado_em';

    public const UPDATED_AT = null;

    protected $fillable = [
        'chamado_id',
        'status_anterior',
        'status_novo',
        'usuario_id',
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