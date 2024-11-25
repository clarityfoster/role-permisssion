<template>
    <div class="m-auto" style="max-width: 600px">
        <form @submit.prevent="addUser" class="mt-5">
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
                <input type="text" class="form-control" name="name" v-model="name"/>
            </div>
            <div class="mb-3">
                <label for="body">Email</label>
                <input type="text" class="form-control" name="email" v-model="email" />
            </div>
            <div class="mb-3">
                <label for="body">Password</label>
                <input type="password" class="form-control" name="password" v-model="password" />
            </div>
            <div class="mb-3">
                <label for="body">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" v-model="password_confirmation" />
            </div>
            <div class="mb-3">
                <label for="role">Role</label>
                <select name="role_id" v-model="role_id" class="form-select">
                    <option value="" hidden>Select</option>
                    <option v-for="role in roles" :key="role.id" :value="role.id">
                        {{ role.role }}
                    </option>
                </select>
            </div>
            <button class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script>
import api from "../api/axios.js";
export default {
    name: 'Adduser',
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            roles: [],
            role_id: '',
            failAddUser: '',
            validateError: '',
        }
    },
    mounted() {
        this.fetchRoles();
    },
    methods: {
        async fetchRoles() {
            try {
                const {data} = await api.get('/dashboard');
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
                role_id: this.role_id,
                password: this.password,
                password_confirmation: this.password_confirmation,
            };
            try {
                await api.post('/users/add', userData);
            } catch (error) {
                this.failAddUser = "Failed to create user. Try again!";
                console.error("Error fetching roles:", error);
            }
        }
    },
};
</script>

<style lang="sass" scoped></style>
