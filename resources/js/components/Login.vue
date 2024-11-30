<template>
    <div class="container mt-5" style="max-width: 1200px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div
                    v-if="loginFail"
                    class="alert alert-danger alert-dismissible fade show"
                    role="alert"
                >
                    {{ loginFail }}
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form @submit.prevent="login">
                            <div class="row mb-3">
                                <label
                                    for="email"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Email</label
                                >
                                <div class="col-md-6">
                                    <input
                                        id="email"
                                        v-model="email"
                                        type="email"
                                        class="form-control"
                                        name="email"
                                        required
                                        autocomplete="email"
                                        autofocus
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label
                                    for="password"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Password</label
                                >
                                <div class="col-md-6">
                                    <input
                                        id="password"
                                        v-model="password"
                                        type="password"
                                        class="form-control"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                    />
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button class="btn btn-primary">
                                        Login
                                    </button>

                                    <router-link to="/register" class="text-secondary ms-2">
                                        Sign Up
                                    </router-link>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import api from "../api/axios.js";
export default {
    name: "Login",
    data() {
    return {
        email: "",
        password: "",
        loginSuccess: "",
        loginFail: "",
        auth_user: JSON.parse(localStorage.getItem('user')) || null, // Initialize with existing user from localStorage
    };
},
mounted() {
    window.addEventListener('storage', this.syncUserData);
},
beforeDestroy() {
    window.removeEventListener('storage', this.syncUserData);
},
methods: {
    syncUserData() {
        // Update auth_user whenever 'user' in localStorage changes
        this.auth_user = JSON.parse(localStorage.getItem('user')) || null;
    },
    async login() {
        try {
            // localStorage.removeItem("token");
            // localStorage.removeItem("user");

            const { data } = await api.post("/login", {
                email: this.email,
                password: this.password,
            });

            if (data.success) {
                // Set new token and user data
                localStorage.setItem("token", data.token);
                localStorage.setItem("user", JSON.stringify(data.user));

                this.auth_user = data.user; // Immediately update auth_user state
                this.loginSuccess = "Login successful!";
                this.loginFail = "";
            }
            this.$router.push("/dashboard");
        } catch (error) {
            this.loginFail =
                error.response?.data?.message || "Login failed!";
            this.successMessage = "";
        }
    },
},
};
</script>

<style lang="scss" scoped></style>
