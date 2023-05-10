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
        Schema::create('likables', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('likable_id');
            $table->string('likable_type');
            $table->tinyInteger('like')->comment('1: like');
            $table->timestamps();
            $table->unique(['user_id', 'likable_id', 'likable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likeables');
    }
};
