<template>
    <div class="d-flex">
        <Sidebar />
        <div class="d-flex justify-content-center w-100 mt-5 w-75">
            <form @submit.prevent="updateData" class="mt-5 w-50">
                <div
                    v-if="updateSuccess"
                    class="alert alert-success"
                    role="alert"
                >
                    {{ updateSuccess }}
                </div>
                <h3 class="mb-4">Edit User's Information</h3>
                <div class="mb-3">
                    <label for="title">Name</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="user.name"
                        name="name"
                    />
                </div>
                <div class="mb-3">
                    <label for="body">Email</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="user.email"
                        name="email"
                    />
                </div>
                <div class="mb-3">
                    <label for="body">Phone</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="user.phone"
                        name="phone"
                    />
                </div>
                <div class="mb-3">
                    <label for="body">Address</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="user.address"
                        name="address"
                    />
                </div>
                <div class="mb-3" v-if="auth_user.role_id === 3 || user.role_id === 3">
                    <label for="role">Role</label>
                    <select
                        name="role_id"
                        v-model="user.role_id"
                        class="form-select"
                    >
                        <option value="" hidden>Select</option>
                        <option
                            v-for="role in roles"
                            :key="role.id"
                            :value="role.id"
                        >
                            {{ role.role }}
                        </option>
                    </select>
                </div>
                <button class="btn btn-primary">Submit</button>
            </form>
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
    name: "EditUser",
    props: ["id"],
    data() {
        return {
            user: {
                name: "",
                email: "",
                phone: "",
                address: "",
                role_id: "",
            },
            auth_user: {},
            roles: [],
            error: null,
            updateSuccess: "",
        };
    },
    mounted() {
        this.fetchRoles();
        this.fetchUsers();
    },
    methods: {
        async fetchUsers(id) {
            try {
                const { data } = await api.get(`/users/${this.id}/edit`);
                this.user = data.user;
                console.log(data);
            } catch (error) {
                console.error("Error fetching user data:", error);
            }
        },
        async fetchRoles() {
            try {
                const { data } = await api.get("/users");
                this.roles = data.roles;
            } catch (error) {
                console.error("Error fetching roles:", error);
                alert("Failed to load roles.");
            }
        },
        async updateData() {
            try {
                await api.put(`/users/${this.id}/update`, {
                    name: this.user.name,
                    email: this.user.email,
                    phone: this.user.phone,
                    address: this.user.address,
                    role_id: this.user.role_id,
                });

                this.$router.push('/dashboard');
                this.updateSuccess = "User's information updated successfully!";
                setTimeout(() => {
                    this.updateSuccess = "";
                }, 3000);

            } catch (error) {
                console.error("Error updaing datas:", error);
                alert("Failed to updating data.");
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
