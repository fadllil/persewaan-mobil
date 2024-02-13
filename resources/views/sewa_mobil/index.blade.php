@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex">
                    Data Sewa Mobil
                </div>

                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script type="module">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $( document ).ready(function() {
            $('body').on('click', '#btn-pengembalian', function() {
                let id_data = $(this).data("id");
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Anda akan mengembalikan mobil!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: `/sewa-mobil/pengembalian/${id_data}`,
                            success: function(data) {
                                var oTable = $('#sewa-mobils-table');
                                oTable.DataTable().ajax.reload();
                                Swal.fire(
                                    'Success!',
                                    data.message,
                                    'success'
                                )
                            },
                            error: function(data) {
                                console.log('Error:', data);
                                Swal.fire(
                                    'Error',
                                    data.message,
                                    'error'
                                );
                            }
                        });

                    }
                });
            });
        });
    </script>
@endpush
