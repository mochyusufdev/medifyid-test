@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-group mb-2">
                    <a href="{{ url('kategori-items') }}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
                    <a target="_blank" href="{{ route('reportKategori', $data->id) }}" class="btn btn-success">Cetak Laporan</a>
                </div>
                <div class="card mb-3">
                    <div class="card-header">Kategori Item</div>

                    <div class="card-body">
                        <table>
                            <tr>
                                <th>Kode Kategori</th>
                                <td>:</td>
                                <td>{{ $data->kode }}</td>
                            </tr>
                            <tr>
                                <th>Nama Kategori</th>
                                <td>:</td>
                                <td>{{ $data->nama }}</td>
                            </tr>
                        </table>
                        <a class="btn btn-info" href="{{ url('kategori-items/form/edit') }}/{{ $data->id }}">Edit</a>
                        <a class="btn btn-danger" href="{{ url('kategori-items/delete') }}/{{ $data->id }}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">Master Item yang terhubung</div>

                    <div class="card-body">
                        <table>
                            @foreach ($items as $item)
                                <tr>
                                    <th>Kode Item</th>
                                    <td>:</td>
                                    <td>{{ $item->kode }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Item</th>
                                    <td>:</td>
                                    <td>{{ $item->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Harga Beli</th>
                                    <td>:</td>
                                    <td>{{ $item->harga_beli }}</td>
                                </tr>
                                <tr>
                                    <th>Laba</th>
                                    <td>:</td>
                                    <td>{{ $item->laba }}</td>
                                </tr>
                                <tr>
                                    <th>Harga Jual</th>
                                    <td>:</td>
                                    <td>{{ $item->harga_beli + ($item->harga_beli * $item->laba) / 100 }}</td>
                                </tr>
                                <tr>
                                    <th>Supplier</th>
                                    <td>:</td>
                                    <td>{{ $item->supplier }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis</th>
                                    <td>:</td>
                                    <td>{{ $item->jenis }}</td>
                                </tr>
                                <tr>
                                    <th>Foto</th>
                                    <td>:</td>
                                    <td> <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" width="100"></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <hr>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
