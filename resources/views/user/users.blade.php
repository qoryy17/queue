@extends('layout.body')
@section('title', $title)
@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                @foreach ($breadCumbs as $breadItem)
                                    <li class="breadcrumb-item" {{ $breadItem['page'] }}>
                                        <a href="{{ $breadItem['link'] }}">{{ $breadItem['title'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-2 mt-2">{{ $pageTitle }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('users.form', ['param' => 'add', 'id' => Crypt::encrypt('null')]) }}"
                        class="btn btn-primary">
                        <i class="ti ti-user-plus"></i> Add New User
                    </a>
                </div>
                <div class="card-body">

                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Block</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($users as $item)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->role }}</td>
                                        <td>{{ $item->block }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <div class="flex-shrink-0">
                                                <a href="{{ route('users.form', ['param' => 'edit', 'id' => Crypt::encrypt($item->id)]) }}"
                                                    class="avtar avtar-xs btn-light-secondary">
                                                    <i class="ti ti-edit f-20"></i>
                                                </a>
                                                <a href="#" class="avtar avtar-xs btn-light-secondary"
                                                    onclick=" Swal.fire({
                                                    icon: 'warning',
                                                    title: 'Delete Data ?',
                                                    text: 'Deleted data cannot be recovered !',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Delete',
                                                    cancelButtonText: 'Cancel',
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            document.getElementById('deleteForm').submit();
                                                        }
                                                    });">
                                                    <i class="ti ti-trash f-20"></i>
                                                </a>
                                                <form id="deleteForm" action="" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $no++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    <!-- datatable Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/js/plugins/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        // [ Zero Configuration ] start
        $('#simpletable').DataTable();
    </script>
@endsection
