@extends('layout.app')

@section('main')
    <main class="main-wrapper">
    <div class="container-fluid">
        <div class="inner-contents">
            <div class="page-header d-flex align-items-center justify-content-between mr-bottom-30">
                <div class="left-part">
                    <h2 class="text-dark">Dashboard</h2>
                </div>
                <div class="right-part">
                    <h4 class="text-dark">Welcome Again!</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-6 col-lg-12">
                    <div class="row">
                        <div class="col col-12">
                            <div class="card border-0 shadow-sm py-3">
                                <div class="card-body py-2">
                                    <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                                        <div class="d-flex align-items-center gap-0 flex-wrap">
                                            <div> 
                                                <h4 class="mb-3">Total Chats</h4>
                                                <h2 class="fs-38 mb-0">{{ $totalChats }}</h2> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col col-lg-6">
                            <div class="card border-0 shadow-sm pd-top-40 pd-bottom-40">
                                <div class="card-body py-0">
                                    <h4 class="mb-3">Total Event</h4>
                                    <h2 class="fs-38 d-flex align-items-center gap-4"> {{ $totalEvents }}</h2>
                                </div>
                            </div>
                        </div>

                        <div class="col col-lg-6">
                            <div class="card border-0 shadow-sm pd-top-40 pd-bottom-40">
                                <div class="card-body py-0">
                                    <h4 class="mb-3">Total Table</h4>
                                    <h2 class="fs-38 d-flex align-items-center gap-4"> {{ $totalTables }}</h2>
                                </div>
                            </div>
                        </div>

                        <div class="col col-lg-6">
                            <div class="card border-0 shadow-sm p-5">
                                <div class="card-body p-0 d-flex align-items-center justify-content-between gap-5 flex-wrap flex-xl-nowrap">
                                    <div class="flex-shrink-0">
                                        <h4 class="mb-3">Total Song Requests</h4>
                                        <h2 class="fs-38 d-flex align-items-center gap-4"> {{ $totalSongs }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col col-lg-6">
                            <div class="card border-0 shadow-sm p-5">
                                <div class="card-body p-0 d-flex align-items-center justify-content-between gap-5 flex-wrap flex-xl-nowrap">
                                    <div class="flex-shrink-0">
                                        <h4 class="mb-3">Total Administrators</h4>
                                        <h2 class="fs-38 d-flex align-items-center gap-4"> {{ $totalAdmins }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xxl-6 col-lg-12">
                    <div class="card pie-card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-0 p-5 pb-0 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                            <h4 class="mb-0">Event Analytics</h4>
                            <div class="btn-group flex-shrink-0">
                                <a href="{{ route('all-event') }}" class="btn bg-soft-success btn-outline-success"> See More on Page</a>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            <div class="d-flex align-items-center justify-content-around justify-content-xxl-between gap-3 flex-wrap">
                                <div>
                                    <div id="chart-ongoing"></div> 
                                    <h5 class="fw-semibold text-center mb-0 negative-margin">Ongoing Events</h5>
                                </div>
                                <div>
                                    <div id="chart-upcoming"></div> 
                                    <h5 class="fw-semibold text-center mb-0 negative-margin">Upcoming Events</h5>
                                </div>
                                <div>
                                    <div id="chart-completed"></div> 
                                    <h5 class="fw-semibold text-center mb-0 negative-margin">Completed Events</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
@endsection

@push('page_script')
    <!-- ApexChart -->
    <script src="{{ asset('templates/plugins/apexchart/apexcharts.min.js') }}"></script>
@endpush

@push('custom_script')
    <script>
        // Ongoing Events Chart
        var optionsOngoing = {
            series: [{{ $ongoingEvents }}],
            chart: {
                width: 170,
                height: 280,
                type: "radialBar",
            },
            colors: ["#008FFB"],

            plotOptions: {
                radialBar: {
                    hollow: {
                        size: "30%",
                        margin: 5,
                        background: "transparent",
                    },
                    track: {
                        background: "#F6EEFF",
                    },
                    dataLabels: {
                        name: {
                            show: false,
                        },
                        value: {
                            show: true,   
                            offsetY: 5,
                            fontFamily: "'Cairo' Sans-serif",
                            fontSize: "20px",
                            fontWeight: 700,
                        },
                        total: {
                            show: true,   // Show total value
                            label: 'Total',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0); // Total sum
                            }
                        }
                    },
                },
            },

            labels: [""],
            responsive: [
                {
                    breakpoint: 767,
                    options: {
                        legend: {
                            position: "bottom",
                            horizontalAlign: "center",
                        },
                    },
                },
            ],
        };

        var chartOngoing = new ApexCharts(document.querySelector("#chart-ongoing"), optionsOngoing);
        chartOngoing.render();

        // Upcoming Events Chart
        var optionsUpcoming = {
            series: [{{ $upcomingEvents }}],
            chart: {
                width: 170,
                height: 280,
                type: "radialBar",
            },
            colors: ["#00E396"],

            plotOptions: {
                radialBar: {
                    hollow: {
                        size: "30%",
                        margin: 5,
                        background: "transparent",
                    },
                    track: {
                        background: "#F6EEFF",
                    },
                    dataLabels: {
                        name: {
                            show: false,
                        },
                        value: {
                            show: true,   
                            offsetY: 5,
                            fontFamily: "'Cairo' Sans-serif",
                            fontSize: "20px",
                            fontWeight: 700,
                        },
                        total: {
                            show: true,   // Show total value
                            label: 'Total',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0); // Total sum
                            }
                        }
                    },
                },
            },

            labels: [""],
            responsive: [
                {
                    breakpoint: 767,
                    options: {
                        legend: {
                            position: "bottom",
                            horizontalAlign: "center",
                        },
                    },
                },
            ],
        };

        var chartUpcoming = new ApexCharts(document.querySelector("#chart-upcoming"), optionsUpcoming);
        chartUpcoming.render();

        // Completed Events Chart
        var optionsCompleted = {
            series: [{{ $completedEvents }}],
            chart: {
                width: 170,
                height: 280,
                type: "radialBar",
            },
            colors: ["#FEB019"],

            plotOptions: {
                radialBar: {
                    hollow: {
                        size: "30%",
                        margin: 5,
                        background: "transparent",
                    },
                    track: {
                        background: "#F6EEFF",
                    },
                    dataLabels: {
                        name: {
                            show: false,
                        },
                        value: {
                            show: true,   
                            offsetY: 5,
                            fontFamily: "'Cairo' Sans-serif",
                            fontSize: "20px",
                            fontWeight: 700,
                        },
                        total: {
                            show: true,   // Show total value
                            label: 'Total',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0); // Total sum
                            }
                        }
                    },
                },
            },

            labels: [""],
            responsive: [
                {
                    breakpoint: 767,
                    options: {
                        legend: {
                            position: "bottom",
                            horizontalAlign: "center",
                        },
                    },
                },
            ],
        };

        var chartCompleted = new ApexCharts(document.querySelector("#chart-completed"), optionsCompleted);
        chartCompleted.render();
    </script>
@endpush