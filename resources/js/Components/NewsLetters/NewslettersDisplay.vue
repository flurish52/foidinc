<template>
    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">Newsletters</h1>
        <ul class="space-y-2">
            <li
                v-if="newsletters && newsletters.length > 0"
                v-for="item in newsletters" :key="item.id">
                <a :href="`/storage/${item.file_path}`" target="_blank" class="text-blue-600 underline">
                    {{ item.title }}
                </a>
            </li>
            <li
                class="text-blue-600 underline">
                No items yet
            </li>
        </ul>
    </div>
</template>

<script setup>
defineProps({
    newsletters: Array
})
</script>
