<link href="<?= base_url(); ?>/css/main.css" rel="stylesheet" type="text/css">

<div class="app-sidebar sidebar-shadow">
    <div class="app-header">
        <div class="logo-src"></div>
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
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Dashboards</li>
                <li>
                    <a href="<?= base_url('admin'); ?>">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Dashboard
                    </a>
                </li>


                <li class="app-sidebar__heading">Table Section</li>
                <li>
                    <a href="<?= base_url('admin/asset-plan'); ?>">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Rencana Aset (Asset Plan)
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/asset_acquisition'); ?>">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Akuisisi Aset (Asset Acquisition)
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/asset_usage'); ?>">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Penggunaan Aset (Asset Usage)
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/asset_maintenance'); ?>">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Pemeliharaan Asset (Asset Maintenance)
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/asset_disposal'); ?>">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Penghapusan Asset (Asset Disposal)
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/calendar'); ?>">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Kalender Aset</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('admin/list'); ?>">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        List Pengaduan
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/assets'); ?>">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        List Asset
                    </a>
                </li>

                <li class="app-sidebar__heading">User Section</li>
                <li>
                    <a href="<?= base_url('user'); ?>">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        User Dashboard </a>
                </li>
                <li class="app-sidebar__heading">Account Section</li>
                <li>
                    <a href="<?= base_url('users/index'); ?>">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Account List </a>
                </li>

            </ul>
        </div>
    </div>
</div>