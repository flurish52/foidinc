<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    href: {
        type: String,
        required: true
    },
    active: {
        type: Boolean,
        default: false
    }
})

const classes = computed(() =>
    props.active
        ? 'block px-4 py-2 rounded bg-indigo-100 text-indigo-700 font-medium'
        : 'block px-4 py-2 rounded text-gray-600 hover:bg-gray-200 hover:text-gray-900 transition duration-150 ease-in-out'
)
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
