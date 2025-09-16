<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>
<?= $this->include('templates/topbar') ?>


<?php

$monthlyReportsJson = json_encode($monthlyReports);

?>
<style>
    #categoryProgressBarContainer {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .widget-progress-wrapper {
        width: 100%;
    }

    .progress {
        border-radius: 5px;
    }

    .text-muted.opacity-6 {
        margin-top: 5px;
        text-align: center;
        font-size: 0.8em;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<div class="container-fluid">
    <div class="app-main__inner">

        <div class="row">
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-midnight-bloom">
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-left">
                            <div class="widget-heading">Total Laporan Yang Sedang Dalam Proses</div>
                            <div class="widget-subheading">In Progress</div>
                        </div>
                        <div class="widget-content-right">
                            <?php if (empty($inProgressCount)): ?>
                                <div class="widget-heading">Tidak ada laporan yang sedang dalam proses.</div>
                            <?php else: ?>
                                <div class="widget-numbers text-white">
                                    <span><?= $inProgressCount; ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-grow-early ">
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-left">
                            <div class="widget-heading">Total Laporan Yang Selesai</div>
                            <div class="widget-subheading">Done</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers text-white"><span>
                                    <?php
                                    if (empty($inDoneCount)) {
                                        echo "Tidak ada laporan yang sedang dalam proses.";
                                    } else {
                                        echo $inDoneCount;
                                    }
                                    ?>
                                </span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-arielle-smile">
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-left">
                            <div class="widget-heading">Total Semua Laporan</div>
                            <div class="widget-subheading">All Reports</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers text-white"><span>
                                    <?php
                                    if (empty($allReportsCount)) {
                                        echo "Tidak ada laporan yang sedang dalam proses.";
                                    } else {
                                        echo $allReportsCount;
                                    }
                                    ?>
                                </span></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="mb-3 card">
                    <div class="card-header-tab card-header-tab-animation card-header">
                        <div class="card-header-title">
                            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                            Grafik Pengaduan Tahunan
                        </div>
                        <ul class="nav">
                            <li class="nav-item mt-2 mr-2">
                                <div class="form-group">
                                    <select class="form-control" id="chartTypeSelector">
                                        <option value="bar">Bar Chart</option>
                                        <option value="line">Line Chart</option>
                                    </select>
                                </div>
                            </li>
                            <li class="nav-item mt-2">
                                <form action="<?= base_url('PostController/index') ?>" method="post">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <select class="form-control" name="selected_year" id="yearFilter">
                                                <?php for ($year = 2025; $year <= 2030; $year++): ?>
                                                    <option value="<?= $year ?>">
                                                        <?= $year ?>
                                                    </option>
                                                <?php endfor; ?>


                                            </select>

                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tabs-eg-77">
                                <div class="card mb-3 widget-chart widget-chart2 text-left w-100">
                                    <div class="widget-chat-wrapper-outer">

                                        <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                                            <canvas id="barChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-muted text-uppercase font-size-md opacity-5 font-weight-normal">
                                    Tabel Detail</h6>
                                <div class="scroll-area-sm">
                                    <div class="scrollbar-container">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Bulan</th>
                                                    <th class="text-center">Total Laporan</th>
                                                    <th class="text-center">Barang Terbanyak</th>
                                                    <th class="text-center">Jumlah </th>
                                                </tr>
                                            </thead>
                                            <tbody id="detailTableBody">
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title">
                            <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                            Grafik Aset Rusak Per Tahun
                        </div>
                        <div class="btn-actions-pane-right">
                            <ul class="nav">
                                <li class="nav-item mt-2 mr-2">
                                    <form action="<?= base_url('PostController/index') ?>" method="post">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <select class="form-control" name="selected_year" id="yearFilterAssets">
                                                    <?php for ($year = 2025; $year <= 2030; $year++): ?>
                                                        <option value="<?= $year ?>">
                                                            <?= $year ?>
                                                        </option>
                                                    <?php endfor; ?>


                                                </select>

                                            </div>
                                        </div>

                                    </form>
                                </li>
                                <li class="nav-item mt-2 mr-2">
                                    <div class="form-group">
                                        <select class="form-control" id="chartTypeSelectorAssets">
                                            <option value="Dougnut">Doughnut Chart</option>
                                            <option value="Pie">Pie Chart</option>
                                            <option value="Half">Half Doughnut Chart</option>
                                        </select>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-eg-55">
                            <div class="widget-chart p-3">
                                <div style="height: 350px">
                                    <canvas id="pieChart-Assets"></canvas>

                                </div>
                                <div class="widget-chart-content text-center mt-5">
                                    <div class="widget-description mt-0 text-warning">
                                        <span class="pl-1"></span>
                                        <span class="text-muted opacity-8 pl-1">Statistik Aset Rusak Per Tahun Di Badan
                                            Pusat Statistik Ogan Ilir</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-2 card-body">
                                <h6 class="text-muted text-uppercase font-size-md opacity-5 font-weight-normal">
                                    Tabel Detail</h6>
                                <div class="scroll-area-sm">
                                    <div class="scrollbar-container">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Barang</th>
                                                    <th class="text-center">Total</th>
                                                    <th class="text-center">Persentase</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detailTableBodyAssets">
                                            </tbody>
                                        </table>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 offset-lg-3">
                <div class="mb-3 card justify-content-center">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title">
                            <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                            Grafik Aset Rusak Keseluruhan
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-eg-55">
                            <div class="widget-chart p-3">
                                <div style="height: 350px">
                                    <canvas id="pieChart-AllAssets"></canvas>
                                </div>
                                <div class="widget-chart-content text-center mt-5">
                                    <div class="widget-description mt-0 text-warning">
                                        <span class="text-muted opacity-8">Statistik Aset Rusak Di Badan Pusat
                                            Statistik Ogan Ilir</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-2 card-body">
                                <h6 class="text-muted text-uppercase font-size-md opacity-5 font-weight-normal">
                                    Tabel Detail</h6>
                                <div class="scroll-area-sm">
                                    <div class="scrollbar-container">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Barang</th>
                                                    <th class="text-center">Rusak Berat</th>
                                                    <th class="text-center">Rusak Ringan</th>
                                                    <th class="text-center">Total</th>
                                                    <th class="text-center">Persentase</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detailTableBodyAllAssets">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>



    <script>

        function getLaporanStats() {
            var selectedYear = document.getElementById('yearFilter').value;
            var url = '<?= site_url('get-laporan-stats'); ?>';

            if (selectedYear) {
                url += '?year=' + selectedYear;
            }
            fetch(url)
                .then(response => response.json())
                .then(bulan => {
                    createAndShowChart(bulan);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function createAndShowChart(data) {
            var ctx = document.getElementById('barChart').getContext('2d');

            // Hancurkan chart yang sudah ada jika ada
            if (window.myChart) {
                window.myChart.destroy();
            }

            var chartOptions = {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            fontColor: 'rgba(0,0,0,0.5)',
                            fontStyle: 'bold',
                            beginAtZero: true,
                            maxTicksLimit: 5,
                            padding: 20,
                            callback: function (value) {
                                // Fungsi callback untuk memastikan angka selalu bulat
                                return Number.isInteger(value) ? value : '';
                            }
                        },
                        gridLines: {
                            drawTicks: false,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            zeroLineColor: 'transparent'
                        },
                        ticks: {
                            padding: 20,
                            fontColor: 'rgba(0,0,0,0.5)',
                            fontStyle: 'bold',
                            autoSkip: false
                        }
                    }]
                }
            };

            if (chartType === 'line') {
                window.myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.map(item => getMonthName(item.month)),
                        datasets: [{
                            label: 'Total',
                            borderColor: getPredefinedColors(0, 'line'),
                            pointBorderColor: getPredefinedColors(0, 'line'),
                            pointBackgroundColor: getPredefinedColors(0, 'line'),
                            pointHoverBackgroundColor: getPredefinedColors(0, 'line'),
                            pointHoverBorderColor: getPredefinedColors(0, 'line'),
                            pointBorderWidth: 10,
                            pointHoverRadius: 10,
                            pointHoverBorderWidth: 1,
                            pointRadius: 3,
                            fill: false,
                            borderWidth: 4,
                            data: data.map(item => item.total)
                        }]
                    },
                    options: chartOptions
                });
            } else {
                window.myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.map(item => getMonthName(item.month)),
                        datasets: [{
                            label: 'Total',
                            data: data.map(item => item.total),
                            backgroundColor: Array.from({ length: data.length }, (_, i) => getPredefinedColors(i)),
                            borderColor: Array.from({ length: data.length }, (_, i) => getPredefinedColors(i)),
                            borderWidth: 1
                        }]
                    },
                    options: chartOptions
                });
            }
            var detailTableBody = document.getElementById('detailTableBody');
            detailTableBody.innerHTML = ''; // Clear previous content

            data.forEach(function (item) {
                var mostReportedItemInfo = getMostReportedItemInfo(item.barang_terbanyak);

                var row = document.createElement('tr');
                row.innerHTML = `
            <td class="text-center">${getMonthName(item.month)}</td>
            <td class="text-center">${item.total}</td>
            <td class="text-center">${mostReportedItemInfo.item}</td>
            <td class="text-center">${mostReportedItemInfo.count}</td>
        `;
                detailTableBody.appendChild(row);
            });


        }


        function getPredefinedColors(index, chartType) {
            if (chartType === 'line') {
                // Warna untuk line chart
                return `rgba(0, 123, 255, 1)`;
            } else {
                // Warna untuk bar chart
                var predefinedColors = [
                    [217, 37, 80],
                    [58, 196, 125],
                    [63, 106, 216],
                    [247, 185, 36],
                    [22, 170, 255],
                    [188, 123, 202],
                    [54, 59, 116],
                    [239, 79, 145],
                    [59, 169, 158],
                    [131, 109, 97],
                    [144, 152, 120],
                    [105, 84, 117]
                ];
                return `rgba(${predefinedColors[index % predefinedColors.length].join(',')}, 1)`;
            }
        }
        // Function to convert month number to month name
        function getMonthName(month) {
            var months = [
                'January', 'February', 'March', 'April',
                'May', 'June', 'July', 'August',
                'September', 'October', 'November', 'December'
            ];
            return months[month - 1]; // Months are 0-indexed in JavaScript Date object
        }


        // Function to generate random colors for the chart
        function getRandomColors(index) {
            return getPredefinedColors(index);
        }
        var chartType = 'bar'; // Default chart type

        // Function untuk memilih tipe chart berdasarkan dropdown
        function selectChartType() {
            chartType = document.getElementById('chartTypeSelector').value;
            getLaporanStats(); // Ambil data dan tampilkan chart berdasarkan tipe yang dipilih
        }

        function getMostReportedItemInfo(items) {
            // Assuming items is a comma-separated list
            var itemsArray = items.split(',');
            var counts = {};

            // Count occurrences of each item
            itemsArray.forEach(function (item) {
                counts[item] = (counts[item] || 0) + 1;
            });

            // Find the most reported item and its count
            var mostReportedItem = Object.keys(counts).reduce(function (a, b) {
                return counts[a] > counts[b] ? a : b;
            });

            var mostReportedItemCount = counts[mostReportedItem];

            return {
                item: mostReportedItem || 'N/A', // Return 'N/A' if no item is found
                count: mostReportedItemCount || 0 // Return 0 if no item is found
            };
        }

        document.addEventListener('DOMContentLoaded', function () {
            getLaporanStats(); // Panggil fungsi untuk mendapatkan dan menampilkan data pada saat halaman dimuat

            document.getElementById('yearFilter').addEventListener('change', getLaporanStats);

            document.getElementById('chartTypeSelector').addEventListener('change', selectChartType);

        });
    </script>
    <script>
        function getAssetsData() {
            var selectedYear = document.getElementById('yearFilterAssets').value;
            var selectedChartTypeAssets = document.getElementById('chartTypeSelectorAssets').value;
            var url = '<?= site_url('PostController/GetAssetsData'); ?>';

            if (selectedYear) {
                url += '?year=' + selectedYear;
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (selectedChartTypeAssets === 'Pie') {
                        createAndShowPieChartAssets(data);
                    } else if (selectedChartTypeAssets === 'Half') {
                        createAndShowHalfDoughnutChartAssets(data);
                    } else {
                        createAndShowDoughnutChartAssets(data);
                    }

                    populateTable(data);

                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
        function populateTable(data) {
            var tableBody = document.getElementById('detailTableBodyAssets');
            tableBody.innerHTML = ''; // Clear existing rows

            data.data.forEach(item => {
                var row = tableBody.insertRow();
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);

                cell1.innerHTML = `<div class="text-center">${item.jenis_aset}</div>`;
                cell2.innerHTML = `<div class="text-center">${item.total}</div>`;

                // Calculate and display percentage
                var percentage = ((item.total / data.total) * 100).toFixed(1);
                cell3.innerHTML = `<div class="text-center">${percentage}%</div>`;
            });
        }

        function createAndShowPieChartAssets(response) {
            if (!response || !response.data || !Array.isArray(response.data) || response.data.length === 0) {
                console.error('Error: Invalid data');
                return;
            }

            var data = response.data;
            var total = response.total; // Use the overall total from the received data
            var ctx = document.getElementById('pieChart-Assets').getContext('2d');

            if (window.myDoughnutChartAssets) {
                window.myDoughnutChartAssets.destroy();
            }

            window.myDoughnutChartAssets = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: data.map(item => item.jenis_aset),

                    datasets: [{
                        data: data.map(item => item.total),
                        backgroundColor: Array.from({ length: data.length }, (_, i) => getPredefinedColors(i)),
                        borderColor: Array.from({ length: data.length }, (_, i) => getPredefinedColors(i)),
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y', // Atur indexAxis menjadi 'y'
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {

                        legend: {
                            display: false,

                        },
                        tooltip: {

                            callbacks: {
                                label: function (context) {
                                    var currentValue = context.dataset.data[context.dataIndex];
                                    var percentage = ((currentValue / total) * 100).toFixed(1) + "%";
                                    return `${context.label}: ${currentValue} ( ${percentage} )`;
                                }
                            }


                        },
                        datalabels: {
                            formatter: (value, ctx) => {
                                let percentage = ((value / total) * 100).toFixed(1) + "%";
                                return percentage;
                            },
                            color: '#fff',
                            anchor: 'end',
                            align: 'start',
                            offset: 8,
                            font: {
                                size: '1.2em'
                            },
                        }
                    },
                    // Add tooltips to show the total value in the center
                    tooltips: {
                        enabled: true,

                    },
                    // circumference: Math.PI,
                    // rotation: -Math.PI,
                    // cutout: '80%', // Adjust the cutout to control the size of the center label
                    animation: {
                        animateRotate: false,
                        animateScale: true
                    }
                }
            });


            var existingCenterText = document.getElementById('centerText-Assets');
            if (existingCenterText) {
                existingCenterText.parentNode.removeChild(existingCenterText);
            }

            var centerText = document.createElement('div');
            centerText.id = 'centerText-Assets'; // Add an ID to the element for easy removal
            centerText.innerHTML = `<div style="font-size: 1.5em; text-align: center;">Total: ${Number(total).toLocaleString()}</div>`;
            document.getElementById('pieChart-Assets').parentNode.appendChild(centerText);
        }
        function createAndShowDoughnutChartAssets(response) {
            if (!response || !response.data || !Array.isArray(response.data) || response.data.length === 0) {
                console.error('Error: Invalid data');
                return;
            }

            var data = response.data;
            var total = response.total; // Use the overall total from the received data
            var ctx = document.getElementById('pieChart-Assets').getContext('2d');

            if (window.myDoughnutChartAssets) {
                window.myDoughnutChartAssets.destroy();
            }

            window.myDoughnutChartAssets = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.map(item => item.jenis_aset),

                    datasets: [{
                        data: data.map(item => item.total),
                        backgroundColor: Array.from({ length: data.length }, (_, i) => getPredefinedColors(i)),
                        borderColor: Array.from({ length: data.length }, (_, i) => getPredefinedColors(i)),
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y', // Atur indexAxis menjadi 'y'
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {

                        legend: {
                            display: false,

                        },
                        tooltip: {

                            callbacks: {
                                label: function (context) {
                                    var currentValue = context.dataset.data[context.dataIndex];
                                    var percentage = ((currentValue / total) * 100).toFixed(1) + "%";
                                    return `${context.label}: ${currentValue} ( ${percentage} )`;
                                }
                            }


                        },
                        datalabels: {
                            formatter: (value, ctx) => {
                                let percentage = ((value / total) * 100).toFixed(1) + "%";
                                return percentage;
                            },
                            color: '#fff',
                            anchor: 'end',
                            align: 'start',
                            offset: 8,
                            font: {
                                size: '1.2em'
                            },
                        }
                    },
                    // Add tooltips to show the total value in the center
                    tooltips: {
                        enabled: true,

                    },
                    // circumference: Math.PI,
                    // rotation: -Math.PI,
                    // cutout: '80%', // Adjust the cutout to control the size of the center label
                    animation: {
                        animateRotate: false,
                        animateScale: true
                    }
                }
            });


            var existingCenterText = document.getElementById('centerText-Assets');
            if (existingCenterText) {
                existingCenterText.parentNode.removeChild(existingCenterText);
            }

            var centerText = document.createElement('div');
            centerText.id = 'centerText-Assets'; // Add an ID to the element for easy removal
            centerText.innerHTML = `<div style="font-size: 1.5em; text-align: center;">Total: ${Number(total).toLocaleString()}</div>`;
            document.getElementById('pieChart-Assets').parentNode.appendChild(centerText);
        }
        function createAndShowHalfDoughnutChartAssets(response) {
            if (!response || !response.data || !Array.isArray(response.data) || response.data.length === 0) {
                console.error('Error: Invalid data');
                return;
            }

            var data = response.data;
            var total = response.total; // Use the overall total from the received data
            var ctx = document.getElementById('pieChart-Assets').getContext('2d');

            if (window.myDoughnutChartAssets) {
                window.myDoughnutChartAssets.destroy();
            }

            window.myDoughnutChartAssets = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.map(item => item.jenis_aset),

                    datasets: [{
                        data: data.map(item => item.total),
                        backgroundColor: Array.from({ length: data.length }, (_, i) => getPredefinedColors(i)),
                        borderColor: Array.from({ length: data.length }, (_, i) => getPredefinedColors(i)),
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y', // Atur indexAxis menjadi 'y'
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {

                        legend: {
                            display: false,

                        },
                        tooltip: {

                            callbacks: {
                                label: function (context) {
                                    var currentValue = context.dataset.data[context.dataIndex];
                                    var percentage = ((currentValue / total) * 100).toFixed(1) + "%";
                                    return `${context.label}: ${currentValue} ( ${percentage} )`;
                                }
                            }


                        },
                        datalabels: {
                            formatter: (value, ctx) => {
                                let percentage = ((value / total) * 100).toFixed(1) + "%";
                                return percentage;
                            },
                            color: '#fff',
                            anchor: 'end',
                            align: 'start',
                            offset: 8,
                            font: {
                                size: '1.2em'
                            },
                        }
                    },
                    // Add tooltips to show the total value in the center
                    tooltips: {
                        enabled: true,

                    },
                    circumference: Math.PI,
                    rotation: -Math.PI,
                    cutout: '80%', // Adjust the cutout to control the size of the center label
                    animation: {
                        animateRotate: false,
                        animateScale: true
                    }
                }
            });


            var existingCenterText = document.getElementById('centerText-Assets');
            if (existingCenterText) {
                existingCenterText.parentNode.removeChild(existingCenterText);
            }

            var centerText = document.createElement('div');
            centerText.id = 'centerText-Assets'; // Add an ID to the element for easy removal
            centerText.innerHTML = `<div style="font-size: 1.5em; text-align: center;">Total: ${Number(total).toLocaleString()}</div>`;
            document.getElementById('pieChart-Assets').parentNode.appendChild(centerText);
        }
        function getPredefinedColors(index) {
            var predefinedColors = [
                [217, 37, 80],
                [58, 196, 125],
                [63, 106, 216],
                [247, 185, 36],
                [22, 170, 255],
                [188, 123, 202],
                [54, 59, 116],
                [239, 79, 145],
                [59, 169, 158],
                [131, 109, 97],
                [144, 152, 120],
                [105, 84, 117]
            ];
            return `rgba(${predefinedColors[index % predefinedColors.length].join(',')}, 1)`;
        }

        function getRandomColors(index) {
            return getPredefinedColors(index);
        }

        document.addEventListener('DOMContentLoaded', function () {
            getAssetsData();
            document.getElementById('yearFilterAssets').addEventListener('change', getAssetsData);
            document.getElementById('chartTypeSelectorAssets').addEventListener('change', getAssetsData);

        });
    </script>

    <script>

        document.addEventListener("DOMContentLoaded", function () {
            fetch('/assets/data') // Panggil API yang kita buat
                .then(response => response.json())
                .then(data => {
                    populateAssetTable(data);
                    generateAssetPieChart(data);
                })
                .catch(error => console.error('Error fetching asset data:', error));
        });

        function populateAssetTable(data) {
            var tableBody = document.getElementById('detailTableBodyAllAssets');
            tableBody.innerHTML = ''; // Hapus isi tabel sebelumnya

            data.data.forEach(item => {
                var row = tableBody.insertRow();
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);

                cell1.innerHTML = `<div class="text-center">${item.jenis_aset}</div>`;
                cell2.innerHTML = `<div class="text-center">${item.rusak_ringan}</div>`;
                cell3.innerHTML = `<div class="text-center">${item.rusak_berat}</div>`;
                cell4.innerHTML = `<div class="text-center">${item.total}</div>`;

                // Hitung dan tampilkan persentase
                var percentage = ((item.total / data.total) * 100).toFixed(1);
                cell5.innerHTML = `<div class="text-center">${percentage}%</div>`;
            });
        }


        function generateAssetPieChart(response) {
            if (!response || !response.data || !Array.isArray(response.data) || response.data.length === 0) {
                console.error('Error: Invalid data');
                return;
            }

            var data = response.data;
            var total = response.total;
            var ctx = document.getElementById('pieChart-AllAssets').getContext('2d');



            window.AkuDoughnutChartAssets = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: data.map(item => item.jenis_aset),
                    datasets: [{
                        data: data.map(item => item.total),
                        backgroundColor: data.map((_, i) => getPredefinedWarna(i)),
                        borderColor: data.map((_, i) => getPredefinedWarna(i)),
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var currentValue = context.dataset.data[context.dataIndex];
                                    var percentage = ((currentValue / total) * 100).toFixed(1) + "%";
                                    return `${context.label}: ${currentValue} ( ${percentage} )`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Fungsi untuk mendapatkan warna secara otomatis
        function getPredefinedWarna(index) {
            const colors = [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#FFCD56'
            ];
            return colors[index % colors.length];
        }

    </script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>





    <?= $this->endSection(); ?>