    @extends('layouts.app')

    @section('title', 'Laporan Driver')

    @section('main')
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Laporan Driver</h1>
                </div>

                <div class="section-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="distance-filter">Filter Jarak Tempuh</label>
                                <select class="form-control" id="distance-filter">
                                    <option value="all">Semua Jarak</option>
                                    <option value="0-50">0-50 km</option>
                                    <option value="50-100">50-100 km</option>
                                    <option value="100-200">100-200 km</option>
                                    <option value="200+">200+ km</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cost-filter">Filter Total Biaya</label>
                                <select class="form-control" id="cost-filter">
                                    <option value="all">Semua Biaya</option>
                                    <option value="0-500000">Rp 0-500.000</option>
                                    <option value="500000-1000000">Rp 500.000-1.000.000</option>
                                    <option value="1000000-2000000">Rp 1.000.000-2.000.000</option>
                                    <option value="2000000+">Rp 2.000.000+</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Ringkasan Driver</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="summary-item">
                                        <h5>Driver Paling Sering Telat</h5>
                                        <p><strong>{{ $mostLateDriver->name ?? '-' }}</strong></p>
                                        <p>{{ $mostLateDriver ? $mostLateDriver->transactions->sum('late') : 0 }} menit
                                            keterlambatan</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="summary-item">
                                        <h5>Driver Telat ke-2</h5>
                                        <p><strong>{{ $secondMostLateDriver->name ?? '-' }}</strong></p>
                                        <p>{{ $secondMostLateDriver ? $secondMostLateDriver->transactions->sum('late') : 0 }}
                                            menit keterlambatan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="summary-item">
                                        <h5>Driver dengan Biaya Tertinggi ke-2</h5>
                                        <p><strong>{{ $secondHighestCostDriver->name ?? '-' }}</strong></p>
                                        <p>Rp
                                            {{ number_format($secondHighestCostDriver ? $secondHighestCostDriver->transactions->sum('total_cost') : 0) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="summary-item">
                                        <h5>Driver dengan Jarak Tempuh Terjauh</h5>
                                        <p><strong>{{ $mostDistanceDriver->name ?? '-' }}</strong></p>
                                        <p>{{ $mostDistanceDriver ? $mostDistanceDriver->transactions->sum(fn($t) => $t->rute->distance ?? 0) : 0 }}
                                            km</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h4>Jumlah Trip per Driver</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="trip-table">
                                    <thead>
                                        <tr>
                                            <th>Nama Driver</th>
                                            <th>Total Trip</th>
                                            <th>Total Jarak (km)</th>
                                            <th>Total Biaya (Rp)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tripCounts as $trip)
                                            <tr>
                                                <td>{{ $trip['name'] }}</td>
                                                <td>{{ $trip['total_trip'] }}</td>
                                                <td>{{ number_format($trip['distance'] ?? 0) }}</td>
                                                <td>Rp {{ number_format($trip['cost'] ?? 0) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h4>Grafik Jarak dan Biaya</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="driverChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection

    @push('styles')
        <style>
            .summary-item {
                background: #f8f9fa;
                padding: 15px;
                border-radius: 5px;
                height: 100%;
            }

            .summary-item h5 {
                color: #6777ef;
                font-size: 1rem;
                margin-bottom: 10px;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script>
            // Initialize DataTable
            $(document).ready(function() {
                const table = $('#trip-table').DataTable({
                    responsive: true,
                    dom: '<"top"f>rt<"bottom"lip><"clear">'
                });

                // Initialize Chart
                const ctx = document.getElementById('driverChart').getContext('2d');
                const chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($chartData->pluck('name')) !!},
                        datasets: [{
                                label: 'Jarak (km)',
                                data: {!! json_encode($chartData->pluck('distance')) !!},
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                yAxisID: 'y',
                            },
                            {
                                label: 'Total Biaya (Rp)',
                                data: {!! json_encode($chartData->pluck('cost')) !!},
                                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                yAxisID: 'y1',
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Jarak (km)'
                                },
                                ticks: {
                                    beginAtZero: true
                                }
                            },
                            y1: {
                                type: 'linear',
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Total Cost (Rp)'
                                },
                                grid: {
                                    drawOnChartArea: false
                                },
                                ticks: {
                                    callback: function(value) {
                                        if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) +
                                            ' jt';
                                        if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(1) + ' rb';
                                        return 'Rp ' + value;
                                    }
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        if (context.dataset.label === 'Total Biaya (Rp)') {
                                            return context.dataset.label + ': Rp ' + context.raw
                                                .toLocaleString();
                                        }
                                        return context.dataset.label + ': ' + context.raw + ' km';
                                    }
                                }
                            }
                        }
                    }
                });


                // Filter functionality
                $('#distance-filter, #cost-filter').change(function() {
                    const distanceFilter = $('#distance-filter').val();
                    const costFilter = $('#cost-filter').val();

                    // You would typically make an AJAX call here to get filtered data
                    // For now, this just demonstrates the UI
                    console.log('Filters applied:', {
                        distanceFilter,
                        costFilter
                    });

                    // In a real implementation, you would:
                    // 1. Make AJAX request to server with filters
                    // 2. Update the chart and table with new data
                    // 3. Here's a simplified example:
                    /*
                    $.ajax({
                        url: '/driver-reports/filter',
                        data: {
                            distance: distanceFilter,
                            cost: costFilter
                        },
                        success: function(response) {
                            // Update chart data
                            chart.data.labels = response.chartData.labels;
                            chart.data.datasets[0].data = response.chartData.distance;
                            chart.data.datasets[1].data = response.chartData.cost;
                            chart.update();
                            
                            // Update table data
                            table.clear();
                            table.rows.add(response.tableData);
                            table.draw();
                        }
                    });
                    */
                });
            });
        </script>
    @endpush
