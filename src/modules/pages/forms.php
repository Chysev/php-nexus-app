<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Forms</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Prisma PHP</h1>

        <!-- Create User Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="h5">Create User</h2>
            </div>
            <div class="card-body">
                <form id="createUserForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control" id="role" name="role_id" required>
                            <!-- Roles will be dynamically populated -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </form>
            </div>
        </div>

        <!-- Create Role Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="h5">Create Role</h2>
            </div>
            <div class="card-body">
                <form id="createRoleForm">
                    <div class="mb-3">
                        <label for="roleName" class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="roleName" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-success">Create Role</button>
                </form>
            </div>
        </div>

        <!-- User Table -->
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="h5">Users</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="userTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- Role Table -->
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="h5">Roles</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="roleTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editUserForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_user_id" name="id">
                    <div class="mb-3">
                        <label for="edit_user_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit_user_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_user_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_user_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_user_role" class="form-label">Role</label>
                        <select class="form-control" id="edit_user_role" name="role_id">
                            <!-- Roles will be dynamically populated -->
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Role Modal -->
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editRoleForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_role_id" name="id">
                    <div class="mb-3">
                        <label for="edit_role_name" class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="edit_role_name" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Alert Modal -->
    <div class="modal fade" id="alertModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="alertModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="confirmModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmModalConfirm" class="btn btn-danger">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Utility function to safely attach event listeners
            const attachEvent = (selector, event, callback) => {
                const element = document.querySelector(selector);
                if (element) {
                    element.addEventListener(event, callback);
                }
            };

            // Fetch Users and Roles
            const fetchUsers = async () => {
                try {
                    const [usersRes, rolesRes] = await Promise.all([
                        axios.get('/api/users'),
                        axios.get('/api/roles'),
                    ]);
                    populateUserTable(usersRes.data, rolesRes.data);
                    populateRoleDropdown(rolesRes.data);
                } catch (error) {
                    showAlert('Error', 'Failed to fetch users or roles.');
                }
            };

            const fetchRoles = async () => {
                try {
                    const rolesRes = await axios.get('/api/roles');
                    populateRoleTable(rolesRes.data);
                } catch (error) {
                    showAlert('Error', 'Failed to fetch roles.');
                }
            };

            const populateUserTable = (users, roles) => {
                const tbody = document.querySelector('#userTable tbody');
                if (!tbody) return;
                tbody.innerHTML = users
                    .map((user) => {
                        const role = roles.find((r) => r.id === user.role_id) || {
                            name: 'No Role',
                        };
                        return `
            <tr>
                <td>${user.id}</td>
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>${role.name}</td>
                <td>
                    <button class="btn btn-warning btn-sm editUser" data-id="${user.id}" data-bs-toggle="modal" data-bs-target="#editUserModal">Edit</button>
                    <button class="btn btn-danger btn-sm deleteUser" data-id="${user.id}">Delete</button>
                </td>
            </tr>`;
                    })
                    .join('');
            };

            const populateRoleDropdown = (roles) => {
                const dropdown = document.querySelector('#role');
                if (!dropdown) return;
                dropdown.innerHTML = roles
                    .map((role) => `<option value="${role.id}">${role.name}</option>`)
                    .join('');
            };

            const populateRoleTable = (roles) => {
                const tbody = document.querySelector('#roleTable tbody');
                if (!tbody) return;
                tbody.innerHTML = roles
                    .map(
                        (role) => `
            <tr>
                <td>${role.id}</td>
                <td>${role.name}</td>
                <td>
                    <button class="btn btn-warning btn-sm editRole" data-id="${role.id}" data-bs-toggle="modal" data-bs-target="#editRoleModal">Edit</button>
                    <button class="btn btn-danger btn-sm deleteRole" data-id="${role.id}">Delete</button>
                </td>
            </tr>`
                    )
                    .join('');
            };

            const showAlert = (title, message) => {
                document.getElementById('alertModalTitle').innerText = title;
                document.getElementById('alertModalBody').innerText = message;
                const alertModal = new bootstrap.Modal(
                    document.getElementById('alertModal')
                );
                alertModal.show();
            };

            // Create User
            attachEvent('#createUserForm', 'submit', async (e) => {
                e.preventDefault();
                const data = Object.fromEntries(new FormData(e.target).entries());
                try {
                    await axios.post('/api/users', data);
                    showAlert('Success', 'User created successfully!');
                    fetchUsers();
                    e.target.reset(); // Clear the form
                } catch {
                    showAlert('Error', 'Failed to create user.');
                }
            });

            // Edit User
            document.addEventListener('click', async (e) => {
                if (e.target.classList.contains('editUser')) {
                    const userId = e.target.dataset.id;

                    try {
                        const response = await axios.get(`/api/user/${userId}`);
                        const user = response.data;

                        // Populate the modal fields with fetched user data
                        document.querySelector('#edit_user_id').value = user.id;
                        document.querySelector('#edit_user_name').value = user.name;
                        document.querySelector('#edit_user_email').value = user.email;

                        // Ensure the role dropdown is populated before setting its value
                        const rolesResponse = await axios.get('/api/roles');
                        const roles = rolesResponse.data;
                        const roleDropdown = document.querySelector('#edit_user_role');

                        // Clear and repopulate the dropdown options
                        roleDropdown.innerHTML = roles
                            .map((role) => `<option value="${role.id}">${role.name}</option>`)
                            .join('');

                        // Set the current role
                        roleDropdown.value = user.role_id || '';
                    } catch (error) {
                        console.error('Error fetching user details:', error);
                        showAlert('Error', 'Failed to fetch user details.');
                    }
                }
            });

            attachEvent('#editUserForm', 'submit', async (e) => {
                e.preventDefault();
                const userId = document.querySelector('#edit_user_id').value;
                const data = Object.fromEntries(new FormData(e.target).entries());
                try {
                    await axios.patch(`/api/users/${userId}`, data);
                    const editUserModal = bootstrap.Modal.getInstance(
                        document.getElementById('editUserModal')
                    );
                    if (editUserModal) editUserModal.hide();
                    showAlert('Success', 'User updated successfully!');
                    fetchUsers();
                } catch {
                    showAlert('Error', 'Failed to update user.');
                }
            });

            // Create Role
            attachEvent('#createRoleForm', 'submit', async (e) => {
                e.preventDefault();
                const data = Object.fromEntries(new FormData(e.target).entries());
                try {
                    await axios.post('/api/roles', data);
                    showAlert('Success', 'Role created successfully!');
                    fetchRoles();
                    e.target.reset(); // Clear the form
                } catch {
                    showAlert('Error', 'Failed to create role.');
                }
            });

            // Edit Role
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('editRole')) {
                    const roleId = e.target.dataset.id;
                    axios
                        .get(`/api/role/${roleId}`)
                        .then((response) => {
                            const role = response.data;
                            document.querySelector('#edit_role_id').value = role.id;
                            document.querySelector('#edit_role_name').value = role.name;
                        })
                        .catch(() => showAlert('Error', 'Failed to fetch role details.'));
                }
            });

            attachEvent('#editRoleForm', 'submit', async (e) => {
                e.preventDefault();
                const roleId = document.querySelector('#edit_role_id').value;
                const data = {
                    name: document.querySelector('#edit_role_name').value,
                };
                try {
                    await axios.patch(`/api/roles/${roleId}`, data);
                    const editRoleModal = bootstrap.Modal.getInstance(
                        document.getElementById('editRoleModal')
                    );
                    if (editRoleModal) editRoleModal.hide();
                    showAlert('Success', 'Role updated successfully!');
                    fetchRoles();
                } catch {
                    showAlert('Error', 'Failed to update role.');
                }
            });

            fetchUsers();
            fetchRoles();
        });
    </script>

</body>

</html>