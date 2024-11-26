<template>
    <main
        class="d-flex flex-column gap-5 align-items-center justify-content-center p-4 mt-5"
        style="max-width: 1500px"
    >
        <div class="table-responsive shadow rounded-3 bg-white p-4 w-75">
            <table class="table align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="fw-semibold text-muted">Role Name</th>
                        <th class="text-center fw-semibold text-muted">Create</th>
                        <th class="text-center fw-semibold text-muted">View</th>
                        <th class="text-center fw-semibold text-muted">Update</th>
                        <th class="text-center fw-semibold text-muted">Suspended</th>
                        <th class="text-center fw-semibold text-muted">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="role in roles" :key="role.id" class="hover-row">
                        <td class="text-dark fw-bold">{{ role.role }}</td>
                        <td class="text-center">
                            <input
                                type="checkbox"
                                class="form-check-input form-check-primary"
                            />
                        </td>
                        <td class="text-center">
                            <input
                                type="checkbox"
                                class="form-check-input form-check-primary"
                            />
                        </td>
                        <td class="text-center">
                            <input
                                type="checkbox"
                                class="form-check-input form-check-primary"
                            />
                        </td>
                        <td class="text-center">
                            <input
                                type="checkbox"
                                class="form-check-input form-check-primary"
                            />
                        </td>
                        <td class="text-center">
                            <input
                                type="checkbox"
                                class="form-check-input form-check-primary"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <router-link class="btn btn-primary" to="/roles/add">
            <i class="bi bi-plus-lg me-1"></i>
            Add New Role
        </router-link>
    </main>
</template>

<script>
import api from "../api/axios.js";
export default {
    data() {
        return {
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
        this.fetchRoles();
    },
    methods: {
        async fetchRoles() {
            try {
                const { data } = await api.get("/users");
                this.roles = data.roles;
            } catch (error) {
                console.error("Error fetching roles:", error);
                alert("Failed to load roles.");
            }
        },
    },
};
</script>
<style lang="scss" scoped>
.table {
    font-size: 15px;
    border-collapse: collapse;
    width: 100%;
    color: #333;
}

.table thead {
    background-color: #f8f9fa;
    font-size: 16px;
    font-weight: bold;
}

.table tbody tr {
    background-color: white;
    transition: background-color 0.2s ease-in-out;
}

.table tbody tr:not(:last-child) td {
    border-bottom: 1px solid #dee2e6; /* Adds a line below every td except for the last row */
}

.table tbody tr:hover {
    background-color: #f1f1f1;
}

.table td,
.table th {
    text-align: center;
    padding: 0.75rem;
}

.table td:first-child,
.table th:first-child {
    text-align: left;
    padding-left: 1.5rem;
}
</style>
