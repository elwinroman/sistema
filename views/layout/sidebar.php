<aside class="sidebar">
    <div class="top-sidebar">
        <!-- Top sidebar -->
    </div>
    <div class="menu-sidebar">
        <div class="menu-panel">
            <div class="menu-link" data-id="1">
                <i class="menu-icon zmdi zmdi-view-dashboard"></i>
                <span class="menu-label">Dashboard</span>
                <i class="menu-arrow zmdi zmdi-chevron-right"></i>
            </div>
            <div class="submenu-panel">
                <div class="submenu-link">
                    <i class="submenu-icon zmdi zmdi-circle"></i>
                    <span class="submenu-label">Subitem 1</span>
                </div>
                <div class="submenu-link">
                    <i class="submenu-icon zmdi zmdi-circle"></i>
                    <span class="submenu-label">Subitem 2</span>
                </div>
            </div>
        </div>
        <!-- Gestión de oficina -->
        <div class="menu-panel">
            <div class="menu-link" data-id="2">
                <i class="menu-icon zmdi zmdi-account"></i>
                <span class="menu-label">Oficinas</span>
                <i class="menu-arrow zmdi zmdi-chevron-right"></i>
            </div>
            <div class="submenu-panel">
                <div class="submenu-link">
                    <i class="submenu-icon zmdi zmdi-circle"></i>
                    <a class="submenu-label" href="<?=URL_BASE?>oficina/new">Crear Oficina</a>
                </div>
                <div class="submenu-link">
                    <i class="submenu-icon zmdi zmdi-circle"></i>
                    <a class="submenu-label" href="<?=URL_BASE?>oficina/list">Lista Oficina</a>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-sidebar">
        <!-- Bottom sidebar -->
    </div>
</aside>
<main>
    <section class="content">
        <!-- render views -->