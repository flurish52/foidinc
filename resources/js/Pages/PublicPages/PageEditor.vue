<template>
    <AuthenticatedLayout>

    {{page}}
        <Ckeditor />

    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Ckeditor from "@/Components/Ckeditor.vue";

defineProps({
    page: Object
})
</script>

<style scoped>

</style>
