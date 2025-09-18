<template>
    <form @submit.prevent="goToSearch" class="relative w-full max-w-sm">
        <input
            type="text"
            v-model="query"
            placeholder="Search..."
            class="w-full rounded-md text-gray-900 border border-gray-300 px-3 py-2 pr-10 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        />
        <button
            type="submit"
            class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-indigo-600"
        >
            <!-- Search Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512" class="w-5 h-5">
                <path d="M505 442.7L405.3 343c28.4-34.9 45.7-79.4
      45.7-127C451 96.5 354.5 0 231 0S11 96.5 11
      216s96.5 216 216 216c48.2 0 92.7-17.3
      127.6-45.7L442.7 505c9.4 9.4 24.6
      9.4 33.9 0l28.3-28.3c9.5-9.3
      9.5-24.5.1-33.9zM231 370c-84.1 0-152-68-152-152S146.9
      66 231 66s152 68 152 152-68 152-152 152z"/>
            </svg>
        </button>
    </form>

</template>

<script setup>
import { ref } from "vue"
import { router } from "@inertiajs/vue3"

const query = ref("")

const goToSearch = () => {
    if (!query.value.trim()) return
    router.visit(`/search?q=${encodeURIComponent(query.value)}`)
}
</script>
