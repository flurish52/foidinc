<template>
    <AuthenticatedLayout>

    {{page}}
    </AuthenticatedLayout>

</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    page: Array
})
</script>

<style scoped>

</style>
