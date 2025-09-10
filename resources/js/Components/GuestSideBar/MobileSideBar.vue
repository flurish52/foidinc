<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    link: {
        type: Object,
        required: true
    }
})

const isOpen = ref(false)
</script>

<template>
    <div>
        <!-- Parent Link -->
        <div class="flex items-center justify-between px-4 py-2 hover:bg-tertiary text-tertiary transition">
            <Link :href="link.slug">
                {{ link.name }}
            </Link>

            <!-- Toggle if children exist -->
            <button v-if="link.children && link.children.length" @click="isOpen = !isOpen" class="ml-2">
                <span v-if="!isOpen">+</span>
                <span v-else>-</span>
            </button>
        </div>

        <!-- Child Links -->
        <div v-if="isOpen && link.children && link.children.length" class="ml-6 border-l border-gray-300">
            <MobileSideBar v-for="child in link.children" :key="child.id" :link="child" />
        </div>
    </div>
</template>
