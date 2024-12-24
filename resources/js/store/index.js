import { createStore } from "vuex";
import api from "../api/axios.js";

export const store = createStore({
    state: {
        user: JSON.parse(localStorage.getItem("user")) || null,
        permissions: [],
        users: [],
        roles: [],
        setFilterUsers: "",
        pagination: {
            current_page: 1,
            last_page: 1,
            total: 0,
            per_page: 7,
        },
    },
    mutations: {
        setUsers(state, users) {
            state.users = users;
        },
        setRoles(state, roles) {
            state.roles = roles;
        },
        setPermissions(state, permissions) {
            state.permissions = permissions;
        },
        setPagination(state, pagination) {
            state.pagination = pagination;
        },
        setUser(state, user) {
            state.user = user;
        },
    },
    getters: {
        hasPermissions: (state) => (permission) => {
            return state.permissions.includes(permission);
        },
    },
    actions: {
        async fetchUser({ commit, state }, page = 1) {
            try {
                const { data } = await api.get(`/users?page=${page}`);
                console.log("All users: ", data.users.data);
                commit("setUsers", data.users.data);
                commit("setRoles", data.roles);
                commit("setPagination", {
                    current_page: data.users.current_page,
                    last_page: data.users.last_page,
                    total: data.users.total,
                    per_page: data.users.per_page,
                });

                const role = state.roles.find(
                    (role) => role.id === state.user.role_id
                );
                if (role) {
                    const { data: permissionsData } = await api.get(
                        `/roles/${role.id}/permissions`
                    );
                    console.log("User Permissions:", permissionsData.permissions);
                    commit("setPermissions", permissionsData.permissions || []);
                } else {
                    console.error("No matching role found for the user.");
                }
            } catch (error) {
                console.error("Error fetching user data:", error);
            }
        },
        async filterByRole({ commit }, { roleId, page = 1 }) {
            try {
                const { data } = await api.post("/roles/filter", {
                    role_id: roleId,
                    page,
                });
                commit("setUsers", data.users);
                commit("setRoles", data.roles);
                commit("setPagination", {
                    current_page: data.users ? data.users.current_page : 1,
                    last_page: data.users ? data.users.last_page : 1,
                    total: data.users ? data.users.total : 0,
                    per_page: data.users ? data.users.per_page : 7,
                });
            } catch (e) {
                console.error("Error filtering users by role:", e);
            }
        },
        async search({ commit }, searchQuery) {
            try {
                const { data } = await api.post("/users/search", {
                    key: searchQuery,
                });

                commit("setUsers", data.users);
            } catch (error) {
                console.error("Error searching users:", error);
            }
        },
    },
});

export default store;
