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
    {{-- Add Modal User --}}
    @include('backend.user.addModalUser')

    {{-- Edit Modal User --}}
    @include('backend.user.editModalUser')
@endsection

@section('js')
    @include('backend.user.scripts')
@endsection
