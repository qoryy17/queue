@extends('layout.body')
@section('title', env('APP_ENV') . ' | ' . $title)
@section('content')
    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ Main Content ] start -->
            <div class="row flex-column-reverse flex-md-row">
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <livewire:queue />
                </div>
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <livewire:counter />
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection
