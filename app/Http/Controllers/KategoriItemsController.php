<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Category;
use Barryvdh\DomPDF\PDF;
use App\Models\MasterItem;
use App\Models\KategoriItem;
use Illuminate\Http\Request;

class KategoriItemsController extends Controller
{
    public function index()
    {
        return view('kategori_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;

        $data_search = KategoriItem::query();
        $data_search = $data_search->where(function ($q) use ($kode, $nama) {
            if (!empty($kode)) $q->orWhere('kode', $kode);
            if (!empty($nama)) $q->orWhere('nama', 'LIKE', '%' . $nama . '%');
        });

        $data_search = $data_search->select('kode', 'nama')->orderBy('id')->get();

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
            $item = KategoriItem::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        return view('kategori_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = KategoriItem::where('kode', $kode)->first();

        $data['items'] = MasterItem::whereHas('kategori', function ($query) use ($kode) {
            $query->where('kode', $kode);
        })->get();

        // dd($data['items']->toArray());

        return view('kategori_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new KategoriItem;
            $kode = KategoriItem::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            // sleep(3);
        } else {
            $data_item = KategoriItem::find($id);
            $kode = $data_item->kode;
        }

        $data_item->nama = $request->nama;
        $data_item->kode = $kode;
        $data_item->save();

        return redirect('kategori-items');
    }

    public function delete($id)
    {
        KategoriItem::find($id)->delete();
        return redirect('kategori-items');
    }

    public function exportPdf($id, PDF $pdf)
    {
        $kategori = KategoriItem::with('masterItems')->findOrFail($id);

        $waktuCetak = Carbon::now()->format('d-m-Y H:i:s');

        $pdf->loadView('kategori_items.report.index', [
            'kategori' => $kategori,
            'waktuCetak' => $waktuCetak,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('kategori_' . $kategori->kode . '.pdf');
    }
}
