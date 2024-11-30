<template>
    <div class="d-flex align-items-start">
        <Sidebar />
        <main
            class="d-flex flex-column gap-5 align-items-center justify-content-center p-4 mt-5"
        >
            <div
                class="d-flex flex-column align-items-center w-75 justify-content-center"
            >
                <!-- Role name input form with alert -->
                <div
                    v-if="overnaming"
                    class="alert alert-warning w-100"
                    role="alert"
                >
                    {{ overnaming }}
                </div>

                <form @submit.prevent="addRole" class="w-100">
                    <div class="d-flex gap-2 mb-3">
                        <input
                            v-model="role"
                            type="text"
                            class="form-control py-2 px-4 rounded-2"
                            name="role"
                            placeholder="Enter new role name"
                        />
                        <button class="btn btn-primary rounded-2" type="submit">
                            Submit
                        </button>
                    </div>
                </form>

                <!-- Roles and Permissions Table -->
                <div
                    class="table-responsive shadow rounded-3 bg-white p-4 w-100"
                >
                    <table class="table align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="fw-semibold text-muted">
                                    Role Name
                                </th>
                                <th
                                    v-for="permission in permissions"
                                    :key="permission.id"
                                    class="text-start fw-semibold text-muted"
                                >
                                    {{ permission.permissions }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="role in roles" :key="role.id">
                                <td>{{ role.role }}</td>
                                <td
                                    v-for="permission in permissions"
                                    :key="permission.id"
                                >
                                    <input
                                        class="form-check-input form-check-primary"
                                        type="checkbox"
                                        :checked="
                                            role.permissions.some(
                                                (p) => p.id === permission.id
                                            )
                                        "
                                        @change="
                                            updateRolePermission(
                                                role.id,
                                                permission.id,
                                                $event.target.checked
                                            )
                                        "
                                    />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
    name: "ManageRole",
    data() {
        return {
            permissions: [],
            roles: [],
            role: "",
            overnaming: "",
        };
    },
    mounted() {
        this.fetchPermissionsAndRoles();
    },
    methods: {
        async addRole() {
            try {
                await api.post("/roles/add", {
                    role: this.role,
                });
                this.role = "";
                await this.fetchPermissionsAndRoles();
            } catch (error) {
                this.overnaming =
                    "Role name already exists or something went wrong. Please try again!";
                setTimeout(() => {
                    this.overnaming = "";
                }, 5000);
                this.role = "";
            }
        },
        async fetchPermissionsAndRoles() {
            try {
                const { data } = await api.get("/permissions-and-roles");
                this.roles = data.roles;
                this.permissions = data.permissions;
            } catch (error) {
                console.error("Error fetching roles and permissions:", error);
                alert("Failed to load roles and permissions.");
            }
        },
        async updateRolePermission(roleId, permissionId, isChecked) {
            try {
                const role = this.roles.find((r) => r.id === roleId);
                let updatedPermissions = role.permissions.map((p) => p.id);

                if (isChecked) {
                    updatedPermissions.push(permissionId);
                } else {
                    updatedPermissions = updatedPermissions.filter(
                        (id) => id !== permissionId
                    );
                }

                // Send update request to the server
                await api.post(`/roles/${roleId}/permissions`, {
                    permissions: updatedPermissions,
                });

                // Update the local role object
                this.roles = this.roles.map((r) =>
                    r.id === roleId
                        ? {
                              ...r,
                              permissions: this.permissions.filter((p) =>
                                  updatedPermissions.includes(p.id)
                              ),
                          }
                        : r
                );
            } catch (error) {
                console.error("Error updating role permission:", error);
                alert("Failed to update role permissions.");
            }
        },
    },
};
</script>

<style scoped>
/* Styling for the main container */
main {
    display: flex;
    flex-direction: column;
    gap: 40px;
    align-items: center;
    justify-content: center;
    padding: 20px;
    margin-top: 50px;
}

/* Styling for form inputs */
.form-control {
    border-radius: 10px;
}

.btn {
    border-radius: 10px;
}

/* Styling for the table */
.table-responsive {
    max-width: 100%;
}

.table th {
    text-align: left;
}

.table td {
    vertical-align: middle;
}

.form-check-input {
    margin-left: 5px;
}

/* Alerts */
.alert {
    margin-bottom: 20px;
    width: 100%;
}

/* Ensuring responsiveness */
@media (max-width: 768px) {
    main {
        padding: 10px;
    }

    .table-responsive {
        width: 100%;
    }
}
</style>
