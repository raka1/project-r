<?php

namespace Database\Seeders;

use App\Models\Incoming;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class IncomingSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $incomings = [
            [ 'material_name' => 'Tembaga', 'quantity' => 100, 'satuan' => 'kg', 'created_at' => Carbon::create(2025, 1, 15, 10, 30, 0) ],
            [ 'material_name' => 'Aluminium', 'quantity' => 200, 'satuan' => 'kg', 'created_at' => Carbon::create(2025, 1, 20, 11, 0, 0) ],
            [ 'material_name' => 'Kawat Nikrom', 'quantity' => 50, 'satuan' => 'roll', 'created_at' => Carbon::create(2025, 2, 5, 9, 0, 0) ],
            [ 'material_name' => 'Plastik PVC', 'quantity' => 30, 'satuan' => 'kg', 'created_at' => Carbon::create(2025, 2, 18, 16, 20, 0) ],
            [ 'material_name' => 'Besi', 'quantity' => 120, 'satuan' => 'batang', 'created_at' => Carbon::create(2025, 3, 2, 8, 15, 0) ],
            [ 'material_name' => 'Kuningan', 'quantity' => 80, 'satuan' => 'kg', 'created_at' => Carbon::create(2025, 3, 10, 13, 40, 0) ],
            [ 'material_name' => 'Timah', 'quantity' => 60, 'satuan' => 'kg', 'created_at' => Carbon::create(2025, 3, 22, 14, 45, 0) ],
            [ 'material_name' => 'Perunggu', 'quantity' => 40, 'satuan' => 'kg', 'created_at' => Carbon::create(2025, 4, 1, 10, 0, 0) ],
            [ 'material_name' => 'Seng', 'quantity' => 90, 'satuan' => 'lembar', 'created_at' => Carbon::create(2025, 4, 12, 15, 30, 0) ],
            [ 'material_name' => 'Akrilik', 'quantity' => 25, 'satuan' => 'lembar', 'created_at' => Carbon::create(2025, 4, 25, 11, 10, 0) ],
            [ 'material_name' => 'Kabel Tembaga', 'quantity' => 70, 'satuan' => 'roll', 'created_at' => Carbon::create(2025, 5, 5, 9, 0, 0) ],
            [ 'material_name' => 'Fiber', 'quantity' => 55, 'satuan' => 'meter', 'created_at' => Carbon::create(2025, 5, 15, 14, 0, 0) ],
            [ 'material_name' => 'Karet', 'quantity' => 35, 'satuan' => 'kg', 'created_at' => Carbon::create(2025, 5, 28, 10, 30, 0) ],
            [ 'material_name' => 'Stainless Steel', 'quantity' => 110, 'satuan' => 'kg', 'created_at' => Carbon::create(2025, 6, 3, 13, 0, 0) ],
            [ 'material_name' => 'Galvalum', 'quantity' => 95, 'satuan' => 'lembar', 'created_at' => Carbon::create(2025, 6, 18, 16, 20, 0) ],
            [ 'material_name' => 'Plastik Mika', 'quantity' => 45, 'satuan' => 'kg', 'created_at' => Carbon::create(2025, 7, 1, 8, 0, 0) ],
            [ 'material_name' => 'PVC Foam', 'quantity' => 60, 'satuan' => 'lembar', 'created_at' => Carbon::create(2025, 7, 12, 12, 0, 0) ],
            [ 'material_name' => 'Acrylic Rod', 'quantity' => 20, 'satuan' => 'batang', 'created_at' => Carbon::create(2025, 7, 25, 15, 0, 0) ],
            [ 'material_name' => 'Kawat Baja', 'quantity' => 85, 'satuan' => 'roll', 'created_at' => Carbon::create(2025, 7, 28, 9, 0, 0) ],
            [ 'material_name' => 'Plastik HDPE', 'quantity' => 100, 'satuan' => 'kg', 'created_at' => Carbon::create(2025, 7, 30, 10, 0, 0) ],
        ];

        foreach ($incomings as $incoming) {
            Incoming::create($incoming);
        }
    }
}
