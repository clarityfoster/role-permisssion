<template>
    <nav class="sidebar">
        <div class="d-flex align-items-center justify-content-center mb-4">
            <router-link
                to="/dashboard"
                class="h2 text-decoration-none text-dark"
            >
                RoleX
            </router-link>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <router-link
                    class="nav-link"
                    to="/dashboard"
                    active-class="active"
                    ><i class="bi bi-house-door me-2"></i>
                    Dashboard
                </router-link>
            </li>
            <li class="nav-item mb-2">
                <router-link
                    v-if="user.role_id === 3"
                    class="nav-link"
                    to="/manageRole"
                    active-class="active"
                >
                    <i class="bi bi-bar-chart me-2"></i> Manage Role
                </router-link>
            </li>
        </ul>
        <div>
            <a
                @click.prevent="logout"
                href="#"
                class="text-decoration-none text-danger"
            >
                <i class="bi bi-box-arrow-left me-2"></i>
                Log out
            </a>
        </div>
    </nav>
</template>

<script>
import api from "../api/axios.js";
export default {
    name: "Sidebar",
    data() {
        return {
            user: JSON.parse(localStorage.getItem("user")),
        };
    },
    methods: {
        async logout() {
            try {
                const user = localStorage.getItem("user");
                localStorage.removeItem("user");
                await api.post("/logout");

                this.$router.push("/");
            } catch (error) {
                console.error("Logout failed:", error);
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.sidebar {
    width: 300px; /* Width of sidebar */
    background-color: #f8f9fa;
    height: 100vh; /* Full height */
    position: sticky; /* Fixes the sidebar on the left */
    top: 0;
    left: 0;
    padding: 20px 15px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    z-index: 1000; /* Ensures the sidebar stays on top */
}

.main-content {
    margin-left: 300px; /* Adds space for the sidebar */
    padding: 20px; /* Optional padding for the main content */
}

/* Styling for links in the sidebar */
.sidebar .nav-link {
    color: #495057;
    border-radius: 5px;
}

.sidebar .nav-link:hover:not(.disabled),
.sidebar .nav-link.active {
    background-color: #0d6efd;
    font-weight: bold;
    color: #fff;
}
</style>
