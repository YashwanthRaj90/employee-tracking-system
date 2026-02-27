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
        Schema::create('hindi_levels', function (Blueprint $table) {
    $table->id();
    $table->string('code')->unique(); // N, B, K, P
    $table->string('name');
    $table->integer('rank');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hindi_levels');
    }
};
