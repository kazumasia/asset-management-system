<div class="app-header header-shadow">
    <div class="app-header__logo">
        <div class="logo"><img class="logo-src1" src="<?= base_url(); ?>img/bps.png" /></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                    data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="app-header__content">

        <div class="app-header-right">
            <!-- Notifikasi Pengaduan Baru ala Facebook -->
            <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" type="button" id="notifDropdown" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span class="badge badge-danger" id="notifCount" style="display: none;">0</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notifDropdown" style="width: 300px;">
                    <h6 class="dropdown-header">Notifikasi Baru</h6>
                    <ul class="list-group" id="notifList"></ul>
                </div>
            </div>





            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    <img width="42" class="rounded-circle"
                                        src="<?= base_url('assets/images/avatars/1.jpg'); ?>" alt="">
                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true"
                                    class="dropdown-menu dropdown-menu-right">
                                    <a href="<?= base_url('logout'); ?>" tabindex="0" class="dropdown-item">Log-Out</a>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content-left ml-3 header-user-info">
                            <div class="widget-heading">
                                <?= user()->username; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.socket.io/4.5.0/socket.io.min.js"></script>
<!-- <script>
    const socket = io('http://localhost:3000'); // URL server Socket.IO

    // Fungsi untuk memuat notifikasi dari local storage
    function loadNotifications() {
        const notifList = document.getElementById('notifList');
        const notifCount = document.getElementById('notifCount');
        let storedNotifications = JSON.parse(localStorage.getItem('notifications')) || [];

        // Filter notifikasi yang masih valid (<= 1 hari)
        const now = new Date().getTime();
        storedNotifications = storedNotifications.filter(notification => {
            const notifTime = new Date(notification.timestamp).getTime();
            return (now - notifTime) <= 24 * 60 * 60 * 1000; // 1 hari dalam milidetik
        });

        // Simpan kembali notifikasi yang masih valid
        localStorage.setItem('notifications', JSON.stringify(storedNotifications));

        // Tampilkan notifikasi di UI
        notifList.innerHTML = '';
        storedNotifications.forEach(notification => {
            const newNotif = document.createElement('li');
            newNotif.className = 'list-group-item';
            newNotif.innerHTML = notification.message;
            notifList.prepend(newNotif);
        });

        // Perbarui badge notifikasi
        notifCount.innerText = storedNotifications.length;
    }

    // Fungsi untuk menambah notifikasi ke local storage
    function addNotification(data) {
        const storedNotifications = JSON.parse(localStorage.getItem('notifications')) || [];
        storedNotifications.push({ message: data.message, timestamp: new Date().toISOString() });
        localStorage.setItem('notifications', JSON.stringify(storedNotifications));
        loadNotifications();
    }

    // Muat notifikasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', loadNotifications);

    // Tangkap notifikasi dari server
    socket.on('receive-notification', function (data) {
        addNotification(data); // Simpan notifikasi ke local storage
    });

    // Tangkap notifikasi pemeliharaan dari server
    socket.on('maintenance-reminder', function (data) {
        addNotification(data); // Simpan notifikasi pemeliharaan ke local storage
    });
</script> -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function fetchNotifications() { // Pindahkan ke global scope
        $.ajax({
            url: "<?= site_url('notification/getNotifications') ?>",
            type: "GET",
            dataType: "json",
            success: function (data) {
                $("#notifList").empty();
                if (data.length > 0) {
                    $("#notifCount").text(data.length).show();
                    data.forEach(function (notification) {
                        $("#notifList").append(
                            `<li class="list-group-item">
                                <a href="#" onclick="markAsRead(${notification.id}, this)">
                                    ${notification.message}
                                </a>
                            </li>`
                        );
                    });
                } else {
                    $("#notifCount").hide();
                }
            }
        });
    }

    function markAsRead(id, element) {
        $.ajax({
            url: "<?= site_url('notification/markAsRead') ?>/" + id,
            type: "POST",
            success: function (response) {
                if (response.status === "success") {
                    $(element).closest("li").remove(); // Hapus notifikasi yang diklik
                    fetchNotifications(); // Perbarui daftar notifikasi
                }
            }
        });
    }

    $(document).ready(function () {
        // Jalankan setiap 5 detik
        setInterval(fetchNotifications, 5000);

        // Panggil pertama kali saat halaman dimuat
        fetchNotifications();
    });
</script>