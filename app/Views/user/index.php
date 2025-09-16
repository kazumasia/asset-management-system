<!DOCTYPE html>
<html lang="en">
<meta name="csrf_token" content="<?= csrf_hash() ?>">

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

                <?php if (in_groups('admin') || in_groups('pimpinan') || in_groups('Tata Usaha') || in_groups('pimpinan') || in_groups('IPDS')): ?>

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
                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                                    <label for="nama">Nama:</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Contoh: Ahmad Yani"
                                        name="nama" required>
                                </div>
                                <!-- Nomor Aset -->
                                <!-- <div class="form-group">
                                    <label for="nomor_aset">Nomor Aset:</label>
                                    <input type="text" class="form-control" id="nomor_aset"
                                        placeholder="Contoh: AS-12345" name="nomor_aset" required>
                                </div> -->
                                <div class="form-group">
                                    <label for="nomor_aset">Nomor Aset:</label>
                                    <input type="text" class="form-control" id="nomor_aset"
                                        placeholder="Contoh: AS-12345" name="nomor_aset">
                                </div>
                                <!-- Jenis Aset -->
                                <div class="form-group">
                                    <label for="kondisi_aset">Kategori Kondisi Aset:</label>
                                    <select class="form-control" id="kondisi_aset" name="kondisi_aset"
                                        onchange="checkKondisiLainnya()" required>
                                        <option value="">--Pilih Kondisi Aset--</option>
                                        <option value="bagus">Bagus</option>
                                        <option value="Rusak Ringan">Rusak Ringan</option>
                                        <option value="Rusak Berat">Rusak Berat</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <!-- Input Teks Lainnya untuk Kondisi Aset -->
                                <div id="divKondisiLainnyaAset" style="display:none;" class="form-group">
                                    <label for="kondisi_aset_lainnya">Kondisi Aset Lainnya:</label>
                                    <input type="text" class="form-control" id="kondisi_aset_lainnya"
                                        name="kondisi_aset_lainnya" placeholder="Masukkan Kondisi Aset Lainnya">
                                </div>

                            </div>

                            <div class="col-md-6">
                                <!-- <div class="form-group">
                                    <label for="jenis_aset">Pilih Jenis Aset:</label>
                                    <select class="form-control" id="jenis_aset" name="jenis_aset"
                                        onchange="checkLainnya()" required>
                                        <option value="">--Pilih Jenis Aset--</option>
                                        <option value="laptop">Laptop</option>
                                        <option value="printer">Printer</option>
                                        <option value="monitor">Monitor</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div> -->

                                <!-- Input Teks Lainnya untuk Jenis Aset -->
                                <!-- <div id="divLainnyaAset" style="display:none;" class="form-group">
                                    <label for="jenis_aset_lainnya">Jenis Aset Lainnya:</label>
                                    <input type="text" class="form-control" id="jenis_aset_lainnya"
                                        name="jenis_aset_lainnya" placeholder="Masukkan Jenis Aset Lainnya">
                                </div> -->

                                <div class="form-group">
                                    <label for="jenis_aset">Jenis Aset:</label>
                                    <input type="text" class="form-control" id="jenis_aset" name="jenis_aset">
                                </div>
                                <div class="form-group">
                                    <label for="nup">NUP Aset:</label>
                                    <input type="text" class="form-control" id="nup" name="nup">
                                </div>
                                <div class="form-group">
                                    <label for="merk">Merk Aset:</label>
                                    <input type="text" class="form-control" id="merk" name="merk">
                                </div>



                            </div>


                            <div class="col-md-12 text-center mt-3">
                                <div class="form-group">
                                    <label for="lokasi">Lokasi/Letak Aset</label>
                                    <input type="text" class="form-control" id="lokasi"
                                        placeholder="Contoh: Lantai 2 Ruang TU" name="lokasi" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi Kerusakan</label>
                                    <textarea class="form-control" id="deskripsi"
                                        placeholder="Contoh: Layar Monitornya Bergaris" name="deskripsi" rows="4"
                                        required></textarea>
                                </div>

                                <button id="submitButton" type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <!-- <script>
                // Daftar aset (nomor aset dan jenis aset)
                // Daftar aset (kode awal dan jenis aset)
                const asetList = {
                    "3100102001": "P.C Unit",
                    "3100102002": "Lap Top",
                    "3100203003": "Printer (Peralatan Personal Komputer)",
                    "3100203004": "Scanner (Peralatan Personal Komputer)",
                    "3100203017": "External/ Portable Hardisk"
                };

                // Event listener untuk input nomor aset
                document.getElementById("nomor_aset").addEventListener("input", function () {
                    const nomorAset = this.value.trim(); // Ambil input dan hilangkan spasi
                    const kodeAwal = nomorAset.split("-")[0]; // Ambil bagian sebelum tanda "-" (jika ada)
                    const jenisAset = asetList[kodeAwal] || "Nomor aset tidak ditemukan"; // Cari jenis aset berdasarkan kode awal
                    document.getElementById("jenis_aset").value = jenisAset; // Tampilkan jenis aset
                });

                // Handle form submission
                document.getElementById("form-aset").addEventListener("submit", function (e) {
                    e.preventDefault(); // Mencegah refresh halaman
                    alert("Data berhasil disimpan!");
                });

            </script> -->

            <!-- <script>
                // Daftar aset (kode awal dan jenis aset)
                const asetList = {
                    "3100102001": "P.C Unit",
                    "3100102002": "Lap Top",
                    "3100203003": "Printer (Peralatan Personal Komputer)",
                    "3100203004": "Scanner (Peralatan Personal Komputer)",
                    "3100203017": "External/ Portable Hardisk"
                };

                // Daftar merk berdasarkan NUP
                const merkList = {
                    "3100102001": {
                        "12": "P.C. Unit Dell/Optiplex 3010 DT",
                        "14": "Dell OptiPlex 3020 Micro + Monitor Dell E2214H",
                        "15": "Dell OptiPlex 3020 Micro + Monitor Dell E2214H",
                        "16": "Dell OptiPlex 3020 Micro + Monitor Dell E2214H",
                        "17": "Dell OptiPlex 3020 Micro + Monitor Dell E2214H",
                        "20": "Lenovo ThinkStation P320",
                        "21": "ThinkCentre M720t",
                        "22": "ThinkCentre M720t",
                        "23": "ThinkCentre M720t",
                        "24": "ThinkCentre M720t",
                        "25": "ThinkCentre M720t",
                        "26": "HP Prodesk 400 G 5 SFF",
                        "27": "HP Prodesk 400 G 5 SFF",
                        "28": "Dell OptiPlex 3020 Micro + Monitor Dell E2214H",
                        "29": "PC Lenovo All in one black",
                        "30": "Acer Veriton Z4 AIO-Core I7 (VZ4/0033)",
                        "31": "Acer Veriton Z4 AIO-Core I7 (VZ4/0033)",
                        "32": "Acer Veriton Z4 AIO-Core I7 (VZ4/0033)",
                        "33": "Acer Veriton Z4 AIO-Core I7 (VZ4/0033)",
                        "34": "Acer Veriton Z4 AIO-Core I7 (VZ4/0033)",
                        "35": "Acer Veriton Z4 AIO-Core I7 (VZ4/0033)",
                        "36": "Acer Veriton Z4 AIO-Core I7 (VZ4/0033)",
                        "37": "Acer Veriton X-Core I7-12700",
                        "38": "Acer Veriton X-Core I7-12700",
                        "39": "Acer Veriton X-Core I7-12700",
                        "40": "Acer Veriton X-Core I7-12700",
                        "41": "Acer Veriton X-Core I7-12700",
                        "42": "Acer Veriton X-Core I7-12700",
                        "43": "Acer Veriton X-Core I7-12700",
                        "44": "Acer Veriton X-Core I7-12700"
                    },
                    "3100102002": {
                        "20": "HP 240 G76MC16PA Black",
                        "21": "Notebook MSI Modern 14 B10 RAWSBLUE",
                        "22": "Laptop LENOVO Yoga9-14ITL05",
                        "23": "Lenovo Yoga 7-14ITL05",
                        "24": "LAPTOP ASUS FX506HM",
                        "25": "LAPTOP ASUS FX506HM",
                        "26": "LAPTOP ASUS FX506HM",
                        "27": "LAPTOP ASUS FX506HM",
                        "28": "LAPTOP ASUS FX506HM",
                        "29": "LAPTOP ASUS FX506HM",
                        "30": "LAPTOP ASUS FX506HM",
                        "31": "Acer",
                        "32": "Acer",
                        "33": "Acer",
                        "34": "Acer",
                        "35": "Acer",
                        "36": "Acer"
                    },
                    "3100203003": {
                        "5": "HP Business Notebook 348 G4",
                        "6": "HP laserjet Pro400 M401d",
                        "7": "HP laserjet Pro CP1025 Colour",
                        "8": "Epson/ Stylus L3110",
                        "9": "Epson/ Stylus L3110",
                        "10": "Epson Printer InkJet L1455",
                        "11": "Laserjet Enterprise M507dn",
                        "12": "Printer Epson L3110",
                        "13": "Printer Epson L3110",
                        "14": "printer Epson WF-100",
                        "15": "printer Epson L3110",
                        "16": "printer Epson L3110",
                        "17": "printer epson Stylus L3110",
                        "18": "Printer HP Office Jet 250",
                        "19": "printer canon pixma ink Efficient",
                        "20": "Epson (EcoTank L15160)"
                    },
                    "3100203004": {
                        "2": "Fujitsu Image Scanner fi-7260",
                        "3": "Fujitsu Scanner FI-8150U"
                    },
                    "3100203017": {
                        "1": "HARDDISK Notebook 1 TB WDC MY Passport USB 3.0 EXT",
                        "2": "HARDDISK Notebook 1 TB WDC MY Passport USB 3.0 EXT",
                        "3": "HARDDISK Notebook 1 TB WDC MY Passport USB 3.0 EXT",
                        "4": "HARDDISK Notebook 1 TB WDC MY Passport USB 3.0 EXT",
                        "5": "HARDDISK Notebook 1 TB WDC MY Passport USB 3.0 EXT",
                        "6": "HARDDISK Notebook 1 TB WDC MY Passport USB 3.0 EXT",
                        "7": "HARDDISK Portable tranced 1 TB"
                    }
                };

                // Fungsi untuk menampilkan jenis aset dan merk
                function updateAsetInfo() {
                    const kodeAset = document.getElementById("nomor_aset").value.trim();
                    const nup = document.getElementById("nup").value.trim();

                    // Cari jenis aset berdasarkan kode aset
                    const jenisAset = asetList[kodeAset] || "Kode aset tidak ditemukan";
                    document.getElementById("jenis_aset").value = jenisAset;

                    // Cari merk berdasarkan kode aset dan NUP
                    const merkAset = (merkList[kodeAset] && merkList[kodeAset][nup]) || "Merk tidak ditemukan";
                    document.getElementById("merk").value = merkAset;
                }

                // Event listener untuk input kode aset dan NUP
                document.getElementById("nomor_aset").addEventListener("input", updateAsetInfo);
                document.getElementById("nup").addEventListener("input", updateAsetInfo);

                // Handle form submission
                document.getElementById("form-aset").addEventListener("submit", function (e) {
                    e.preventDefault(); // Mencegah refresh halaman
                    alert("Data berhasil disimpan!");
                });
            </script> -->
            <!-- <script type="text/javascript">
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
                document.getElementById("kondisi_aset").addEventListener("change", checkLainnya);

                function checkKondisiLainnya() {
                    var jenisAsetDropdown = document.getElementById("kondisi_aset");
                    var divLainnyaAset = document.getElementById("divKondisiLainnyaAset");
                    var jenisAsetLainnya = document.getElementById("kondisi_aset_lainnya");

                    if (jenisAsetDropdown.value === "lainnya") {
                        divLainnyaAset.style.display = "block";
                        jenisAsetLainnya.setAttribute("required", "required");
                    } else {
                        divLainnyaAset.style.display = "none";
                        jenisAsetLainnya.removeAttribute("required");
                    }
                }

                // Attach the event listener to the select element
                document.getElementById("kondisi_aset").addEventListener("change", checkKondisiLainnya)
            </script> -->
            <script>
                // Variabel global untuk asetList dan merkList
                let asetList = {};
                let merkList = {};

                // Fungsi untuk mengambil data aset dari endpoint API
                function loadAssetData() {
                    fetch("<?= base_url('api/assets') ?>")
                        .then(response => response.json())
                        .then(data => {
                            // Asumsikan data asset memiliki struktur seperti:
                            // { id, kode_barang, nup, nama_barang, merk, ... }
                            // Kita bangun asetList dan merkList dari data tersebut
                            data.forEach(asset => {
                                // Gunakan 'kode_barang' sebagai key untuk asetList
                                asetList[asset.kode_barang] = asset.nama_barang;

                                // Untuk merkList, kita misalnya mengelompokkan berdasarkan kode_barang dan nup
                                // Pastikan asset.nup ada nilainya, jika tidak, bisa diabaikan atau disesuaikan
                                if (asset.nup) {
                                    if (!merkList[asset.kode_barang]) {
                                        merkList[asset.kode_barang] = {};
                                    }
                                    // Gunakan nup sebagai key untuk merk
                                    merkList[asset.kode_barang][asset.nup] = asset.merk;
                                }
                            });
                            console.log("AsetList:", asetList);
                            console.log("MerkList:", merkList);
                        })
                        .catch(error => console.error('Error fetching asset list:', error));
                }

                // Panggil fungsi loadAssetData() ketika halaman dimuat
                document.addEventListener("DOMContentLoaded", loadAssetData);

                // Fungsi untuk menampilkan informasi aset berdasarkan input
                function updateAsetInfo() {
                    const kodeAset = document.getElementById("nomor_aset").value.trim();
                    const nup = document.getElementById("nup").value.trim();

                    // Cari jenis aset berdasarkan kode aset
                    const jenisAset = asetList[kodeAset] || "Kode aset tidak ditemukan";
                    document.getElementById("jenis_aset").value = jenisAset;

                    // Cari merk berdasarkan kode aset dan NUP
                    const merkAset = (merkList[kodeAset] && merkList[kodeAset][nup]) || "Merk tidak ditemukan";
                    document.getElementById("merk").value = merkAset;
                }

                // Event listener untuk input kode aset dan NUP
                document.getElementById("nomor_aset").addEventListener("input", updateAsetInfo);
                document.getElementById("nup").addEventListener("input", updateAsetInfo);
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
                        <form action="<?= base_url('PostController/filter') ?>" method="post">
                            <div class="form-group">
                                <label for="selected_date">Pilih Tanggal:</label>
                                <div class="input-group">
                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

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
                        <form action="<?= base_url('PostController/search') ?>" method="post">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

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
                <table class="table table-bordered mt-1">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Nomor Aset</th>
                            <th class="text-center">Jenis Aset</th>
                            <th class="text-center">Merk Aset</th>
                            <th class="text-center">Kondisi Aset</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Lokasi</th>
                            <th class="text-center">Tanggal Pembuatan Laporan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Tanggal Selesai Laporan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($laporan as $lapor): ?>
                            <tr>
                                <td class="text-center">
                                    <?= $lapor['nama']; ?>
                                </td>
                                <td class="text-center">
                                    <?= $lapor['nomor_aset']; ?>
                                </td>
                                <td class="text-center">
                                    <?= $lapor['jenis_aset']; ?>
                                </td>
                                <td class="text-center">
                                    <?= $lapor['merk']; ?>
                                </td>
                                <td class="text-center">
                                    <?= $lapor['kondisi_aset']; ?>
                                </td>
                                <td class="text-center">
                                    <?= $lapor['deskripsi']; ?>
                                </td>
                                <td class="text-center">
                                    <?= $lapor['lokasi']; ?>
                                </td>
                                <td class="text-center">
                                    <?= $lapor['created_at']; ?>
                                </td>
                                <td class="text-center apu">
                                    <div style="font-family: sans-serif;"
                                        class="badge <?= ($lapor['status'] == 'Dalam Proses') ? 'badge-warning' : 'badge-success'; ?>">
                                        <?= $lapor['status']; ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <?= ($lapor['status'] == 'Selesai') ? $lapor['tanggal_selesai'] : 'Belum Selesai'; ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>



                <?php if (!empty($laporan)): ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <?php if ($pager): ?>
                                <?= $pager->links('laporan', 'bootstrap_pagination'); ?>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>




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

</body>

<script>
    document.getElementById("submitButton").addEventListener("click", async function (e) {
        e.preventDefault(); // Cegah reload form

        const nup = document.getElementById("nup").value.trim();
        const kode_barang = document.getElementById("nomor_aset").value.trim();

        // Pastikan NUP tidak kosong
        if (nup === "") {
            return Swal.fire({
                title: "NUP Tidak Boleh Kosong",
                text: "Silakan masukkan NUP yang valid.",
                icon: "warning",
                confirmButtonText: "OK"
            });
        }

        // Pastikan kode_barang tidak kosong
        if (kode_barang === "") {
            return Swal.fire({
                title: "Kode Barang Tidak Boleh Kosong",
                text: "Silakan masukkan kode barang yang valid.",
                icon: "warning",
                confirmButtonText: "OK"
            });
        }

        // Ambil token CSRF dari meta tag
        const csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');

        // Cek NUP dan Kode Barang dengan AJAX
        let response;
        try {
            response = await $.ajax({
                url: "<?= base_url('api/check-nup') ?>", // Ganti sesuai endpoint backend
                method: "POST",
                data: { nup: nup, kode_barang: kode_barang },
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Kirimkan CSRF token ke server
                }
            });
        } catch (error) {
            return Swal.fire({
                title: "Error",
                text: "Terjadi kesalahan saat memeriksa data.",
                icon: "error",
                confirmButtonText: "OK"
            });
        }

        // Jika NUP atau Kode Barang tidak ditemukan, tampilkan peringatan dan hentikan proses
        if (!response.nupFound) {
            return Swal.fire({
                title: "NUP Tidak Ditemukan",
                text: "NUP yang Anda masukkan tidak terdaftar di database. Silakan periksa kembali.",
                icon: "warning",
                confirmButtonText: "OK"
            });
        }

        if (!response.kodeBarangFound) {
            return Swal.fire({
                title: "Kode Barang Tidak Ditemukan",
                text: "Kode barang yang Anda masukkan tidak terdaftar di database. Silakan periksa kembali.",
                icon: "warning",
                confirmButtonText: "OK"
            });
        }

        // Jika NUP dan Kode Barang ditemukan, lanjutkan konfirmasi penyimpanan
        const result = await Swal.fire({
            title: "Apakah data yang Anda masukkan sudah benar?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Ya, Simpan",
            cancelButtonText: "Batal"
        });

        if (result.isConfirmed) {
            Swal.fire({
                title: "Menyimpan data...",
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Kirim data form dengan AJAX
            $.ajax({
                url: $("form").attr('action'),
                method: $("form").attr('method'),
                data: $("form").serialize(),
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Kirimkan CSRF token ke server
                },
                success: function () {
                    Swal.fire("Berhasil!", "Data berhasil disimpan.", "success");
                    $("form")[0].reset(); // Reset form
                },
                error: function () {
                    Swal.fire("Gagal!", "Terjadi kesalahan saat menyimpan data.", "error");
                }
            });
        }
    });


</script>
<!-- <script>
    // Trigger SweetAlert konfirmasi ketika pengguna mencoba menyimpan atau mengonfirmasi data
    async function konfirmasiData(e) {
        e.preventDefault(); // Mencegah form dari pengiriman otomatis
        const result = await Swal.fire({
            title: "Apakah data yang Anda masukkan sudah benar?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Ya",
            denyButtonText: "Tidak"
        });

        if (result.isConfirmed) {
            // Jika pengguna mengonfirmasi
            Swal.fire("Data dikonfirmasi!", "", "success");
            // Tunggu sampai animasi Swal selesai sebelum menyimpan data
            setTimeout(() => {
                document.getElementById("form-aset").submit(); // Kirim form setelah konfirmasi
            }, 1000); // Menunggu 1 detik sebelum submit
        } else if (result.isDenied) {
            // Jika pengguna menolak
            Swal.fire("Perubahan tidak disimpan", "", "info");
        }
    }

    // Panggil `konfirmasiData()` saat pengguna mengklik tombol konfirmasi
    document.getElementById("submitButton").addEventListener("click", konfirmasiData);

</script> -->


<script src="<?= base_url(); ?>/js/landing.js"></script>
<script src="<?= base_url(); ?>/js/feedback.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="<?= base_url(); ?>/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url(); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url(); ?>/js/footer.js"></script>
<script src="<?= base_url(); ?>/js/sb-admin-2.js"></script>



<!-- Add this script at the end of your HTML body -->












</html>