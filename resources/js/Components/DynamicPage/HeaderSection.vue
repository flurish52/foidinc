<template>
    <div class="mb-6">
        <h2 class="text-2xl md:text-3xl font-heading font-bold mb-2">{{ title }}</h2>
        <hr class="border-tertiary" />
    </div>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        required: true
    }
});
</script>

