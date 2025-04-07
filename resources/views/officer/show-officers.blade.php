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
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-flex flex-row justify-content-between">
                        Officer : {{ $pageTitle }}
                        <a href="{{ route('officers.index') }}" class="fs-5 float-end">Back</a>
                    </h4>
                    <div class="card-body">
                        <div class="row">
                            @php
                                $col = $officer->photo != null ? 'col-lg-9' : 'col-lg-12';
                            @endphp
                            @if ($officer->photo != null)
                                <div class="col-lg-3">
                                    <img class="img-fluid" src="{{ asset('storage/' . $officer->photo) }}" alt="photo">
                                </div>
                            @endif
                            <div class="{{ $col }}">
                                <table class="table">
                                    <tr>
                                        <td>
                                            <strong>NIP</strong> : {{ $officer->nip }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Name</strong> : {{ $officer->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Position</strong> : {{ $officer->position }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Counter Service</strong> :
                                            {{ $officer->counter ? $officer->counter->name : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Block Officer</strong> :
                                            {{ $officer->block }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Timestamp</strong> :
                                            Created At : {{ $officer->created_at }} | Updated At
                                            {{ $officer->updated_at }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
