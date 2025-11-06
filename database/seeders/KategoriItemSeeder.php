<?php

namespace Database\Seeders;

use App\Models\KategoriItem;
use Illuminate\Database\Seeder;

class KategoriItemSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriItems = [
            [
                'kode' => '00001',
                'nama' => 'Persediaan Umum',
            ],
            [
                'kode' => '00002',
                'nama' => 'Stok Habis Pakai',
            ],
            [
                'kode' => '00003',
                'nama' => 'Stok Tahan Lama',
            ],
        ];

        foreach ($kategoriItems as $kategoriItem) {
            KategoriItem::create($kategoriItem);
        }
    }
}
