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
        Schema::table('posts', function (Blueprint $table) {
            // Add the 'pinned_comment_id' column
            $table->unsignedBigInteger('pinned_comment_id')->nullable();

            // Create the foreign key constraint
            $table->foreign('pinned_comment_id')->references('id')->on('comments')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['pinned_comment_id']);

            // Drop the 'pinned_comment_id' column
            $table->dropColumn('pinned_comment_id');
        });
    }
};
