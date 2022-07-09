@extends('layouts.app')
@php
function tgl_indo($tanggal)
{
    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
}
@endphp
@section('content')
    <div class="row">
        <div class="col-6 mb-3">
            <h3>Film Terbaru</h3>
        </div>
        <div class="col-6 mb-3 text-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">
                Tambah Data
            </button>
        </div>
    </div>
    <hr>
    <div class="row mb-3">
        @forelse ($movies as $movie)
            <div class="col-md-3 col-sm-12 mb-3">
                <div class="card h-100">
                    <img src="{{ url('poster/' . $movie->poster) }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $movie->nama }}</h5>
                        <p class="card-text">{{ tgl_indo($movie->tanggal_rilis) }}</p>
                    </div>

                    <div class="card-footer">
                        <div class="btn-wrapper text-center">
                            <button class="btn btn-info btn-block mb-2" onclick="ubahData(`{{ $movie }}`)"
                                data-toggle="modal" data-target="#ubahData">Ubah</button>
                            <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-block btn-delete" type="button">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <h6>Tidak ada data</h6>
                </div>
            </div>
        @endforelse

    </div>
    <hr>
    <div class="row text-center">
        <div class="col">
            {!! $movies->links() !!}
        </div>
    </div>

    <div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="tambahDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataLabel">Tambah Film</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('movies.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Film</label>
                            <input type="text" class="form-control" id="nama" name="nama">
                        </div>
                        <div class="form-group">
                            <label for="poster">Poster</label>
                            <input type="file" class="form-control" id="poster" name="poster">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_rilis">Tanggal Rilis</label>
                            <input type="text" class="form-control datepicker" id="tanggal_rilis" name="tanggal_rilis">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ubahData" tabindex="-1" aria-labelledby="ubahDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahDataLabel">Tambah Film</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('movies.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_edit">Nama Film</label>
                            <input type="text" class="form-control" id="nama_edit" name="nama">
                        </div>
                        <div class="form-group">
                            <img src="" class="img-thumbnail" id="poster_img"
                                style="max-height: 30vh;max-width:auto;">
                        </div>
                        <div class="form-group">
                            <label for="nama_edit">Ubah Poster</label>
                            <input type="file" class="form-control" id="nama_edit" name="poster">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_rilis_edit">Tanggal Rilis</label>
                            <input type="text" class="form-control datepicker" id="tanggal_rilis_edit"
                                name="tanggal_rilis">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function ubahData(data) {

            var data = JSON.parse(data);
            $('#nama_edit').val(data.nama);
            $('#poster_img').attr('src', '{{ url('poster') }}' + '/' + data.poster);
            $('#tanggal_rilis_edit').val(data.tanggal_rilis);
            $('#ubahData').find('form').attr('action', '{{ url('movie') }}' + '/' + data.id);

            $('#ubahData').find('.datepicker').datepicker('setDate', new Date(data.tanggal_rilis));
        }
    </script>
@endsection
