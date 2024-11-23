<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prisma PHP | Modern ORM for PHP</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }
    </style>
</head>

<body>
    <header class="bg-dark text-white py-3">
        <div class="container">
            <h1 class="text-center">Prisma PHP</h1>
            <p class="text-center">Modern ORM for PHP Projects</p>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">Prisma PHP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        <h2 class="text-center mb-4">Welcome to Prisma PHP</h2>
        <p class="text-center text-muted">A dynamic ORM solution for your PHP projects. Explore its features below:</p>

        <div class="row g-4 justify-content-center">
            <!-- What is Prisma PHP -->
            <div class="col-sm-6 col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">What is Prisma PHP?</div>
                    <div class="card-body">
                        <p>Prisma PHP is a modern Object-Relational Mapping (ORM) tool that simplifies database interactions for PHP developers. It supports efficient queries, CRUD operations, and relational mapping, making it easier to build scalable applications.</p>
                    </div>
                </div>
            </div>

            <!-- User Management -->
            <div class="col-sm-6 col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">User Management</div>
                    <div class="card-body">
                        <p>Manage users seamlessly using the UserService and AuthService. Features include:</p>
                        <ul>
                            <li>View user details</li>
                            <li>Update user information</li>
                            <li>Role-based access management</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Security with JWT -->
            <div class="col-sm-6 col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark text-center">Security</div>
                    <div class="card-body">
                        <p>Ensure secure access with JWT authentication. Authenticate users and protect your API endpoints with ease.</p>
                    </div>
                </div>
            </div>

            <!-- Prisma Services -->
            <div class="col-sm-6 col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-info text-white text-center">Prisma Services</div>
                    <div class="card-body">
                        <p>Prisma integrates seamlessly with your database. Use services like:</p>
                        <ul>
                            <li>Efficient query building</li>
                            <li>Customizable data models</li>
                            <li>Role and user management</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white py-3">
        <div class="container text-center">
            <p class="mb-1">&copy; 2024 ChyDev Network. All rights reserved.</p>
            <p class="small">Built with ❤️ using PHP and Bootstrap.</p>
        </div>
    </footer>
</body>

</html>