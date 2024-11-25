<template>
    <div class="m-auto" style="max-width: 600px">
        <form @submit.prevent="addUser" class="mt-5">
            <h3 class="mb-4">Edit User's Information</h3>
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
    export default {
        data() {
            return {
                name: '',
                email: '',
                password: '',
                roles: [],
                role_id: '',
            }
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
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>
