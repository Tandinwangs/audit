<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function engagement(): BelongsTo
    {
        return $this->belongsTo(Engagement::class);
    }
}
