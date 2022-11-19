<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="./">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!-- End Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#spaces-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Spaces</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="spaces-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="add-space">
                        <i class="bi bi-upload"></i><span>Add a Space</span>
                    </a>
                </li>
                <li>
                    <a href="my-spaces">
                        <i class="bi bi-upload"></i><span>My Spaces</span>
                    </a>
                </li>
            </ul>
        </li>
            <!-- End Profile Page Nav -->
        <!-- this will be a logout btn -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="./logout">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Logout</span>
            </a>
        </li>
        <!-- End Login Page Nav -->
    </ul>
</aside>