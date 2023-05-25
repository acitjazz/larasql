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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();
            $table->json('slug')->nullable();
            $table->string('type',100)->nullable();
            $table->string('text_color',100)->nullable();
            $table->string('bg_color',100)->nullable();
            $table->json('summary')->nullable();
            $table->json('description')->nullable();
            $table->json('images')->nullable();
            $table->json('meta')->nullable();
            $table->boolean('featured')->nullable();
            $table->bigInteger('views')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
