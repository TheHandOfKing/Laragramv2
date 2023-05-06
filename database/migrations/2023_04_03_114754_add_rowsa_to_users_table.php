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
        Schema::table('users', function (Blueprint $table) {
            $table->string('banned_at')->default(null)->nullable();
            $table->integer('ban_notice')->default(0);
            $table->boolean('active')->default(0);
            $table->string('slug')->unique()->nullable();
            $table->string('geolocation')->default('');
            $table->string('mac_address')->default('');
            $table->timestamp('last_seen_at')->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('banned_at');
            $table->dropColumn('ban_notice');
            $table->dropColumn('slug');
            $table->dropColumn('active');
            $table->dropColumn('geolocation');
            $table->dropColumn('mac_address');
            $table->dropColumn('last_seen_at');
            $table->dropSoftDeletes();
        });
    }
};
