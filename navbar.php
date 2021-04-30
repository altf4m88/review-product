<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="#">App</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor03">
            <ul class="navbar-nav mr-auto align-items-center">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">Home</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Data</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="?menu=user">User Data</a>
                    <a class="dropdown-item" href="?menu=type">Product Type</a>
                    <a class="dropdown-item" href="?menu=product">Products</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="btn btn-sm btn-outline-danger rounded" href="logout.php">Logout</a>
            </li>
            </ul>
        </div>
    </div>
</nav>