<template>
    <div class="m-auto" style="max-width: 600px">
        <form @submit.prevent="addUser" class="mt-5">
            <h3 class="mb-4">Add New Role</h3>
            <div class="mb-3">
                <label for="title">Role Name</label>
                <input
                    type="text"
                    class="form-control"
                    name="role_name"
                />
            </div>
            <div class="mb-3" v-for="permission in permissions" :key="permission.id">
                <input
                    type="checkbox"
                    class="form-check-input form-check-primary me-2"
                />
                <label :for="`permission-${permission.id}`">{{ permission.permissions }}</label>
            </div>
            <button class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script>
import api from "../api/axios.js";
export default {
    data() {
        return {
            permissions: [],
        };
    },
    mounted() {
        this.fetchPermissions();
    },
    methods: {
        async fetchPermissions() {
            try {
                const { data } = await api.get("/users");
                this.permissions = data.permissions;
            } catch (error) {
                console.error("Error fetching roles:", error);
                alert("Failed to load roles.");
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
