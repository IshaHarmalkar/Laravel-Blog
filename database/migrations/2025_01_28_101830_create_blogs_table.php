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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
    
            $table->string('title'); // Matches the 'title' field in the model
            $table->text('content'); // Matches the 'content' field in the model
            $table->string('author')->nullable(); // Matches the 'author' field, nullable
            $table->timestamp('published_at')->nullable(); // Matches the 'published_at' field, nullable
            $table->timestamps(); // Adds 'created_at' and 'updated_at'
             
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
