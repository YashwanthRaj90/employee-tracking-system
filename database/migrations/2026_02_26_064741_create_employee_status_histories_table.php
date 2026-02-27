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
        Schema::create('employee_status_histories', function (Blueprint $table) {
    $table->id();
    $table->foreignId('employee_id')->constrained()->restrictOnDelete();
    $table->foreignId('employee_status_id')->constrained()->restrictOnDelete();
    $table->date('effective_from');
    $table->date('effective_to')->nullable();
    $table->boolean('is_current')->default(true);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_status_histories');
    }
};
