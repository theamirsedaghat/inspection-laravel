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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inspection_plan_id')
                ->constrained('inspection_plans')
                ->restrictOnDelete();

            $table->foreignId('inspector_id')
                ->constrained('inspectors')
                ->restrictOnDelete();

            $table->string('target_type')->nullable();
            $table->string('target_external_id')->nullable();
            $table->string('target_name')->nullable();

            $table->dateTime('inspection_date');

            $table->text('result')->nullable();

            $table->enum('status', [
                'scheduled',
                'in_progress',
                'completed',
                'cancelled',
            ])->default('scheduled');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
