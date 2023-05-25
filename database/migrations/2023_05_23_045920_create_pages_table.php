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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->json('title')->nullable();
            $table->json('slug')->nullable();
            $table->json('subtitle')->nullable();
            $table->string('type',100)->nullable();
            $table->string('template',100)->nullable();
            $table->json('summary')->nullable();
            $table->json('description')->nullable();
            $table->integer('position')->nullable();
            $table->json('images')->nullable();
            $table->json('banners')->nullable();
            $table->json('contents')->nullable();
            $table->json('options')->nullable();
            $table->json('buttons')->nullable();
            $table->json('sections')->nullable();
            $table->json('meta')->nullable();
            $table->boolean('featured')->nullable();
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
        Schema::dropIfExists('pages');
    }
};
