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
        Schema::create('findings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inspection_id')
                ->constrained('inspections')
                ->cascadeOnDelete();

            $table->text('finding_description');

            $table->enum('severity', [
                'low',
                'medium',
                'high',
                'critical',
            ])->default('medium');

            $table->enum('follow_up_status', [
                'open',
                'in_progress',
                'resolved',
            ])->default('open');

            $table->date('correction_deadline')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('findings');
    }
};
