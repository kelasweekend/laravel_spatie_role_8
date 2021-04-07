@extends('layouts.dashboard.master')
@section('title')
    Users Management
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- breadcumb -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 float-right">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">Management Pengguna</h2>
                                    @can('user-create')
                                        <button type="button"
                                            class="btn btn-outline-primary btn-sm waves-effect waves-light float-right"
                                            id="createNewItem">Create USers</button>
                                    @endcan
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Permissions Account</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Permissions Account</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- /.content-header -->
    </div>
    @can('user-create')
        <div class="modal fade" id="ajaxModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modelHeading"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="ItemForm" name="ItemForm" class="form-horizontal">
                            <input type="hidden" name="Item_id" id="Item_id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Nama Lengkap</label>
                                            {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Masukan Email</label>
                                            {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Masukan Password</label>
                                            {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Ulangi Password</label>
                                            {!! Form::password('confirm-password', ['placeholder' => 'Confirm Password', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Status Coupon</label>
                                    {!! Form::select('roles[]', $roles, [], ['class' => 'form-control', 'multiple']) !!}
                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-10">
                                <button class="btn btn-primary tombol" id="saveBtn" value="create"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection


@section('css-tambahan')
    <link rel="stylesheet" href="{{ asset('cdn/datatables/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cdn/datatables/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cdn/datatables/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('js-tambahan')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('cdn/datatables/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                pageLength: 5,
                lengthMenu: [5, 10, 20, 50, 100, 200, 500],
                esponsive: true,
                lengthChange: false,
                autoWidth: false,
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
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'akses',
                        name: 'akses'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#createNewItem').click(function() {
                $('#saveBtn').val("create-Item");
                $('#Item_id').val('');
                $('#ItemForm').trigger("reset");
                $('#modelHeading').html("Create User");
                $('.tombol').html("Submit");
                $('#ajaxModel').modal('show');
            });

            @can('user-create')
                $('body').on('click', '.editItem', function() {
                var Item_id = $(this).data('id');
                $('.tombol').html("Save Change");
                $.get("{{ url('dashboard/users') }}" + '/' + Item_id + '/edit', function(data) {
                $('#modelHeading').html("Edit Item");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#Item_id').val(data.id);
                $('input[name=name]').val(data.name);
                $('input[name=email]').val(data.email);
                })
                });
            
                $('#saveBtn').click(function(e) {
                e.preventDefault();
                $.ajax({
                data: $('#ItemForm').serialize(),
                url: "{{ route('users.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(response) {
                if (response.success) {
                Swal.fire({
                icon: "success",
                title: "Selamat",
                text: response.success
                });
                $('#ItemForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                table.draw();
                } else {
                Swal.fire({
                icon: "error",
                title: "Mohon Maaf !",
                text: response.error
                });
                }
                },
                error: function() {
                Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!"
                });
                }
                });
                });
            @endcan

            @can('user-delete')
                $('body').on('click', '.deleteItem', function() {
            
                var Item_id = $(this).data("id");
                var url = $(this).data("url");
                Swal.fire({
                title: 'Apakah Anda Yakin ?',
                text: "Anda Akan Menghapus Pengguna Ini !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                type: "DELETE",
                url: url,
                success: function(response) {
                if (response.success) {
                Swal.fire({
                icon: "success",
                title: "Selamat",
                text: response.success
                });
                $('#ItemForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                table.draw();
                } else {
                Swal.fire({
                icon: "error",
                title: "Mohon Maaf !",
                text: response.error
                });
                }
                },
                error: function() {
                Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!"
                });
                }
                });
                }
                })
                });
            @endcan
        });

    </script>
@endsection
