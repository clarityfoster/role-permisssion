<template>
    <div>
        <main class="p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="input-group w-50">
                    <input
                        type="text"
                        class="form-control py-2 px-4 rounded-5"
                        placeholder="Search"
                    />
                    <button class="btn btn-primary rounded-circle ms-2">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <div class="d-flex flex-column align-items-start">
                    <span v-if="auth_user">{{ auth_user.name }}</span>
                    <small v-if="auth_user">{{ auth_user.email }}</small>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h3>Users List</h3>
                <router-link class="btn btn-primary" to="/addUser">
                    <i class="bi bi-plus-lg me-1"></i>
                    Add User
                </router-link>
            </div>
            <table class="table custom-table table-hover align-middle shadow">
                <thead class="table-light">
                    <tr>
                        <th class="text-muted fw-normal">Id</th>
                        <th class="text-muted fw-normal">User Name</th>
                        <th class="text-muted fw-normal">Email</th>
                        <th class="text-muted fw-normal">Role</th>
                        <th class="text-muted fw-normal">Actions</th>
                        <th class="text-muted fw-normal">Suspened</th>
                        <th class="text-muted fw-normal">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td class="text-dark fw-normal">{{ user.id }}</td>
                        <td class="text-dark fw-semibold">{{ user.name }}</td>
                        <td class="text-muted">{{ user.email }}</td>
                        <td class="text-muted">
                            <span
                                :class="getBadgeClass(user.role.id)"
                                class="badge"
                            >
                                {{ user.role.role }}
                            </span>
                        </td>
                        <td class="text-muted">
                            <div
                                class="btn-group"
                                role="group"
                                aria-label="Basic outlined example"
                            >
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary dropdown"
                                >
                                    <div
                                        class="dropdown-toggle text-decoration-none"
                                        href="#"
                                        role="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                        Change Role
                                    </div>
                                    <ul class="dropdown-menu">
                                        <li
                                            v-for="role in roles"
                                            :key="role.id"
                                        >
                                            <button
                                                class="dropdown-item"
                                                @click="
                                                    changeUserRole(
                                                        user.id,
                                                        role.id
                                                    )
                                                "
                                            >
                                                {{ role.role }}
                                            </button>
                                        </li>
                                    </ul>
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-outline-info"
                                >
                                    Edit
                                </button>
                            </div>
                        </td>
                        <td class="text-muted">
                            <button
                                    type="button"
                                    class="btn btn-outline-warning"
                                >
                                    Suspended
                                </button>
                        </td>
                        <td class="text-muted">
                            <button
                                    type="button"
                                    class="btn btn-danger"
                                    @click="deleteUser(user.id)"
                                >
                                    Delete
                                </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </main>
    </div>
</template>

<script>
import api from "../api/axios.js";
export default {
    name: "Dashboard",
    data() {
        return {
            auth_user: null,
            users: [],
            roles: [],
            roleColorMapping: {
                1: "bg-secondary",
                2: "bg-success",
                3: "bg-primary",
                4: "bg-info",
                5: "bg-warning",
            },
        };
    },
    mounted() {
        this.fetchUser();
    },
    methods: {
        async fetchUser() {
            try {
                const { data } = await api.get("/dashboard");
                this.auth_user = data.auth_user;
                this.users = data.users;
                this.roles = data.roles;
                console.log(data);
            } catch (error) {
                console.error("Error fetching user data:", error);
            }
        },
        async changeUserRole(userId, roleId) {
            try {
                const {data} = await api.post(`/users/${userId}/change-role`,
                    {
                        role_id: roleId,
                    }
                );
                const updatedUser = data.user;

                const index = this.users.findIndex((user) => user.id === userId);
                if (index !== -1) {
                    this.users[index] = updatedUser;
                }
            } catch (error) {
                console.error("Error updating user role:", error);
                alert("Failed to update user role.");
            }
        },
        async deleteUser(userId) {
            try {
                await api.post(`/users/${userId}/delete`);
                this.users = this.users.filter(function(user) {
                    return user.id !== userId;
                })
            } catch (error) {
                console.error("Error deleting user:", error);
                alert("Failed to delete user.");
            }
        },
        getBadgeClass(role_id) {
            return this.roleColorMapping[role_id] || "bg-secondary";
        },
    },
};
</script>

<style lang="scss" scoped>
.table {
    border-radius: 15px;
    overflow: hidden;
    width: 100%;
}

.table td,
.table th {
    border: none;
    padding: 20px;
}

.table tbody tr {
    border-bottom: 1px solid #dee2e6;
}

.table td:nth-child(1),
.table th:nth-child(1) {
    padding-left: 20px;
    padding-top: 20px;
}

.table td:nth-child(2),
.table th:nth-child(2) {
    padding-left: 25px;
}
.table td:nth-child(7),
.table th:nth-child(7) {
    padding-right: 20px;
}

.table thead {
    background-color: #f8f9fa;
}

.table-hover tbody tr:hover {
    background-color: #f1f1f1;
}

.badge {
    padding: 6px 12px;
    font-size: 13px;
    border-radius: 12px;
    display: inline-block;
    text-align: center;
    font-weight: 600;
    color: white;
}
</style>
