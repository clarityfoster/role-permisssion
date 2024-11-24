<template>
    <div>
        <div class="container mt-5" style="max-width: 1200px">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div
                        v-if="registerFailureMessage"
                        class="alert alert-warning alert-dismissible fade show"
                        role="alert"
                    >
                        {{ registerFailureMessage }}
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="card">
                        <div class="card-header">Register</div>
                        <div class="card-body">
                            <form @submit.prevent="register">
                                <div class="row mb-3">
                                    <label
                                        for="name"
                                        class="col-md-4 col-form-label text-md-end"
                                        >Name</label
                                    >
                                    <div class="col-md-6">
                                        <input
                                            id="name"
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            required
                                            autocomplete="name"
                                            autofocus
                                            v-model="name"
                                        />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label
                                        for="email"
                                        class="col-md-4 col-form-label text-md-end"
                                        >Email</label
                                    >
                                    <div class="col-md-6">
                                        <input
                                            id="email"
                                            type="email"
                                            class="form-control"
                                            name="email"
                                            required
                                            autocomplete="email"
                                            v-model="email"
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
                                            type="password"
                                            class="form-control"
                                            name="password"
                                            required
                                            autocomplete="new-password"
                                            v-model="password"
                                        />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label
                                        for="password_confirmation"
                                        class="col-md-4 col-form-label text-md-end"
                                        >Confirm Password</label
                                    >
                                    <div class="col-md-6">
                                        <input
                                            id="confirm_password"
                                            type="password"
                                            class="form-control"
                                            name="password_confirmation"
                                            required
                                            autocomplete="new-password"
                                            v-model="password_confirmation"
                                        />
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button class="btn btn-primary">
                                            Register
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import api from "../api/axios.js";

export default {
    name: "Register",
    data() {
        return {
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            registerFailureMessage: "",
        };
    },
    methods: {
        async register() {
            try {
                if (this.password !== this.password_confirmation) {
                    this.registerFailureMessage =
                        "Check the password and confirm password again!";
                    return;
                }
                const { data } = await api.post("/register", {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                });
                if (data.success) {
                    this.name = "";
                    this.email = "";
                    this.password = "";
                    this.password_confirmation = "";
                    this.$router.push("/login");
                }
            } catch (error) {
                this.registerFailureMessage = "Registration failed! Try again.";
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
