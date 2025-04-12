@extends('layout.body')
@section('title', env('APP_ENV') . ' | ' . $title)
@section('content')
    <!-- [ Main Content ] start -->
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
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 me-3">
                            <p class="mb-1 fw-medium text-muted">Counter Status</p>

                            <h4 class="mb-1">{{ $counter->name }} ({{ $counter->code }}) |
                                @if ($counter->status == 'Open')
                                    <span class="badge bg-light-success">Open</span>
                                @elseif ($counter->status == 'Closed')
                                    <span class="badge bg-light-danger">Closed</span>
                                @elseif ($counter->status == 'Enabled')
                                    <span class="badge bg-light-info">Enabled</span>
                                @elseif ($counter->status == 'Break')
                                    <span class="badge bg-light-warning">Break</span>
                                @elseif ($counter->status == 'Disabled')
                                    <span class="badge bg-light-danger">Disabled</span>
                                @else
                                    <span class="badge bg-light-secondary">Unknown</span>
                                @endif
                            </h4>
                            <p class="mb-0 text-sm">{{ $counter->description }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-l bg-light-primary rounded-circle">
                                <i class="ph-duotone ph-buildings f-28"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-sm-12 col-lg-4">
                    <div class="card statistics-card-1 overflow-hidden ">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/widget/img-status-2.svg') }}" alt="img"
                                class="img-fluid img-bg">
                            <h5 class="mb-4">Queue Completed</h5>
                            <div class="d-flex align-items-center mt-3">
                                <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $queueCompleted }}</h3>
                                <span class="badge bg-light-success ms-2">Service</span>
                            </div>
                            <p class="text-muted mb-2 text-sm mt-3">
                                Total completed queue services
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-lg-4">
                    <div class="card statistics-card-1 overflow-hidden ">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/widget/img-status-2.svg') }}" alt="img"
                                class="img-fluid img-bg">
                            <h5 class="mb-4">Queue Skipped</h5>
                            <div class="d-flex align-items-center mt-3">
                                <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $queueSkipped }}</h3>
                                <span class="badge bg-light-success ms-2">Services</span>
                            </div>
                            <p class="text-muted mb-2 text-sm mt-3">
                                Total skipped queue services
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-lg-4">
                    <div class="card statistics-card-1 overflow-hidden ">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/widget/img-status-2.svg') }}" alt="img"
                                class="img-fluid img-bg">
                            <h5 class="mb-4">Account</h5>
                            <div class="d-flex align-items-center mt-3">
                                <h3 class="f-w-300 d-flex align-items-center m-b-0">20</h3>
                                <span class="badge bg-light-success ms-2">Users</span>
                            </div>
                            <p class="text-muted mb-2 text-sm mt-3">
                                Total account users for queue services
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection
