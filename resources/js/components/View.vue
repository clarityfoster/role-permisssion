<template>
    <div
        class="d-flex align-items-center justify-content-center"
        style="height: 95vh"
    >
        <div class="d-flex align-items-start justify-content-between gap-4">
            <img
                :src="profileImg"
                alt="Profile Photo"
                class="img-thumbnail rounded-4"
                style="max-width: 265px"
            />
            <div class="d-flex flex-column gap-3">
                <div class="d-flex flex-column align-items-start">
                    <h5 style="margin-bottom: 5px">Name</h5>
                    <span>{{ user.name }}</span>
                </div>
                <div class="d-flex flex-column align-items-start">
                    <h5 style="margin-bottom: 5px">Email</h5>
                    <span>{{ user.email }}</span>
                </div>
                <div class="d-flex flex-column align-items-start">
                    <h5 style="margin-bottom: 5px">Phone</h5>
                    <span>{{ user.phone }}</span>
                </div>
                <div class="d-flex flex-column align-items-start">
                    <h5 style="margin-bottom: 5px">Address</h5>
                    <span>{{ user.address }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import api from "../api/axios.js";
export default {
    name: "View",
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
            profileImg: "/img/default_profile_img.jpeg",
        };
    },
    mounted() {
        this.fetchUsers(this.id);  // Call fetchUsers when the component is mounted
    },
    methods: {
        async fetchUsers(id) {
            try {
                const { data } = await api.get(`/users/${id}/view`);
                this.user = data.user; 
            } catch (error) {
                console.error("Error fetching user data:", error);
            }
        },
    }
};
</script>

<style lang="scss" scoped></style>
