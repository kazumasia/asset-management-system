<?= $this->extend('templates/admin'); ?>

<?= $this->section('page-content'); ?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Kalender Manajemen Aset</h3>
        </div>
        <div class="card-body">
            <div id="kalender"></div>
        </div>
    </div>
</div>

<!-- FullCalendar -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let calendarEl = document.getElementById("kalender");

        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: "dayGridMonth",
            locale: "id",
            themeSystem: "bootstrap",
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,listWeek"
            },
            events: "<?= base_url('admin/calendar/events'); ?>",
            eventDidMount: function (info) {
                if (info.event.allDay) {
                    info.event.setProp("allDay", true);
                }

                if (info.event.start && info.event.end) {
                    let diff = info.event.end.getTime() - info.event.start.getTime();
                    if (diff > 86400000) {
                        info.el.style.display = "block";
                    }
                }
            },
            eventClick: function (info) {
                let startDate = info.event.start ? info.event.start.toLocaleDateString("id-ID") : "Tidak Diketahui";
                let endDate = info.event.end ? info.event.end.toLocaleDateString("id-ID") : null;
                let status = info.event.extendedProps.status || "Tidak Diketahui";

                let description = info.event.extendedProps.description
                    ? "<br><b>Deskripsi:</b> " + info.event.extendedProps.description
                    : "";

                let endOrStatus = endDate ? `<br><b>Berakhir:</b> ${endDate}` : `<br><b>Status:</b> ${status}`;

                Swal.fire({
                    title: info.event.title,
                    html: `<b>Mulai:</b> ${startDate} ${endOrStatus} ${description}`,
                    icon: "info",
                    confirmButtonText: "Tutup"
                });
            }
        });

        calendar.render();
    });



</script>

<?= $this->endSection(); ?>