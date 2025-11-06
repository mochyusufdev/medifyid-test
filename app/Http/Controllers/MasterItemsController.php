<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use App\Models\KategoriItem;
use Illuminate\Http\Request;
use App\Exports\MasterItemsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        $data_search = MasterItem::query();

        $data_search = $data_search->where(function ($q) use ($kode, $nama, $hargamin, $hargamax) {
            if (!empty($kode)) $q->orWhere('kode', $kode);
            if (!empty($nama)) $q->orWhere('nama', 'LIKE', '%' . $nama . '%');

            if (!empty($hargamin) && !empty($hargamax)) {
                $q->whereBetween('harga_beli', [$hargamin, $hargamax]);
            } elseif (!empty($hargamin)) {
                $q->where('harga_beli', '>=', $hargamin);
            } elseif (!empty($hargamax)) {
                $q->where('harga_beli', '<=', $hargamax);
            }
        });

        $data_search = $data_search->select('kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier')->orderBy('id')->get();


        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = [];
        } else {
            $item = MasterItem::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        $data['kategori_items'] = KategoriItem::all();
        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::with('kategori')->where('kode', $kode)->first();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new MasterItem;
            $kode = MasterItem::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data_item = MasterItem::find($id);
            $kode = $data_item->kode;
        }

        $data_item->nama = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba = $request->laba;
        $data_item->kode = $kode;
        $data_item->supplier = $request->supplier;
        $data_item->jenis = $request->jenis;
        $data_item->kategori_id = $request->kategori_id;

        if ($request->hasFile('foto')) {
            if ($data_item->foto && Storage::disk('public')->exists($data_item->foto)) {
                Storage::disk('public')->delete($data_item->foto);
            }
            $data_item->foto = $request->file('foto')->store("master_items", 'public');
        }

        $data_item->save();

        return redirect('master-items');
    }

    public function delete($id)
    {
        $data_item = MasterItem::find($id);
        if ($data_item->foto && Storage::disk('public')->exists($data_item->foto)) {
            Storage::disk('public')->delete($data_item->foto);
        }
        MasterItem::find($id)->delete();
        return redirect('master-items');
    }

    public function exportExcel()
    {
        $fileName = 'master_items_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new MasterItemsExport, $fileName);
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach ($data as $item) {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100, 1000000);
            $item->laba = rand(10, 99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi', 'Bukulapuk', 'TokoBagas', 'E Commurz', 'Blublu'];
        $random = rand(0, 4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat', 'Alkes', 'Matkes', 'Umum', 'ATK'];
        $random = rand(0, 4);
        return $array[$random];
    }
}
