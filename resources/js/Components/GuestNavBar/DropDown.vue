<template>
    <ul
        class="absolute left-0 top-12 hidden group-hover:block bg-white border border-gray-100 rounded-xl shadow-md min-w-[220px] mt-2 overflow-hidden"
    >
        <li
            v-for="(item, index) in items"
            :key="index"
        >
            <Link
                :href="item.slug"
                class="block px-4 py-3 text-sm text-secondary-dark hover:bg-blue-50 hover:text-secondary transition-colors"
            >
                {{ item.name }}
            </Link>
        </li>
    </ul>
</template>
<script setup>
import {Link} from "@inertiajs/vue3";
defineProps({
    items: {
        type: Array,
        required: true
    }
})
</script>
