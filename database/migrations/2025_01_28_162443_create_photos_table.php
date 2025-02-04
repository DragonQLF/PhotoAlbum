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
        // In your photos migration file:
        Schema::create('photos', function (Blueprint $table) {
        $table->id();
        $table->string('path');
        $table->text('description')->nullable(); // Add this line
        $table->foreignId('album_id')->constrained()->cascadeOnDelete();
        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
