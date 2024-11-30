<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
    import Dashboard from './components/Dashboard.vue';
    import ManageRole from './components/ManageRole.vue';
    export default {
        components: {
            Dashboard,
            ManageRole,
        }
    }
</script>

<style lang="scss" scoped>

</style>
