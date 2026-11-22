<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Finding extends Model
{
    protected $fillable = [
        'inspection_id',
        'finding_description',
        'severity',
        'follow_up_status',
        'correction_deadline',
    ];

    protected function casts(): array
    {
        return [
            'correction_deadline' => 'date',
        ];
    }

    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class);
    }
}
