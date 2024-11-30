<template>
    <div class="d-flex">
        <SideBar />
        <div>
            <h2>Welcome to Profile Page!</h2>
        </div>
    </div>
</template>

<script>
import Sidebar from "./Sidebar.vue";
export default {
    components: {
        Sidebar,
    },
    name: "Profile",
};
</script>

<style lang="scss" scoped></style>
