<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-sm" style="max-width: 400px; width: 100%;">
            <div class="card-body">
                <h2 class="text-center mb-4">Login</h2>

                <form id="loginForm">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <p class="text-center mt-3 mb-0">
                    Don't have an account? <a href="/register" class="text-primary">Register</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Logged in successfully! Redirecting...
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="errorModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="errorModalMessage">
                    <!-- Error message will be inserted here -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const setCookie = (name, value, options = {}) => {
            let cookieString = `${encodeURIComponent(name)}=${encodeURIComponent(value)}`;
            if (options.expires) {
                const expires = new Date(options.expires);
                cookieString += `; expires=${expires.toUTCString()}`;
            }
            if (options.path) cookieString += `; path=${options.path}`;
            if (options.secure) cookieString += `; secure`;
            if (options.sameSite) cookieString += `; samesite=${options.sameSite}`;
            document.cookie = cookieString;
        };

        axios.get('/api/session')
            .then(response => {
                console.log('Session response:', response.data);
                if (response.data.authenticated) {
                    window.location.href = '/dashboard';
                }
            })
            .catch(error => console.error('Session check failed:', error));

        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const response = await axios.post('/api/login', {
                email: email,
                password: password
            });

            if (response.data.success && response.data.token) {
                setCookie('auth_token', response.data.token, {
                    path: '/',
                    secure: true,
                    sameSite: 'Strict',
                    expires: new Date(Date.now() + 24 * 60 * 60 * 1000) // 1 day
                });

                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();

                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 2000);
            } else {

                const errorMessage = response?.data?.error

                document.getElementById('errorModalMessage').textContent = errorMessage;

                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            }
        });
    </script>
</body>

</html>