@extends('layouts.backend')


@section('title', 'Form User')


@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target='#addModalUser'>
                            <span class="fas fa-plus-circle"></span>
                            Tambah Data
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="tableUser" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Roles</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.user.addModalUser')
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            fetchUser()

            function fetchUser() {
                let datatable = $('#tableUser').DataTable({

                    processing: true,
                    info: true,
                    serverSide: true,

                    ajax: {
                        url: "{{ route('user.fetch') }}",
                        type: "get"
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'roles',
                            name: 'roles'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        }
                    ]
                });
            }

        });
    </script>
@endsection
