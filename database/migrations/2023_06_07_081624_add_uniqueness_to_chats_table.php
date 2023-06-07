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
        // Delete duplicates
        DB::statement('
            DELETE c1 FROM chats c1
            INNER JOIN chats c2 
            WHERE 
                c1.id > c2.id AND 
                c1.chatter_id = c2.chatter_id AND 
                c1.other_chatter_id = c2.other_chatter_id
        ');

        Schema::table('chats', function (Blueprint $table) {
            $table->unique(['chatter_id', 'other_chatter_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropUnique(['chatter_id', 'other_chatter_id']);
        });
    }
};
