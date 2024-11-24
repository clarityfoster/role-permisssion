<template>
    <div>
        <main class="p-4">
            <div class="d-flex justify-content-between align-items-center mb-5">
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
                <button class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>
                    Add User
                </button>
            </div>
            <table class="table custom-table table-hover align-middle shadow">
                <thead class="table-light">
                    <tr>
                        <th class="text-muted fw-normal">Id</th>
                        <th class="text-muted fw-normal">User Name</th>
                        <th class="text-muted fw-normal">Email</th>
                        <th class="text-muted fw-normal">Role</th>
                        <th class="text-muted fw-normal">Change Role</th>
                        <th class="text-muted fw-normal">Suspended</th>
                        <th class="text-muted fw-normal">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td class="text-dark fw-normal">{{ user.id }}</td>
                        <td class="text-dark fw-semibold">{{ user.name }}</td>
                        <td class="text-muted">{{ user.email }}</td>
                        <td class="text-muted">
                            <span :class="getBadgeClass(user.role.id)" class="badge">
                                {{ user.role.role }}
                            </span>
                        </td>
                        <td class="dropdown">
                            <a
                                class="btn btn-outline-secondary dropdown-toggle"
                                href="#"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                Change Role
                            </a>

                            <ul class="dropdown-menu">
                                <li v-for="role in roles" :key="role.id">
                                    <a class="dropdown-item" href="#">
                                        {{ role.role }}
                                    </a>
                                </li>
                            </ul>
                        </td>

                        <td class="text-muted">
                            <button class="btn btn-outline-warning btn-sm">
                                Suspended
                            </button>
                        </td>
                        <td class="text-muted">
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-trash3-fill"></i>
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
                1: 'bg-secondary',
                2: 'bg-success',
                3: 'bg-primary',
                4: 'bg-info',
                5: 'bg-warning',
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
        getBadgeClass(role_id) {
            return this.roleColorMapping[role_id] || 'bg-secondary';
        },
    },
};
</script>

<style lang="scss" scoped>
.table {
    border-radius: 25px;
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
