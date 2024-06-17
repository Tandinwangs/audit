<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Issue extends Model
{
    public function engagement(): BelongsTo
    {
        return $this->belongsTo(Engagement::class);
    }
 
    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }
}
