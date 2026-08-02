<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('purchase_histories', function (Blueprint $table) {
            if (! Schema::hasColumn('purchase_histories', 'source_outlet')) {
                $table->string('source_outlet')->nullable()->after('buyer_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_histories', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_histories', 'source_outlet')) {
                $table->dropColumn('source_outlet');
            }
        });
    }
};
