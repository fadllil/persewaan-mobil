@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Sewa Mobil') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('daftar-mobil.store', $data->id) }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="id_merek" class="col-md-4 col-form-label text-md-end">{{ __('Merek') }}</label>

                            <div class="col-md-6">
                                <select class="form-select select2" id="id_merek" name="id_merek" aria-label="Default select example" readonly>
                                    <option selected value="">Pilih Merek</option>
                                    @foreach($dataMerek as $merek)
                                        <option @if($data->id_merek == $merek->id) selected @endif value="{{$merek->id}}">{{$merek->nama}}</option>
                                    @endforeach
                                </select>

                                @error('id_merek')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="id_model" class="col-md-4 col-form-label text-md-end">{{ __('Model') }}</label>

                            <div class="col-md-6">
                                <select class="form-select select2" id="id_model" name="id_model" aria-label="Default select example" readonly>
                                    <option selected value="">Pilih Model</option>
                                    @foreach($dataModel as $model)
                                        <option @if($data->id_model == $model->id) selected @endif value="{{$model->id}}">{{$model->nama}}</option>
                                    @endforeach
                                </select>

                                @error('id_model')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nama" class="col-md-4 col-form-label text-md-end">{{ __('Nama') }}</label>

                            <div class="col-md-6">
                                <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ $data->nama }}" required autocomplete="nama" autofocus readonly>

                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tahun" class="col-md-4 col-form-label text-md-end">{{ __('Tahun') }}</label>

                            <div class="col-md-6">
                                <input id="tahun" type="year" class="form-control @error('tahun') is-invalid @enderror" name="tahun" value="{{ $data->tahun }}" required autocomplete="tahun" readonly>

                                @error('tahun')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="no_plat" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Plat') }}</label>

                            <div class="col-md-6">
                                <input id="no_plat" type="text" class="form-control @error('no_plat') is-invalid @enderror" name="no_plat" value="{{ $data->no_plat }}" required autocomplete="no_plat" readonly>

                                @error('no_plat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tarif" class="col-md-4 col-form-label text-md-end">{{ __('Tarif / Hari') }}</label>

                            <div class="col-md-6">
                                <input id="tarif" type="text" class="form-control @error('tarif') is-invalid @enderror" name="tarif" value="Rp. {{ number_format($data->tarif, 0, ',', '.') }}" required autocomplete="tarif" readonly>

                                @error('tarif')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tanggal_selesai" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Mulai') }}</label>

                            <div class="col-md-6">
                                <input id="tanggal_selesai" type="datetime-local" class="form-control @error('tanggal_selesai') is-invalid @enderror" name="tanggal_selesai" required autocomplete="tanggal_selesai">

                                @error('tanggal_selesai')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tanggal_mulai" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Selesai') }}</label>

                            <div class="col-md-6">
                                <input id="tanggal_mulai" type="datetime-local" class="form-control @error('tanggal_mulai') is-invalid @enderror" name="tanggal_mulai" required autocomplete="tanggal_mulai">

                                @error('tanggal_mulai')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Simpan') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
 <script>
    /* Fungsi formatRupiah */

    var rupiah_tarif = document.getElementById("tarif");
    rupiah_tarif.addEventListener("keyup", function(e) {
        rupiah_tarif.value = formatRupiah(this.value, "Rp. ");
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
    }
 </script>
@endpush


