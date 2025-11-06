<?php

namespace Database\Seeders;

use App\Models\MasterItem;
use Illuminate\Database\Seeder;

class MasterSeeder extends Seeder
{
    public function run(): void
    {
        $masters = [
            [
                'kategori_id' => 1,
                'kode' => '00001',
                'nama' => 'Bodrex',
                'harga_beli' => 10000,
                'laba' => 10,
                'supplier' => 'Tokopaedi',
                'jenis' => 'Obat',
                'foto' => 'master_items/vacb2OjiV6R3ztbRigHWEMmkNXpQtZNv58rTeHdB.png'
            ],
            [
                'kategori_id' => 1,
                'kode' => '00002',
                'nama' => 'Paracetamol',
                'harga_beli' => 12000,
                'laba' => 5,
                'supplier' => 'Tokopaedi',
                'jenis' => 'Obat',
                'foto' => 'master_items/vacb2OjiV6R3ztbRigHWEMmkNXpQtZNv58rTeHdB.png'
            ],
            [
                'kategori_id' => 2,
                'kode' => '00003',
                'nama' => 'Ibuprofen',
                'harga_beli' => 20000,
                'laba' => 7,
                'supplier' => 'Tokopaedi',
                'jenis' => 'Obat',
                'foto' => 'master_items/vacb2OjiV6R3ztbRigHWEMmkNXpQtZNv58rTeHdB.png'
            ],
        ];

        foreach ($masters as $master) {
            MasterItem::create($master);
        }
    }
}
