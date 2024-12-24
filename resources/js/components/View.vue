<template>
    <div
        class="d-flex justify-content-start align-items-start gap-5"
        style="height: 100vh"
    >
        <Sidebar />
        <div class="container" style="max-width: 500px">
            <div class="card shadow rounded-4 mt-5">
                <div class="card-body">
                    <div
                        class="d-flex flex-column align-items-center justify-content-center gap-3 mb-3"
                    >
                        <div class="d-flex gap-3">
                            <div
                                class="d-flex align-items-center justify-content-center rounded-circle bg-danger"
                                style="height: 100px; width: 100px"
                            >
                                <span
                                    class="text-white"
                                    style="font-size: 25px"
                                    >{{ user.name[0] }}</span
                                >
                            </div>
                        </div>
                        <h4>{{ user.name }}</h4>
                    </div>
                    <div class="table-responsive w-100">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td class="p-3">
                                        <i class="bi bi-envelope-fill me-2"></i>
                                        <b>Email</b>
                                    </td>
                                    <td class="p-3">
                                        <span class="text-lowercase">
                                            {{ user.email }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-3">
                                        <i
                                            class="bi bi-telephone-fill me-2"
                                        ></i>
                                        <b>Phone</b>
                                    </td>
                                    <td class="p-3">
                                        <span class="text-lowercase">
                                            {{ user.phone }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-3">
                                        <i
                                            class="bi bi-house-door-fill me-2"
                                        ></i>
                                        <b>Address</b>
                                    </td>
                                    <td class="p-3">
                                        <span class="text-capitalize">
                                            {{ user.address }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-3">
                                        <i
                                            class="bi bi-check-circle-fill me-2"
                                        ></i>
                                        <b>Role</b>
                                    </td>
                                    <td class="p-3">
                                        <span class="text-capitalize">
                                            {{ user.role.role }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button
                        v-if="auth_user.id === user.id"
                        @click="editUser(user.id)" class="btn btn-primary">
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import api from "../api/axios.js";
import Sidebar from "./Sidebar.vue";
export default {
    components: {
        Sidebar,
    },
    name: "View",
    props: ["id"],
    data() {
        return {
            user: {
                name: "",
                email: "",
                phone: "",
                address: "",
                role: "",
                role_id: "",
            },
            auth_user: {},
        };
    },
    mounted() {
        this.fetchUsers(this.id);
    },
    methods: {
        async fetchUsers(id) {
            try {
                const { data } = await api.get(`/users/${id}/view`);
                this.user = data.user;
                this.auth_user = data.auth_user;
                console.log('Auth user: ', this.auth_user);
            } catch (error) {
                console.error("Error fetching user data:", error);
            }
        },
        editUser(id) {
            this.$router.push({ name: "editUser", params: { id } });
        },
    },
};
</script>

<style lang="scss" scoped></style>
