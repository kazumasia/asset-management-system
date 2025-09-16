<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPS Ogan Ilir</title>
    <link rel="icon" href="<?= base_url(); ?>/img/bps.png" type="image/png">

    <link href="<?= base_url(); ?>/css/landing.css" rel="stylesheet" type="text/css">

    <link href="<?= base_url(); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>/css/styles.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>/css/main.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>/assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>/assets/vendor/bootstrap-icons/boostrap-icon-min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>/assets/vendor/bootstrap/bootstrap.scss" rel="stylesheet">
    <link href="<?= base_url(); ?>/css/footer.css" rel="stylesheet">


    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- Custom styles for this template-->
    <link href="<?= base_url(); ?>/css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body>
    <div class="cursor"></div>
    <div class="cursor-border"></div>
    <header>
        <a href="#home" class="logo"><img width="250" src="<?= base_url(); ?>img/bps.png" />
            Badan Pusat Statistik Kabupaten Ogan Ilir</a>

        <nav class="site-nav">
            <ul class="underline-menu">
                <li><a href="#home">Home</a></li>
                <li><a href="#form">Form Pengaduan</a></li>
                <li><a href="#info">Info Laporan</a></li>

                <?php if (in_groups('admin')): ?>

                    <li>
                        <a href="<?= base_url('admin'); ?>">

                            Halaman Admin</a>
                    </li>


                <?php endif; ?>
                <li>
                    <a href="<?= base_url('logout'); ?>">
                        <i class="fas fa-fw fa-sign-out-alt"> </i> Logout</a>
                </li>

            </ul>
        </nav>
    </header>

    <input type="checkbox" id="burger-toggle" />
    <label for="burger-toggle" class="burger-menu">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </label>
    <div class="overlay"></div>
    <nav class="burger-nav">
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#speakers">Speakers</a></li>
            <li><a href="#sponsors"></a></li>
        </ul>
    </nav>
    <main>
        <section class="hero-section" id="home">
            <!-- <div class="titles">
                <h1 class="staggered-rise-in">Selamat Datang Di </h1>
                <h1 class="staggered-rise-in">Badan Pusat Statistik Kabupaten Ogan Ilir</h1>
                <h2 class="cross-bar-glitch" data-slice="20">Silahkan Isi Buku Tamu</h2>
            </div> -->
            <div class="titles">
                <h1 class="cross-bar-glitch" data-slice="20">Pengaduan Aset Rusak</h1>
                <h1 class="cross-bar-glitch" data-slice="20">Badan Pusat Statistik Kabupaten Ogan Ilir</h1>
                <h2 class="cross-bar-glitch" data-slice="20">Silahkan Isi Pengaduan Aset Rusak Khusus IT</h2>
            </div>



            <a class=" api btn btn-outline-light btn-through kotak" href="#form"><i class="bi bi-book"></i>
                Form Pengaduan <span> </a>
        </section>
        <section class="normal-section" id="form">
            <div class="titles">
                <h1 class="cross-bar-glitch" data-slice="20">Form Pengaduan Aset</h1>
                <h2 class="staggered-rise-in">Badan Pusat Statistik Kabupaten Ogan Ilir</h2>
            </div>


            <div class="container">
                <form action="<?= base_url('PostController/store') ?>" method="POST" class="form-container">
                    <div class="container-fluid bg-transparent p-2 rounded" id="box">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama:</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Contoh: Ahmad Yani"
                                        name="nama" required>
                                </div>
                                <!-- Nomor Aset -->
                                <div class="form-group">
                                    <label for="nomor_aset">Nomor Aset:</label>
                                    <input type="text" class="form-control" id="nomor_aset"
                                        placeholder="Contoh: AS-12345" name="nomor_aset" required>
                                </div>

                                <!-- Jenis Aset -->

                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_aset">Pilih Jenis Aset:</label>
                                    <select class="form-control" id="jenis_aset" name="jenis_aset"
                                        onchange="checkLainnya()" required>
                                        <option value="">--Pilih Jenis Aset--</option>
                                        <option value="laptop">Laptop</option>
                                        <option value="printer">Printer</option>
                                        <option value="monitor">Monitor</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <!-- Input Teks Lainnya untuk Jenis Aset -->
                                <div id="divLainnyaAset" style="display:none;" class="form-group">
                                    <label for="jenis_aset_lainnya">Jenis Aset Lainnya:</label>
                                    <input type="text" class="form-control" id="jenis_aset_lainnya"
                                        name="jenis_aset_lainnya" placeholder="Masukkan Jenis Aset Lainnya">
                                </div>
                                <div class="form-group">
                                    <label for="lokasi">Lokasi/Letak Aset</label>
                                    <input type="text" class="form-control" id="lokasi"
                                        placeholder="Contoh: Lantai 2 Ruang TU" name="lokasi" required>
                                </div>


                            </div>

                            <div class="col-md-12 text-center mt-3">
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi Kerusakan</label>
                                    <textarea class="form-control" id="deskripsi"
                                        placeholder="Contoh: Layar Monitornya Bergaris" name="deskripsi" rows="4"
                                        required></textarea>
                                </div>

                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#myModal">Simpan</button>
                            </div>
                        </div>

                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content bg-dark text-light">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Konfirmasi Data</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah data yang anda masukkan sudah benar?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Ya</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <script type="text/javascript">
                function checkLainnya() {
                    var jenisAsetDropdown = document.getElementById("jenis_aset");
                    var divLainnyaAset = document.getElementById("divLainnyaAset");
                    var jenisAsetLainnya = document.getElementById("jenis_aset_lainnya");

                    if (jenisAsetDropdown.value === "lainnya") {
                        divLainnyaAset.style.display = "block";
                        jenisAsetLainnya.setAttribute("required", "required");
                    } else {
                        divLainnyaAset.style.display = "none";
                        jenisAsetLainnya.removeAttribute("required");
                    }
                }

                // Attach the event listener to the select element
                document.getElementById("jenis_aset").addEventListener("change", checkLainnya);
            </script>



            </div>
        </section>
        <!-- Tabel pengunjung -->
        <section class="normal-section" id="info">
            <div class="titles">
                <h1 class="cross-bar-glitch" data-slice="20">Riwayat Pengaduan Aset</h1>
            </div>
            <div class="container-xxl">
                <div class="row">
                    <!-- Form for selecting date -->
                    <div class="col-md-3">
                        <form id="filter-form">
                            <div class="form-group">
                                <label for="selected_date">Pilih Tanggal:</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="selected_date" name="selected_date"
                                        required>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <!-- Form for searching -->
                    <div class="col-md-9 text-center">
                        <form id="search-form">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="search_query" name="search_query"
                                        placeholder="Cari Data Disini" required>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Table for displaying data -->
                <div id="laporan-table">
                    <!-- Tambahkan spinner -->

                    <div id="data-table">
                        <!-- Data tabel akan dimuat di sini melalui AJAX -->
                    </div>


                </div>

                <!-- Pagination links -->
                <div id="pagination-links">
                    <!-- Pagination links will be injected here by AJAX -->
                </div>
            </div>

        </section>


        <section class="normal-section" id="about">
            <div class="titles">
                <h1 class="cross-bar-glitch" data-slice="20">#Hastag</h1>
                <img class="staggered-rise-in" data-slice="20" width="700" src="<?= base_url(); ?>/img/berakhlak.png" />
            </div>

        </section>

        <footer id="footer">
            <div class="container">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- footer logo -->
                        <div class="footer-logo">
                            <a href="https://oganilirkab.bps.go.id/"><img src="<?= base_url(); ?>/img/bps.png"
                                    alt="scanfcode"></a>
                        </div>
                        <!-- /footer logo -->
                        <!-- footer follow -->
                        <ul class="footer-follow">
                            <li><a href="https://web.facebook.com/bpskaboganilir"><i class="fab fa-facebook"></i></a>
                            </li>
                            <li><a href="https://twitter.com/bpskaboganilir"><i class="fab fa-twitter"></i></a></li>

                            <li><a
                                    href="https://www.instagram.com/bpskaboganilir?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i
                                        class="fab fa-instagram"></i></a></li>
                            <li><a href="https://www.youtube.com/channel/UCGuNHUXOUCrqxsEE_wXQzQg"><i
                                        class="fab fa-youtube"></i></a></li>
                        </ul>
                        <!-- /footer follow -->
                        <!-- footer copyright -->
                        <div class="footer-copyright">
                            <p>Copyright © 2025. All Rights Reserved.</p>
                        </div>
                        <!-- /footer copyright -->
                    </div>
                </div>
                <!-- /Row -->
            </div>
            <!-- /Container -->
        </footer>
    </main>
    <div id="loading-spinner" style="display: none;">
        <img src="<?= base_url(); ?>/img/Spinner/Spinner.gif" alt="Loading..." />
    </div>

</body>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function loadPaginationData(page) {
            $.ajax({
                url: "<?= base_url('PostController/fetchPaginationData') ?>",
                method: "GET",
                data: { page: page },
                success: function (data) {
                    $('#data-table').html(data); // Memuat data ke dalam elemen dengan ID 'data-table'
                }
            });
        }

        // Muat halaman pertama secara otomatis
        loadPaginationData(1);

        // Event klik untuk link pagination
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            loadPaginationData(page);
        });
    });
</script>




<script src="<?= base_url(); ?>/js/landing.js"></script>
<script src="<?= base_url(); ?>/js/feedback.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="<?= base_url(); ?>/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url(); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url(); ?>/js/footer.js"></script>
<script src="<?= base_url(); ?>/js/sb-admin-2.js"></script>



<!-- Add this script at the end of your HTML body -->












</html>