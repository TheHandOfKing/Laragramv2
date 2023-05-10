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
            $table->unsignedInteger('likables_id');
            $table->string('likables_type');
            $table->tinyInteger('like')->comment('1: like');
            $table->timestamps();
            $table->unique(['user_id', 'likables_id', 'likables_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likables');
    }
};
