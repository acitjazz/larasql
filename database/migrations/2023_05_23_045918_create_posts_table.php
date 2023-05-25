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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->json('title')->nullable();
            $table->json('slug')->nullable();
            $table->json('subtitle')->nullable();
            $table->string('type',100)->nullable();
            $table->string('direct_url')->nullable();
            $table->string('youtube_id',100)->nullable();
            $table->json('summary')->nullable();
            $table->json('description')->nullable();
            $table->integer('position')->nullable();
            $table->json('images')->nullable();
            $table->json('banners')->nullable();
            $table->json('files')->nullable();
            $table->json('options')->nullable();
            $table->json('buttons')->nullable();
            $table->json('meta')->nullable();
            $table->boolean('featured')->nullable();
            $table->string('status',100)->nullable();
            $table->bigInteger('views')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            // $table->string('title')->storedAs('JSON_UNQUOTE(title->>"$.title")')->index();
            // $table->string('slug')->storedAs('JSON_UNQUOTE(slug->>"$.slug")')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
