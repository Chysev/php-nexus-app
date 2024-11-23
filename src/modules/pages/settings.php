<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-sm" style="max-width: 500px; width: 100%;">
            <div class="card-body">
                <h2 class="text-center mb-4">Edit Profile</h2>

                <form id="settingsForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                </form>

                <div class="alert alert-success mt-3 d-none" id="successMessage">Profile updated successfully!</div>
                <div class="alert alert-danger mt-3 d-none" id="errorMessage">Failed to update profile.</div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        let userId;

        const showAlert = (message, type = 'success') => {
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');

            if (type === 'success') {
                errorMessage.classList.add('d-none');
                successMessage.textContent = message;
                successMessage.classList.remove('d-none');
            } else {
                successMessage.classList.add('d-none');
                errorMessage.textContent = message;
                errorMessage.classList.remove('d-none');
            }

            setTimeout(() => {
                successMessage.classList.add('d-none');
                errorMessage.classList.add('d-none');
            }, 3000);
        };

        axios.get('/api/session')
            .then(response => {
                if (response.data.authenticated) {
                    const user = response.data.user;
                    userId = user.id;
                    document.getElementById('name').value = user.name;
                    document.getElementById('email').value = user.email;
                } else {
                    window.location.href = '/login';
                }
            })
            .catch(() => {
                window.location.href = '/login';
            });

        document.getElementById('settingsForm').addEventListener('submit', e => {
            e.preventDefault();

            const data = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value
            };

            axios.patch(`/api/user/${userId}`, data)
                .then(() => {
                    showAlert('Profile updated successfully!', 'success');
                })
                .catch(error => {
                    const errorMessage = error.response?.data?.error || 'Failed to update profile.';
                    showAlert(errorMessage, 'danger');
                });
        });
    </script>
</body>

</html>