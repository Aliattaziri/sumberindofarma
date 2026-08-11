<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Medicine;

class ApotkMedistraFarmaTest extends TestCase
{
    public function test_users_outlet_configuration()
    {
        $users = User::select('id', 'email', 'outlet_name')->get();
        
        echo "\n=== USERS CONFIGURATION ===\n";
        foreach ($users as $user) {
            echo "ID: {$user->id}, Email: {$user->email}, Outlet: {$user->outlet_name}\n";
        }
        
        $apotek_users = User::where('outlet_name', 'Apotek Medistra Farma')->get();
        echo "\nUsers with outlet 'Apotek Medistra Farma': " . $apotek_users->count() . "\n";
        
        echo "\n=== MEDICINES WITH APOTEK MEDISTRA FARMA CATEGORY ===\n";
        $medicines = Medicine::where('kategori', 'Apotek Medistra Farma')->limit(10)->get();
        echo "Total: " . Medicine::where('kategori', 'Apotek Medistra Farma')->count() . "\n";
        foreach ($medicines as $med) {
            echo "ID: {$med->id}, Nama: {$med->nama_obat}, Kategori: {$med->kategori}, Kelompok: {$med->kelompok}\n";
        }
        
        // Test query
        echo "\n=== TESTING QUERY ===\n";
        $outletNames = ['Alfa Sintang', 'Alfa Air Upas', 'Apotek Medistra Farma'];
        $selectedOutlet = 'Apotek Medistra Farma';
        
        $query = Medicine::where(function ($q) use ($selectedOutlet, $outletNames) {
            $q->where('kategori', $selectedOutlet)
              ->orWhereRaw('LOWER(kategori) = ?', [strtolower($selectedOutlet)]);
        })->nonPbf();
        
        echo "SQL: " . $query->toSql() . "\n";
        echo "Bindings: " . json_encode($query->getBindings()) . "\n";
        echo "Count: " . $query->count() . "\n";
        
        $this->assertTrue(true);
    }
}
