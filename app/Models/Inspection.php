<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inspection extends Model
{
    protected $fillable = [
        'inspection_plan_id',
        'inspector_id',
        'target_type',
        'target_external_id',
        'target_name',
        'inspection_date',
        'result',
        'status',
    ];

    protected function casts(): array
    {
        return ['inspection_date' => 'datetime'];
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(InspectionPlan::class, 'inspection_plan_id');
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(Inspector::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InspectionItem::class);
    }

    public function findings(): HasMany
    {
        return $this->hasMany(Finding::class);
    }
}
