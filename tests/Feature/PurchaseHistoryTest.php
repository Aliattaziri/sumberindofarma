<?php

namespace Tests\Feature;

use App\Models\PurchaseHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class PurchaseHistoryTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function test_purchase_history_can_be_stored_via_public_endpoint(): void
    {
        $response = $this->postJson('/orders/history', [
            'buyer_type' => 'apotik',
            'buyer_name' => 'Apotik Sehat',
            'phone' => '081234567890',
            'address' => 'Jl. Contoh No. 1',
            'kecamatan' => 'Kemayoran',
            'kota' => 'Jakarta Pusat',
            'sia' => 'SIA-001',
            'sipa' => 'SIPA-001',
            'items' => [
                ['name' => 'Paracetamol', 'qty' => 2, 'price' => 15000],
            ],
            'total' => 30000,
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('purchase_histories', [
            'buyer_name' => 'Apotik Sehat',
            'buyer_type' => 'apotik',
            'total' => 30000,
        ]);
    }

    public function test_purchase_history_can_store_pbf_buyer_type(): void
    {
        $response = $this->postJson('/orders/history', [
            'buyer_type' => 'pbf',
            'buyer_name' => 'PT Contoh PBF',
            'phone' => '081234567891',
            'address' => 'Jl. PBF No. 10',
            'kecamatan' => 'Ilir Timur II',
            'kota' => 'Palembang',
            'sia' => 'SIA-PBF-001',
            'sipa' => 'SIPA-PBF-001',
            'items' => [
                ['name' => 'Paracetamol', 'qty' => 1, 'price' => 10000],
            ],
            'total' => 10000,
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('purchase_histories', [
            'buyer_name' => 'PT Contoh PBF',
            'buyer_type' => 'pbf',
            'total' => 10000,
        ]);
    }

    public function test_outlet_admin_only_sees_own_purchase_history_and_omzet(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
            'email' => 'alfa.airupas@sumberindofarma.com',
            'password' => bcrypt('secret'),
        ]);

        $this->actingAs($user);

        PurchaseHistory::create([
            'buyer_type' => 'apotik',
            'buyer_name' => 'Apotik Alfa Air Upas',
            'phone' => '0811',
            'address' => 'Jl. Air Upas',
            'items' => [['nama_obat' => 'Obat A', 'quantity' => 2, 'harga' => 50000, 'potongan' => 0]],
            'source_outlet' => 'Alfa Air Upas',
            'total' => 100000,
            'original_total' => 100000,
            'discounted_total' => 100000,
            'approval_status' => 'approved',
        ]);

        PurchaseHistory::create([
            'buyer_type' => 'apotik',
            'buyer_name' => 'Apotik Alfa Sintang',
            'phone' => '0812',
            'address' => 'Jl. Sintang',
            'items' => [['nama_obat' => 'Obat B', 'quantity' => 1, 'harga' => 70000, 'potongan' => 0]],
            'source_outlet' => 'Alfa Sintang',
            'total' => 70000,
            'original_total' => 70000,
            'discounted_total' => 70000,
            'approval_status' => 'approved',
        ]);

        $response = $this->get('/admin/purchase-history');

        $response->assertOk();
        $response->assertSee('Alfa Air Upas');
        $response->assertDontSee('Alfa Sintang');
    }

    public function test_super_admin_can_see_every_outlet_history(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
            'email' => 'superadmin@custom.test',
            'password' => bcrypt('secret'),
        ]);

        $this->actingAs($user);

        PurchaseHistory::create([
            'buyer_type' => 'apotik',
            'buyer_name' => 'Apotik Alfa Sintang',
            'phone' => '0812',
            'address' => 'Jl. Sintang',
            'items' => [['nama_obat' => 'Obat S', 'quantity' => 1, 'harga' => 90000, 'potongan' => 0]],
            'source_outlet' => 'Alfa Sintang',
            'total' => 90000,
            'original_total' => 90000,
            'discounted_total' => 90000,
            'approval_status' => 'approved',
        ]);

        PurchaseHistory::create([
            'buyer_type' => 'apotik',
            'buyer_name' => 'Apotik Alfa Air Upas',
            'phone' => '0813',
            'address' => 'Jl. Air Upas',
            'items' => [['nama_obat' => 'Obat A', 'quantity' => 3, 'harga' => 50000, 'potongan' => 0]],
            'source_outlet' => 'Alfa Air Upas',
            'total' => 150000,
            'original_total' => 150000,
            'discounted_total' => 150000,
            'approval_status' => 'approved',
        ]);

        $response = $this->get('/admin/purchase-history');

        $response->assertOk();
        $response->assertSee('Alfa Sintang');
        $response->assertSee('Alfa Air Upas');
    }
}
