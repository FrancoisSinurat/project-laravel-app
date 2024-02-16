<x-layout>
    @section('title', 'Dashboard')
    <section class="section dashboard">
        <div class="row">

            <!-- Perangkat IT Card -->
            <div class="col-xxl-3 col-md-3">

                <div class="card info-card red-card">

                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>

                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title"><span>Aset |</span> Perangkat IT</h5>

                        <div class="d-flex align-items-center">
                            <div
                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-pc-display"></i>
                            </div>
                            <div class="ps-3">
                                <h6>0</h6>
                                <span class="text-danger small pt-1 fw-bold">Total</span>

                            </div>
                        </div>

                    </div>
                </div>

            </div><!-- End Perangkat IT Card -->

            <!-- Kendaraan Card -->
            <div class="col-xxl-3 col-md-3">
                <div class="card info-card blue-card">

                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>

                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title"><span>Aset |</span> Kendaraan</h5>

                        <div class="d-flex align-items-center">
                            <div
                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-car-front"></i>
                            </div>
                            <div class="ps-3">
                                <h6>0</h6>
                                <span class="text-primary small pt-1 fw-bold">Total</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- End Kendaraan Card -->

            <!-- Furnitur Card -->
            <div class="col-xxl-3 col-md-3">
                <div class="card info-card green-card">

                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>

                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title"><span>Aset |</span> Furnitur</h5>

                        <div class="d-flex align-items-center">
                            <div
                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-lamp"></i>
                            </div>
                            <div class="ps-3">
                                <h6>0</h6>
                                <span class="text-success small pt-1 fw-bold">Total</span>

                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- End Furnitur Card -->

            <!-- Tak Berwujud Card -->
            <div class="col-xxl-3 col-md-3">
                <div class="card info-card yellow-card">

                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>

                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title"><span>Aset |</span> Tak Berwujud</h5>

                        <div class="d-flex align-items-center">
                            <div
                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-c-circle"></i>
                            </div>
                            <div class="ps-3">
                                <h6>0</h6>
                                <span class="text-warning small pt-1 fw-bold">Total</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- End Tak Berwujud Card -->

            <!-- Perangkat IT Chart -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><span>Aset |</span> Perangkat IT</h5>

                        <!-- Bar Chart -->
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
                        <!-- End Bar CHart -->

                    </div>
                </div>
            </div><!-- End Perangkat IT CHart -->

            <!-- Kendaraan Chart -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><span>Aset |</span> Kendaraan</h5>

                        <!-- Bar Chart -->
                        <canvas id="barChart1" style="max-height: 400px;"></canvas>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                            new Chart(document.querySelector('#barChart1'), {
                                type: 'bar',
                                data: {
                                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                datasets: [{
                                    label: 'Kendaraan',
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
                        <!-- End Bar Chart -->

                    </div>
                </div>
            </div><!-- End Kendaraan Chart -->

            <!-- Furnitur Chart -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><span>Aset |</span> Furnitur</h5>

                        <!-- Bar Chart -->
                        <canvas id="barChart2" style="max-height: 400px;"></canvas>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                            new Chart(document.querySelector('#barChart2'), {
                                type: 'bar',
                                data: {
                                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                datasets: [{
                                    label: 'Furnitur',
                                    data: [59, 65, 80, 81, 56, 55, 40],
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
                        <!-- End Bar Chart -->

                    </div>
                </div>
            </div><!-- End Furnitur Chart -->

            <!-- Tak Berwujud Chart -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><span>Aset |</span> Tak Berwujud</h5>

                        <!-- Bar Chart -->
                        <canvas id="barChart4" style="max-height: 400px;"></canvas>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                            new Chart(document.querySelector('#barChart4'), {
                                type: 'bar',
                                data: {
                                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                datasets: [{
                                    label: 'Tak Berwujud',
                                    data: [59, 65, 80, 81, 56, 55, 40],
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
                        <!-- End Bar Chart -->

                    </div>
                </div>
            </div><!-- End Tak Berwujud Chart -->

        </div>
    </section>
</x-layout>
