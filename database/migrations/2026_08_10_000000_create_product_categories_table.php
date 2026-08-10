<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Seed kategori default
        DB::table('product_categories')->insert([
            ['name' => 'OBAT',               'icon' => '💊', 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SKINCARE & KOSMETIK','icon' => '✨', 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ALAT KESEHATAN',     'icon' => '🩺', 'sort_order' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
