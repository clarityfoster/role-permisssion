<template>
    <div class="d-flex">
        <Sidebar />
        <main class="p-4">
            <div
                class="d-flex justify-content-between align-items-center mb-4"
                style="min-width: 1400px"
            >
                <div class="input-group w-50">
                    <input
                        v-model="searchQuery"
                        @keyup.enter="search"
                        name="search"
                        type="text"
                        class="form-control py-2 px-4 rounded-5"
                        placeholder="Search..."
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
                        <span @click="view(user.id)" v-if="user">
                            {{ user.name }}
                        </span>
                        <small @click="view(user.id)" v-if="user">
                            {{ user.email }}
                        </small>
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
                <div class="d-flex align-items-center justify-content-center">
                    <div class="dropdown me-2">
                        <button
                            class="btn btn-primary dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a
                                    href="#"
                                    class="dropdown-item"
                                    @click.prevent="fetchUser()"
                                >
                                    All
                                </a>
                            </li>
                            <li v-for="role in roles" :key="role.id">
                                <a
                                    href="#"
                                    class="dropdown-item"
                                    @click.prevent="
                                        filterByRole({ roleId: role.id })
                                    "
                                >
                                    {{ role.role }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="dropdown me-2">
                        <button
                            class="btn btn-primary dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <i class="bi bi-filter"></i> Sorting
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a
                                    href="#"
                                    class="dropdown-item"
                                    @click.prevent="sorting('default')"
                                >
                                    <i class="bi bi-sort-down"></i> Default
                                    Sorting
                                </a>
                                <a
                                    href="#"
                                    class="dropdown-item"
                                    @click.prevent="sorting('asc')"
                                >
                                    <i class="bi bi-sort-alpha-down"></i>
                                    Sort by <b>A</b> to <b>Z</b>
                                </a>
                                <a
                                    href="#"
                                    class="dropdown-item"
                                    @click.prevent="sorting('desc')"
                                >
                                    <i class="bi bi-sort-alpha-down-alt"></i>
                                    Sort by <b>Z</b> to <b>A</b>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <router-link
                        v-if="hasPermissions('user-create')"
                        class="btn btn-primary"
                        to="/users/add"
                    >
                        <i class="bi bi-plus-lg me-1"></i>
                        Add User
                    </router-link>
                </div>
            </div>
            <table
                v-if="users.length > 0"
                class="table custom-table align-middle shadow"
            >
                <thead class="table-light">
                    <tr>
                        <th class="text-white fw-normal bg-primary">Id</th>
                        <th class="text-white fw-normal bg-primary"></th>
                        <th class="text-white fw-normal bg-primary">
                            User Name
                        </th>
                        <th class="text-white fw-normal bg-primary">Email</th>
                        <th class="text-white fw-normal bg-primary">Phone</th>
                        <th class="text-white fw-normal bg-primary">Address</th>
                        <th class="text-white fw-normal bg-primary">Role</th>
                        <th class="text-white fw-normal bg-primary">Actions</th>
                        <th
                            v-if="hasPermissions('user-suspended')"
                            class="text-white fw-normal bg-primary"
                        >
                            Status
                        </th>
                        <th
                            v-if="hasPermissions('user-delete')"
                            class="text-white fw-normal bg-primary"
                        >
                            Delete
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td
                            :class="
                                user.id === loggedInUser.id
                                    ? 'text-dark'
                                    : 'text-secondary'
                            "
                        >
                            {{ user.id }}
                        </td>
                        <td>
                            <div
                                class="d-flex align-items-center justify-content-center rounded-circle bg-danger"
                                style="height: 50px; width: 50px"
                            >
                                <span
                                    class="text-white"
                                    style="font-size: 18px"
                                >
                                    {{ user.name[0] }}
                                </span>
                            </div>
                        </td>
                        <td
                            class="fw-semibold"
                            :class="
                                user.id === loggedInUser.id
                                    ? 'text-dark'
                                    : 'text-secondary'
                            "
                        >
                            {{ user.name }}
                            <small v-if="user.id === loggedInUser.id"
                                >(Me)</small
                            >
                        </td>
                        <td
                            :class="
                                user.id === loggedInUser.id
                                    ? 'text-dark'
                                    : 'text-secondary'
                            "
                        >
                            {{ user.email }}
                        </td>
                        <td
                            :class="
                                user.id === loggedInUser.id
                                    ? 'text-dark'
                                    : 'text-secondary'
                            "
                        >
                            {{ user.phone }}
                        </td>
                        <td
                            :class="
                                user.id === loggedInUser.id
                                    ? 'text-dark'
                                    : 'text-secondary'
                            "
                        >
                            {{ user.address }}
                        </td>
                        <td>
                            <span
                                :class="getBadgeClass(user.role_id)"
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
            <div
               v-if="users.length === 0"
                class="d-flex align-items-center justify-content-center"
                style="height: 500px"
            >
                <h5>No users found!</h5>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <button
                    v-if="users.length > 0"
                    class="btn btn-primary"
                    :disabled="pagination.current_page === 1"
                    @click="fetchUser(pagination.current_page - 1)"
                >
                    <i class="bi bi-arrow-left-short"></i>
                </button>
                <span v-if="users.length > 0">
                    Page {{ pagination.current_page }} of
                    {{ pagination.last_page }}
                </span>
                <button
                    v-if="users.length > 0"
                    class="btn btn-primary"
                    :disabled="pagination.current_page === pagination.last_page"
                    @click="fetchUser(pagination.current_page + 1)"
                >
                    <i class="bi bi-arrow-right-short"></i>
                </button>
            </div>
        </main>
    </div>
</template>

<script>
import api from "../api/axios.js";
import Sidebar from "./Sidebar.vue";
import { mapActions, mapState, mapGetters } from "vuex";

export default {
    components: {
        Sidebar,
    },
    name: "Dashboard",
    data() {
        return {
            user: JSON.parse(localStorage.getItem("user")),
            userDeleteAlert: "",
            searchQuery: "",
        };
    },
    mounted() {
        this.fetchUser();
    },
    watch: {
        searchQuery(newSearchKey) {
            if (!newSearchKey.trim()) {
                this.fetchUser();
            }
        },
    },
    computed: {
        ...mapGetters(['hasPermissions']),
        ...mapState({
            users: (state) => state.users || [],
            roles: (state) => state.roles || [],
            permissions: (state) => state.permissions || [],
            pagination: (state) => state.pagination || {},
        }),
        loggedInUser() {
            return this.user || {};
        },
    },
    methods: {
        ...mapActions([
            "fetchUser",
            "search",
            "filterByRole",
        ]),
        async search() {
            await this.$store.dispatch("search", this.searchQuery);
        },
        async sorting(order) {
            try {
                if (order === "asc") {
                    this.users.sort((a, b) => a.name.localeCompare(b.name));
                } else if (order === "desc") {
                    this.users.sort((a, b) => b.name.localeCompare(a.name));
                } else {
                    this.fetchUser();
                }
            } catch (e) {
                console.error("Sorting error:", e);
            }
        },
        async changeUserRole(userId, roleId) {
            try {
                await api.post(`/users/${userId}/change-role`, {
                    role_id: roleId,
                });

                if (userId === this.user.id) {
                    const { data: permissionsData } = await api.get(
                        `/roles/${roleId}/permissions`
                    );
                    const updatedPermissions =
                        permissionsData.permissions || [];

                    this.user = {
                        ...this.user,
                        role_id: roleId,
                        permissions: updatedPermissions,
                    };
                    localStorage.setItem("user", JSON.stringify(this.user));
                }

                this.fetchUser();
            } catch (error) {
                console.error("Error updating user role:", error);
            }
        },
        async deleteUser(userId) {
            if (this.user.id === userId) {
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
                1: "bg-primary",
                2: "bg-warning",
                3: "bg-danger",
                4: "bg-info",
                5: "bg-success",
            };
            return roleColorMapping[role_id] || "bg-secondary";
        },
    },
};
</script>

<style lang="scss" scoped>
.table-active {
    background-color: #f8f9fa !important;
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
