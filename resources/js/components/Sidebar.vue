<template>
    <div class="page-wrapper">
        <nav class="sidebar">
            <div class="d-flex align-items-center justify-content-center mb-4">
                <router-link to="/dashboard" class="h2 text-decoration-none text-dark">
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
                        class="nav-link"
                        to="/manageRole"
                        active-class="active">
                            <i class="bi bi-bar-chart me-2"></i> Manage Role
                        </router-link>
                </li>
                <li class="nav-item mb-2">
                    <router-link
                        class="nav-link"
                        to="/profile"
                        active-class="active"
                        ><i class="bi bi-person me-2"></i> Profile</router-link
                    >
                </li>
            </ul>
            <div v-if="!userlogin" class="mt-3">
                <router-link to="/login" class="text-decoration-none text-success"
                    ><i class="bi bi-box-arrow-in-right me-2"></i>
                    Login</router-link
                >
            </div>
            <div v-else>
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

        <div class="main-content w-100">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import api from "../api/axios.js";
export default {
    name: "Sidebar",
    data() {
        return {
            userlogin: !!localStorage.getItem("token"),
        };
    },
    methods: {
        async logout() {
            try {
                await api.post("/logout");
                this.userlogin = false;
                localStorage.removeItem("token");
                this.$router.push("/login");
            } catch (error) {
                console.error("Logout failed:", error);
            }
        },
    },
};
</script>

<style lang="scss" scoped>
    .page-wrapper {
        display: flex;
    }

    .sidebar {
        width: 250px;
        background-color: #f8f9fa;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        padding: 20px 15px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar .nav-link {
        color: #495057;
        border-radius: 5px;
        pointer-events: auto;
    }

    .sidebar .nav-link.disabled {
        pointer-events: none;
        opacity: 0.6;
        color: gray;
    }

    .sidebar .nav-link:hover:not(.disabled),
    .sidebar .nav-link.active {
        background-color:#0d6efd;
        font-weight: bold;
        color: #fff;
    }

    .main-content {
        margin-left: 250px;
        padding: 20px;
        background-color: #f4f4f4;
        height: 100vh;
        overflow-y: auto;
    }
</style>
