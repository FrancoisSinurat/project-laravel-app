<style>
        #chart-container {
            width: 100%;
            margin: auto;
            padding: 20px;
        }
</style>
<x-layout>
    @section('title', 'Dashboard')
    <section class="section dashboard">
        <div class="row">
            <!-- Card -->
            @foreach ($cards as $card)
            <div class="col-xxl-3 col-md-3">
                <div class="card info-card {{ $card->category_color }}">

                    {{-- <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>

                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div> --}}

                    <div class="card-body">
                        <h5 class="card-title"><span>Aset |</span> {{ $card->category_name }}</h5>

                        <div class="d-flex align-items-center">
                            <div
                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-{{ $card->category_icon }}"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $card->count }}</h6>
                                <span class="{{ $card->category_text }} small pt-1 fw-bold">Total</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div> <!-- End Card -->
        <div class="row"> <!-- Pie Chart -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><span>Aset |</span> Total</h5> 
                        <div id="chart-container">
                        <canvas id="pieChart"></canvas>
                        </div>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                const chartLabel = @json($chartLabel);
                                const chartData = @json($chartData);
                                const chartColor = @json($chartColor);
                                const chartBgColors = chartColor.map(color => {
                                    return color.replace(')', ', 0.2)').replace('rgb', 'rgba');
                                });

                                new Chart(document.querySelector('#pieChart'), {
                                    type: 'pie',
                                    data: {
                                        labels: chartLabel,
                                        datasets: [{
                                            data: chartData,
                                            backgroundColor: chartBgColors,
                                            borderColor: chartColor,
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false, // Ensures the chart does not maintain aspect ratio                                        plugins: {
                                        plugins: {
                                            legend: {
                                                position: 'left',
                                                labels: {
                                                    boxWidth: 20
                                                }
                                            },
                                            tooltip: {
                                                enabled: true
                                            },
                                        },
                                        // layout: {
                                        //     padding: {
                                        //         top: 20, // Adjust this value to move legend up
                                        //     }
                                        // },
                                        // onResize: (chart, size) => {
                                        //     if (size.width < 500) {
                                        //         chart.options.plugins.legend.position = 'bottom'; // Move legend to the bottom on small screens
                                        //         chart.options.layout.padding.top = 0; // Adjust padding on small screens
                                        //     } else {
                                        //         chart.options.plugins.legend.position = 'left'; // Restore legend position on larger screens
                                        //         chart.options.layout.padding.top = -200; // Restore padding on larger screens
                                        //     }
                                        // }
                                    }
                                });
                            });
                        </script>
                        
                    </div>
                </div>
            </div>
        </div> <!-- End Pie Chart -->
        {{-- <div class="row"> <!-- Bar Chart -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><span>Aset |</span> Total</h5>
                        <canvas id="barChart" style="max-height: 400px;"></canvas>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                            new Chart(document.querySelector('#barChart'), {
                                type: 'bar',
                                data: {
                                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                datasets: [{
                                    label: 'Perangkat IT',
                                    data: [65, 59, 80, 81, 56, 55, 40],
                                    backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(255, 159, 64, 0.2)',
                                    'rgba(255, 205, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(201, 203, 207, 0.2)'
                                    ],
                                    borderColor: [
                                    'rgb(255, 99, 132)',
                                    'rgb(255, 159, 64)',
                                    'rgb(255, 205, 86)',
                                    'rgb(75, 192, 192)',
                                    'rgb(54, 162, 235)',
                                    'rgb(153, 102, 255)',
                                    'rgb(201, 203, 207)'
                                    ],
                                    borderWidth: 1
                                }]
                                },
                                options: {
                                scales: {
                                    y: {
                                    beginAtZero: true
                                    }
                                }
                                }
                            });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div> <!-- End Bar CHart --> --}}
    </section>
</x-layout>
