<template>
    <li class="relative group  hover:bg-tertiary h-14 text-tertiary hover:text-secondary flex items-center  justify-center">
        <Link
            :href="href"
            class="flex items-center gap-1 px-4 font-medium transition-colors"
        >
            {{ name }}
            <svg
                v-if="children && children.length"
                class="w-4 h-4 text-tertiary-dark group-hover:text-secondary transition-colors"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </Link>
        <Dropdown v-if="children && children.length" :items="children" />
    </li>
</template>
<script setup>
import Dropdown from "./Dropdown.vue"
import {Link} from "@inertiajs/vue3";

defineProps({
    name: String,
    href: String,
    children: Array
})
</script>
