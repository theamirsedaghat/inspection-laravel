<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InspectionPlan extends Model
{
    protected $fillable = [
        'inspection_type_id',
        'title',
        'planned_date',
        'frequency',
        'end_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'planned_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(InspectionType::class, 'inspection_type_id');
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }
}
