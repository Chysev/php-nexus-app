<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-sm text-center" style="max-width: 500px; width: 100%;">
            <div class="card-body">
                <img src="https://via.placeholder.com/100" alt="User Avatar" class="rounded-circle mb-3" id="avatar">
                <h2 class="h5" id="name">error rendering name</h2>
                <p class="text-muted mb-4" id="email">error rendering email</p>
                <button id="logout" class="btn btn-danger btn-sm">Logout</button>
                <button class="btn btn-primary btn-sm">
                    <a href="/settings" class="text-white text-decoration-none">Settings</a>
                </button>

            </div>
        </div>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Success</h5>
                </div>
                <div class="modal-body">
                    You have been logged out successfully! Redirecting to login page...
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const clearCookie = (name) => {
            document.cookie = `${name}=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC; secure; samesite=Strict`;
        };

        axios.get('/api/session')
            .then(response => {
                if (response.data.authenticated) {
                    const user = response.data.user;
                    document.getElementById('name').textContent = user.name;
                    document.getElementById('email').textContent = user.email;
                    if (user.avatar) {
                        document.getElementById('avatar').src = user.avatar;
                    }
                } else {
                    window.location.href = '/login';
                }
            })
            .catch(() => {
                window.location.href = '/login';
            });


        document.getElementById('logout').addEventListener('click', () => {
            clearCookie('auth_token');

            const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();

            setTimeout(() => {
                window.location.href = '/login';
            }, 2000);
        });
    </script>
</body>

</html>