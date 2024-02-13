@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex">
                    Data Master Merek

                    <a href="{{route('master-merek.create')}}" class="btn btn-success ms-auto">Tambah</a>
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
            $('body').on('click', '#btn-delete', function() {
                let id_data = $(this).data("id");
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Anda tidak akan bisa mengembalikan data!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: `/master-merek/delete/${id_data}`,
                            success: function(data) {
                                var oTable = $('#master-mereks-table');
                                oTable.DataTable().ajax.reload();
                                Swal.fire(
                                    'Deleted!',
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
