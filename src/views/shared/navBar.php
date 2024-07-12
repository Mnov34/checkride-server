<?php
?>
<head>
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(19, 43, 64, 0.8);">
    <div class="container">
        <!--Logo-->
        <a class="navbar-brand" href="#">CHECKRIDE</a>
        <!--Toggle btn-->
        <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!--SideBar-->
        <div class="sidebar offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
             aria-labelledby="offcanvasNavbarLabel">
            <!--Sidebar Header-->
            <div class="offcanvas-header text-white border-bottom shadow-none">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">CHECKRIDE</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </div>

            <!--Sidebar Body-->
            <div class="text-white offcanvas-body d-flex flex-column flex-lg-row p-4 p-lg-0">
                <ul class="navbar-nav justify-content-center align-items-center fs-5 flex-grow-1 pe-3">
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="/bikes/">Bikes</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="/contact/">Contact</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="/admin/add-user/">Add user</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="/admin/">Admin home</a>
                    </li>
                </ul>
                <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-3">
                    <a href="/login.php"><img src="/public/assets/img/deconnexion.png" alt="disconnect button"></a>
                </div>
            </div>
        </div>
    </div>
</nav>