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
            <div class="row">
                <div class="col-md-4 col-sm-12 col-lg-4">
                    <div class="card statistics-card-1 overflow-hidden ">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/widget/img-status-2.svg') }}" alt="img"
                                class="img-fluid img-bg">
                            <h5 class="mb-4">Queue Counter</h5>
                            <div class="d-flex align-items-center mt-3">
                                <h3 class="f-w-300 d-flex align-items-center m-b-0">2938</h3>
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
                            <h5 class="mb-4">Counter Service</h5>
                            <div class="d-flex align-items-center mt-3">
                                <h3 class="f-w-300 d-flex align-items-center m-b-0">2938</h3>
                                <span class="badge bg-light-success ms-2">Counter</span>
                            </div>
                            <p class="text-muted mb-2 text-sm mt-3">
                                Total Counter for queue services
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

            <!-- Chart -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Queue Graph</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-1">
                        <h3 class="mb-0">230 <small class="text-muted">/1290</small></h3>
                        <span class="badge bg-light-success ms-2">2025</span>
                    </div>
                    <p>Queue Statistic</p>
                    <div id="income-graph"></div>
                </div>
            </div>
            <!-- End Chart -->
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Apex Chart -->
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script>
        'use strict';
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                floatchart();
            }, 500);
        });

        function floatchart() {
            (function() {
                var options = {
                    chart: {
                        type: 'area',
                        height: 230,
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#008080'],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            type: 'vertical',
                            inverseColors: false,
                            opacityFrom: 0.5,
                            opacityTo: 0
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 1
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '45%',
                            borderRadius: 4
                        }
                    },
                    grid: {
                        strokeDashArray: 4
                    },
                    series: [{
                        data: [30, 60, 40, 70, 50, 90, 50, 55, 45, 60, 50, 65]
                    }],
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                            'Dec'
                        ],
                        labels: {
                            hideOverlappingLabels: true,
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    }
                };
                var chart = new ApexCharts(document.querySelector('#income-graph'), options);
                chart.render();
            })();
        }
    </script>
    <script src="https://code.responsivevoice.org/responsivevoice.js?key={{ Crypt::decrypt($voice->api_key) }}"></script>
    <script>
        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });

        pusher.connection.bind('connected', function() {
            console.log('Pusher connected successfully.');
        });

        pusher.connection.bind('disconnected', function() {
            console.log('Pusher disconnected.');
        });

        pusher.connection.bind('error', function(err) {
            console.error('Pusher connection error:', err);
        });

        var channel = pusher.subscribe('queue-channel');
        channel.bind('QueueEvent', function(data) {
            if (responsiveVoice.voiceSupport()) {
                responsiveVoice.speak("Nomor Antrian. 120. Silahkan Menuju Ke Meja Pidana, Terimakasih",
                    "Indonesian Female", {
                        volume: 10,
                    });
            } else {
                console.log("ResponsiveVoice is not supported in this browser.");
            }

        });
    </script>
@endsection
