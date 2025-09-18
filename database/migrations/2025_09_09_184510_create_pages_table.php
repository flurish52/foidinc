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
            $table->string('slug')->unique();
            $table->foreignId('parent_id')->nullable()
                ->constrained('pages')
                ->onDelete('cascade');
            $table->string('title');
            $table->string('position');
            $table->longText('content');
            $table->string('thumbnail')->nullable();
            $table->json('sliders')->nullable();
            $table->enum('status', ['draft', 'published'])
                ->default('draft');
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->softDeletes();
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
