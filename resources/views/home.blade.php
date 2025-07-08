@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/chart.js/dist/Chart.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Driver</h4>
                            </div>
                            <div class="card-body">
                                {{ $stats['total_drivers'] }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-route"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Trip</h4>
                            </div>
                            <div class="card-body">
                                {{ $stats['total_trips'] }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-road"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Jarak</h4>
                            </div>
                            <div class="card-body">
                                {{ number_format($stats['total_distance']) }} km
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Biaya</h4>
                            </div>
                            <div class="card-body">
                                Rp {{ number_format($stats['total_cost'], 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik Driver</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="driverChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Driver Terbaik</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6>Jarak Terjauh</h6>
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-primary text-white mr-3">
                                        {{ substr($mostDistanceDriver->name ?? '-', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold">{{ $mostDistanceDriver->name ?? '-' }}</div>
                                        <div class="text-small">
                                            {{ number_format($mostDistanceDriver->total_distance ?? 0) }} km</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <h6>Biaya Tertinggi</h6>
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-danger text-white mr-3">
                                        {{ substr($highestCostDriver->name ?? '-', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold">{{ $highestCostDriver->name ?? '-' }}</div>
                                        <div class="text-small">Rp
                                            {{ number_format($highestCostDriver->total_cost ?? 0, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h6>Paling Sering Telat</h6>
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-warning text-white mr-3">
                                        {{ substr($mostLateDriver->name ?? '-', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold">{{ $mostLateDriver->name ?? '-' }}</div>
                                        <div class="text-small">{{ $mostLateDriver->total_late ?? 0 }} menit</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Driver</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Driver</th>
                                            <th>Total Trip</th>
                                            <th>Total Jarak (km)</th>
                                            <th>Total Biaya</th>
                                            <th>Keterlambatan (menit)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tripCounts as $driver)
                                            <tr>
                                                <td>{{ $driver['name'] }}</td>
                                                <td>{{ $driver['total_trip'] }}</td>
                                                <td> {{ number_format($driver['total_distance'], 0, ',', '.') }} KM</td>
                                                <td>Rp {{ number_format($driver['total_cost'], 0, ',', '.') }}</td>
                                                <td>{{ $driver['total_late'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script>
        // Driver Chart
        const driverCtx = document.getElementById('driverChart').getContext('2d');
        const driverChart = new Chart(driverCtx, {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                        label: 'Jarak Tempuh (km)',
                        data: @json($chartData['distance']),
                        backgroundColor: '#6777ef',
                        borderColor: '#6777ef',
                        borderWidth: 1
                    },
                    {
                        label: 'Biaya (Rp)',
                        data: @json($chartData['cost']),
                        backgroundColor: '#fc544b',
                        borderColor: '#fc544b',
                        borderWidth: 1
                    },
                    {
                        label: 'Jumlah Trip',
                        data: @json($chartData['trips']),
                        backgroundColor: '#ffa426',
                        borderColor: '#ffa426',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            let label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (tooltipItem.datasetIndex === 1) { // Biaya
                                label += 'Rp ' + tooltipItem.yLabel.toLocaleString();
                            } else {
                                label += tooltipItem.yLabel;
                            }
                            return label;
                        }
                    }
                }
            }
        });
    </script>
@endpush
