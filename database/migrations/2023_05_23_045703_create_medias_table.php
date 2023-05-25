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
        Schema::create('medias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('name')->nullable()->index();
            $table->string('filename')->nullable()->index();
            $table->string('slug')->unique()->index();
            $table->string('folder')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('extension')->nullable();
            $table->bigInteger('size')->nullable();
            $table->string('path')->nullable();
            $table->string('url')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medias');
    }
};
