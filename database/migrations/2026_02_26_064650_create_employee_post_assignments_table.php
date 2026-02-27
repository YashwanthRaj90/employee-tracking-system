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
        Schema::create('employee_post_assignments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('employee_id')
          ->constrained()
          ->restrictOnDelete();

    $table->foreignId('post_id')
          ->constrained()
          ->restrictOnDelete();

    $table->date('from_date');
    $table->date('to_date')->nullable();
    $table->boolean('is_current')->default(true);
    $table->timestamps();

    $table->index(['employee_id', 'is_current']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_post_assignments');
    }
};
