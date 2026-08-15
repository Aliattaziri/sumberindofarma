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
        Schema::table('news', function (Blueprint $table) {
            $table->unsignedInteger('like_count')->default(0)->after('views');
            $table->unsignedInteger('comment_count')->default(0)->after('like_count');
            $table->unsignedInteger('share_count')->default(0)->after('comment_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['like_count', 'comment_count', 'share_count']);
        });
    }
};
