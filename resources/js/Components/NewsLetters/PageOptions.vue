<template>
    <template v-for="child in children" :key="child.id">
        <option :value="child.id">
            {{ prefix }}{{ child.title }}
        </option>
        <PageOptions
            v-if="child.children && child.children.length"
            :children="child.children"
            :prefix="prefix + '-- '"
        />
    </template>
</template>

<script setup>
defineProps({
    children: {
        type: Array,
        required: true,
    },
    prefix: {
        type: String,
        default: '',
    },
})
</script>
