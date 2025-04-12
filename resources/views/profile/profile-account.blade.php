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
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- [ sample-page ] start -->
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-lg-5 col-xxl-3">
                            <div class="card overflow-hidden">
                                <div class="card-body position-relative">
                                    <div class="text-center mt-3">
                                        <div class="chat-avtar d-inline-flex mx-auto">
                                            <img class="rounded-circle img-fluid wid-90 img-thumbnail"
                                                src="{{ $profile->photo != null ? asset('storage/' . $profile->officer->photo) : asset('assets/images/user/avatar-1.jpg') }}"
                                                alt="User image">
                                            <i class="chat-badge bg-success me-2 mb-2"></i>
                                        </div>
                                        <h5 class="mb-0">{{ $profile->name ?? '' }}</h5>
                                        <p class="text-muted text-sm">
                                            {{ $profile->email ?? '' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="nav flex-column nav-pills list-group list-group-flush account-pills mb-0"
                                    id="user-set-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link list-group-item list-group-item-action active"
                                        id="user-set-profile-tab" data-bs-toggle="pill" href="#user-set-profile"
                                        role="tab" aria-controls="user-set-profile" aria-selected="true">
                                        <span class="f-w-500"><i class="ph-duotone ph-user-circle m-r-10"></i>
                                            My Profile
                                        </span>
                                    </a>
                                    <a class="nav-link list-group-item list-group-item-action" id="user-set-account-tab"
                                        data-bs-toggle="pill" href="#user-set-account" role="tab"
                                        aria-controls="user-set-account" aria-selected="false">
                                        <span class="f-w-500"><i class="ph-duotone ph-notebook m-r-10"></i>
                                            Edit Profile
                                        </span>
                                    </a>
                                    <a class="nav-link list-group-item list-group-item-action" id="user-set-passwort-tab"
                                        data-bs-toggle="pill" href="#user-set-passwort" role="tab"
                                        aria-controls="user-set-passwort" aria-selected="false">
                                        <span class="f-w-500"><i class="ph-duotone ph-key m-r-10"></i>
                                            Change Password
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-xxl-9">
                            <div class="tab-content" id="user-set-tabContent">
                                <div class="tab-pane fade show active" id="user-set-profile" role="tabpanel"
                                    aria-labelledby="user-set-profile-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Your Account</h5>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item px-0 pt-0">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="mb-1 text-muted">Nama</p>
                                                            <p class="mb-0">
                                                                <b>{{ $profile->name ?? '' }}</b>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1 text-muted">NIP</p>
                                                            <p class="mb-0">
                                                                <b>{{ $profile->officer->nip ?? '' }}</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item px-0">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="mb-1 text-muted">Email</p>
                                                            <p class="mb-0">{{ $profile->email ?? '' }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1 text-muted">Join Date</p>
                                                            <p class="mb-0">
                                                                <b>{{ \Carbon\Carbon::parse($profile->officer->created_at)->format('d F Y') ?? '' }}</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item px-0">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="mb-1 text-muted">Position</p>
                                                            <p class="mb-0">
                                                                <b>{{ $profile->officer->position ?? '' }}</b>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1 text-muted">Counter Service</p>
                                                            <p class="mb-0">
                                                                <b>{{ $counter->name ?? '' }}</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="user-set-account" role="tabpanel"
                                    aria-labelledby="user-set-account-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Change Profile</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('profile.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('POST')
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item px-0 pt-0">
                                                        <div class="row mb-0">
                                                            <label for="email"
                                                                class="col-form-label col-md-3 col-sm-12">
                                                                Email
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-md-9 col-sm-12">
                                                                <input type="email" class="form-control" name="email"
                                                                    id="email"
                                                                    value="{{ $profile->email ?? old('email') }}"
                                                                    placeholder="Email...">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item px-0">
                                                        <div class="row mb-0">
                                                            <label for="nip"
                                                                class="col-form-label col-md-3 col-sm-12">
                                                                NIP
                                                            </label>
                                                            <div class="col-md-9 col-sm-12">
                                                                <input type="text" class="form-control" name="nip"
                                                                    id="nip"
                                                                    value="{{ $profile->officer->nip ?? '' }}"
                                                                    placeholder="NIP...">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item px-0">
                                                        <div class="row mb-0">
                                                            <label for="name"
                                                                class="col-form-label col-md-3 col-sm-12">
                                                                Name
                                                                <span class="text-danger">*</span></label>
                                                            <div class="col-md-9 col-sm-12">
                                                                <input type="text" class="form-control" name="name"
                                                                    id="name" required
                                                                    value="{{ $profile->officer->name ?? '' }}"
                                                                    placeholder="Name...">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item px-0">
                                                        <div class="row mb-0">
                                                            <label for="photo"
                                                                class="col-form-label col-md-3 col-sm-12 ">
                                                                Photo
                                                                <span class="text-danger">*</span></label>
                                                            <div class="col-md-9 col-sm-12">
                                                                <div class="form-file mb-3">
                                                                    <input type="file" class="form-control"
                                                                        aria-label="photo" id="photo" name="photo">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item px-0">
                                                        <button type="submit" class="btn btn-primary"
                                                            style="float: right;">Save</button>
                                                    </li>
                                                </ul>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="user-set-passwort" role="tabpanel"
                                    aria-labelledby="user-set-passwort-tab">
                                    <div class="card alert alert-warning p-0">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 me-3">
                                                    <h4 class="alert-heading">Perhatian !</h4>
                                                    <p class="mb-2" style="text-align: justify;">
                                                        Change your account password regularly, to increase the security of
                                                        your account.
                                                    </p>
                                                    <a href="#" class="alert-link" style="text-align: justify;">
                                                        Do not give access to your account to anyone, to avoid abuse of
                                                        authority and resources on the system of this application!
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('password.store') }}" method="POST">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Change Password</h5>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item px-0">
                                                        <div class="row mb-0">
                                                            <label for="password"
                                                                class="col-form-label col-md-3 col-sm-12">
                                                                New Password <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-md-9 col-sm-12">
                                                                @csrf
                                                                @method('POST')
                                                                <input type="password" class="form-control"
                                                                    name="password" id="password" required
                                                                    placeholder="******">
                                                                @error('password')
                                                                    <small class="text-danger mt-1">*
                                                                        {{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item px-0">
                                                        <button type="submit" class="btn btn-primary"
                                                            style="float: right;">Save
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ sample-page ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
