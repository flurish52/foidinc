<template>
    <div>
        <h2 class="text-xl md:text-2xl font-heading font-bold">{{ title }}</h2>
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
