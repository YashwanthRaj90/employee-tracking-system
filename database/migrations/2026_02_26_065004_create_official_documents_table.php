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
        Schema::create('official_documents', function (Blueprint $table) {
    $table->id();
    $table->foreignId('employee_id')->constrained()->restrictOnDelete();
    $table->enum('document_type', ['NOTING', 'LETTER']);
    $table->enum('language', ['HINDI', 'ENGLISH', 'BILINGUAL']);
    $table->date('document_date');
    $table->string('financial_year');
    $table->integer('month');
    $table->timestamps();

    $table->index(['employee_id', 'document_date']);
    $table->index(['financial_year', 'month']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('official_documents');
    }
};
