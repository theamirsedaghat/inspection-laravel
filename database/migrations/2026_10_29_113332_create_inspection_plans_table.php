<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inspection_plans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inspection_type_id')
                ->constrained('inspection_types')
                ->restrictOnDelete();

            $table->string('title');
            $table->date('planned_date');
            $table->enum('frequency', [
                'weekly',
                'monthly',
                'yearly',
            ]);

            $table->date('end_date')->nullable();

            $table->enum('status', [
                'draft',
                'active',
                'completed',
                'cancelled',
            ])->default('draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspection_plans');
    }
};
