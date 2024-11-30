<template>
    <div class="d-flex">
        <Sidebar />
        <div class="d-flex justify-content-center mt-5 w-75">
            <form @submit.prevent="addUser" class="w-50">
                <div
                    v-if="failAddUser"
                    class="alert alert-danger alert-dismissible fade show"
                    role="alert"
                >
                    {{ failAddUser }}
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>
                </div>
                <h3 class="mb-4">Add User</h3>
                <div class="mb-3">
                    <label for="title">Name</label>
                    <input
                        type="text"
                        class="form-control"
                        name="name"
                        v-model="name"
                    />
                </div>
                <div class="mb-3">
                    <label for="body">Email</label>
                    <input
                        type="text"
                        class="form-control"
                        name="email"
                        v-model="email"
                    />
                </div>
                <div class="mb-3">
                    <label for="body">Phone</label>
                    <input
                        type="text"
                        class="form-control"
                        name="phone"
                        v-model="phone"
                    />
                </div>
                <div class="mb-3">
                    <label for="body">Address</label>
                    <input
                        type="text"
                        class="form-control"
                        name="address"
                        v-model="address"
                    />
                </div>
                <div class="mb-3">
                    <label for="body">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        name="password"
                        v-model="password"
                    />
                </div>
                <div class="mb-3">
                    <label for="body">Confirm Password</label>
                    <input
                        type="password"
                        class="form-control"
                        name="password_confirmation"
                        v-model="password_confirmation"
                    />
                </div>
                <div class="mb-3">
                    <label for="role">Role</label>
                    <select
                        name="role_id"
                        v-model="role_id"
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
    name: "Adduser",
    data() {
        return {
            name: "",
            email: "",
            password: "",
            phone: "",
            address: "",
            password_confirmation: "",
            roles: [],
            role_id: "",
            failAddUser: "",
            validateError: "",
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
        async addUser() {
            const userData = {
                name: this.name,
                email: this.email,
                phone: this.phone,
                address: this.address,
                role_id: this.role_id,
                password: this.password,
                password_confirmation: this.password_confirmation,
            };
            try {
                await api.post("/users/add", userData);
                this.$router.push("/dashboard");
            } catch (error) {
                if (error.response && error.response.data) {
                    console.error(
                        "Validation errors:",
                        error.response.data.errors
                    );
                    this.failAddUser = Object.values(
                        error.response.data.errors
                    ).join(", ");
                } else {
                    this.failAddUser = "Failed to create user. Try again!";
                }
            }
        },
    },
};
</script>

<style lang="sass" scoped></style>
