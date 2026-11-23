<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    const UPDATED_AT = null;  
    protected $fillable = ['actor_id', 'action', 'entity', 'entity_id'];

    public function actor() { return $this->belongsTo(User::class, 'actor_id'); }
}
