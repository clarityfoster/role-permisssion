<template>
    <div class="d-flex">
        <Sidebar />
        <main :key="refreshKey" class="p-4">
            <div class="d-flex justify-content-between align-items-center mb-4" style="min-width: 1400px;">
                <div class="input-group w-50">
                    <input
                        v-model="searchQuery"
                        @keyup.enter="search"
                        name="search"
                        type="text"
                        class="form-control py-2 px-4 rounded-5"
                        placeholder="Search users..."
                    />
                    <button
                        @click="searchQuery.trim() && search()"
                        class="btn btn-primary rounded-circle ms-2"
                    >
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <div class="d-flex gap-2">
                    <div
                        @click="view(user.id)"
                        class="d-flex align-items-center justify-content-center rounded-circle bg-danger"
                        style="height: 43px; width: 43px; cursor: pointer"
                    >
                        <span class="text-white" style="font-size: 18px">
                            {{ user.name[0] }}
                        </span>
                    </div>
                    <div
                        class="text-dark d-flex flex-column align-items-start"
                        style="cursor: pointer"
                    >
                        <span @click="view(user.id)" v-if="user">{{
                            user.name
                        }}</span>
                        <small @click="view(user.id)" v-if="user">{{
                            user.email
                        }}</small>
                    </div>
                </div>
            </div>
            <div
                v-if="userDeleteAlert"
                class="alert alert-danger w-50"
                role="alert"
            >
                {{ userDeleteAlert }}
            </div>
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h3>Users List</h3>
                <router-link
                    v-if="hasPermissions('user-create')"
                    class="btn btn-primary"
                    to="/users/add"
                >
                    <i class="bi bi-plus-lg me-1"></i>
                    Add User
                </router-link>
            </div>
            <table v-if="users.length > 0" class="table custom-table align-middle shadow">
                <thead class="table-light">
                    <tr>
                        <th class="text-muted fw-normal">Id</th>
                        <th></th>
                        <th class="text-muted fw-normal">User Name</th>
                        <th class="text-muted fw-normal">Email</th>
                        <th class="text-muted fw-normal">Phone</th>
                        <th class="text-muted fw-normal">Address</th>
                        <th class="text-muted fw-normal">Role</th>
                        <th class="text-muted fw-normal">Actions</th>
                        <th
                            v-if="hasPermissions('user-suspended')"
                            class="text-muted fw-normal"
                        >
                            Status
                        </th>
                        <th
                            v-if="hasPermissions('user-delete')"
                            class="text-muted fw-normal"
                        >
                            Delete
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr :class="{'table-active': user.id === loggedInUser.id}" v-for="user in users" :key="user.id">
                        <td class="text-dark fw-normal">{{ user.id }}</td>
                        <td>
                            <div
                                class="d-flex align-items-center justify-content-center rounded-circle bg-danger"
                                style="height: 50px; width: 50px"
                            >
                                <span
                                    class="text-white"
                                    style="font-size: 18px"
                                    >{{ user.name[0] }}</span
                                >
                            </div>
                        </td>
                        <td class="text-dark fw-semibold">{{ user.name }}</td>
                        <td class="text-muted">{{ user.email }}</td>
                        <td class="text-muted">{{ user.phone }}</td>
                        <td class="text-muted">{{ user.address }}</td>
                        <td>
                            <span
                                :class="getBadgeClass(user.role_id)"
                                class="badge"
                            >
                                {{ user.role }}
                            </span>
                        </td>
                        <td class="text-muted">
                            <div
                                class="btn-group"
                                role="group"
                                aria-label="Basic outlined example"
                            >
                                <button
                                    v-if="hasPermissions('change-role')"
                                    type="button"
                                    class="btn btn-outline-info dropdown"
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
                                    v-if="hasPermissions('user-update')"
                                    @click="editUser(user.id)"
                                    class="btn btn-outline-secondary"
                                >
                                    Edit
                                </button>
                                <button
                                    v-if="hasPermissions('user-read')"
                                    @click="view(user.id)"
                                    class="btn btn-outline-primary"
                                >
                                    View
                                </button>
                            </div>
                        </td>
                        <td
                            v-if="
                                hasPermissions('user-suspended') &&
                                user.id !== loggedInUser.id
                            "
                            class="text-muted"
                        >
                            <button
                                v-if="user.suspended"
                                type="button"
                                class="btn btn-warning text-white"
                                @click="unsuspendUser(user.id)"
                            >
                                Unsuspend
                            </button>
                            <button
                                v-else
                                type="button"
                                class="btn btn-outline-warning"
                                @click="suspendUser(user.id)"
                            >
                                Suspend
                            </button>
                        </td>
                        <td
                            v-if="hasPermissions('user-delete')"
                            class="text-muted"
                        >
                            <button
                                v-if="user.id !== loggedInUser.id"
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
            <div v-else class="d-flex align-items-center justify-content-center" style="height: 500px;">
                <h5>No users found!</h5>
            </div>
        </main>
    </div>
</template>

<script>
import api from "../api/axios.js";
import Sidebar from "./Sidebar.vue";

export default {
    components: {
        Sidebar,
    },
    name: "Dashboard",
    data() {
        return {
            user: JSON.parse(localStorage.getItem("user")),
            users: [],
            roles: [],
            role_id: [],
            userDeleteAlert: "",
            refreshKey: 0,
            searchQuery: "",
        };
    },
    mounted() {
        this.fetchUser();
    },
    watch: {
        user: {
            deep: true,
            handler() {},
        },
        searchQuery(newSearchKey) {
            if (!newSearchKey.trim()) {
                this.fetchUser();
            }
        },
    },
    computed: {
        loggedInUser() {
            return this.user;
        },
    },
    methods: {
        async search() {
            const search = {
                key: this.searchQuery,
            };
            try {
                const { data } = await api.post("/users/search", search);
                this.users = data.users;
            } catch (error) {
                console.error(error);
            }
        },
        refreshView() {
            this.refreshKey++;
        },
        hasPermissions(permission) {
            if (!this.user || !this.user.permissions) {
                return false;
            }
            return this.user.permissions.includes(permission);
        },
        async fetchUser() {
            const token = localStorage.getItem("token");
            if (!token) {
                console.error("No token found. Please log in.");
                return;
            }
            try {
                const { data } = await api.get("/users");
                this.users = data.users;
                this.roles = data.roles;

                const role = this.roles.find(
                    (role) => role.id === this.user.role_id
                );
                if (role) {
                    const { data: permissionsData } = await api.get(
                        `/roles/${role.id}/permissions`
                    );
                    this.user.permissions = permissionsData.permissions || [];
                }
            } catch (error) {
                console.error("Error fetching user data:", error);
            }
        },
        async changeUserRole(userId, roleId) {
            try {
                await api.post(`/users/${userId}/change-role`, {
                    role_id: roleId,
                });

                if (userId === this.user.id) {
                    // Fetch new permissions for the updated role
                    const { data: permissionsData } = await api.get(
                        `/roles/${roleId}/permissions`
                    );
                    const updatedPermissions =
                        permissionsData.permissions || [];

                    // Trigger reactivity by updating the user object entirely
                    this.user = {
                        ...this.user,
                        role_id: roleId,
                        permissions: updatedPermissions,
                    };
                    localStorage.setItem("user", JSON.stringify(this.user));
                }

                // Refresh the user list
                this.fetchUser();
            } catch (error) {
                console.error("Error updating user role:", error);
            }
        },
        async deleteUser(userId) {
            if (this.user.id === userId) {
                console.error("You cannot delete yourself.");
                alert("You cannot delete yourself.");
                return;
            }
            try {
                await api.post(`/users/${userId}/delete`);
                this.users = this.users.filter((user) => user.id !== userId);
                this.userDeleteAlert = "User successfully deleted.";
                setTimeout(() => {
                    this.userDeleteAlert = "";
                }, 3000);
            } catch (error) {
                console.error("Error deleting user:", error);
            }
        },
        async suspendUser(userId) {
            if (this.user.id === userId) {
                console.error("You cannot suspend yourself.");
                alert("You cannot suspend yourself.");
                return;
            }
            try {
                await api.post(`/users/${userId}/suspend`);
                const user = this.users.find((u) => u.id == userId);
                if (user) {
                    user.suspended = true;
                }
            } catch (error) {
                console.error("Error suspending user:", error);
            }
        },
        async unsuspendUser(userId) {
            try {
                await api.post(`/users/${userId}/unsuspend`);
                const user = this.users.find((u) => u.id == userId);
                if (user) {
                    user.suspended = false;
                }
            } catch (error) {
                console.error("Error unsuspending user:", error);
            }
        },
        editUser(id) {
            this.$router.push({ name: "editUser", params: { id } });
        },
        view(id) {
            this.$router.push({ name: "view", params: { id } });
        },
        getBadgeClass(role_id) {
            const roleColorMapping = {
                1: "bg-info",
                2: "bg-success",
                3: "bg-warning",
                4: "bg-primary",
                5: "bg-danger",
            };
            return roleColorMapping[role_id] || "bg-secondary";
        },
    },
};
</script>

<style lang="scss" scoped>
.table-active {
    background-color: #f8f9fa !important; /* Light blue for highlight */
}
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

.table-hover tbody tr:hover {
    background-color: #f1f1f1;
}

.badge {
    padding: 6px 12px;
    font-size: 13px;
    border-radius: 12px;
    font-weight: 600;
    color: white;
}
</style>
