<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const news = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
    try {
        const response = await axios.get('/news/news-from-vatican')
        news.value = response.data
    } catch (err) {
        error.value = 'Failed to load news'
    } finally {
        loading.value = false
    }
})
</script>

<template>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-6 text text-center">News from the Vatican</h2>

        <div v-if="loading">Loading...</div>
        <div v-if="error" class="text-red-500">{{ error }}</div>

        <div v-if="!loading && !error" class="grid gap-6 md:grid-cols-2">
            <a
                v-for="item in news.splice(0, 4)"
                :key="item.link"
                :href="item.link"
                target="_blank"
                class="flex flex-col border rounded-lg overflow-hidden shadow hover:shadow-lg transition"
            >
                <!-- Thumbnail -->
                <img
                    v-if="item.thumbnail"
                    :src="item.thumbnail"
                    :alt="item.title"
                    class="w-full h-48 object-cover"
                />

                <!-- Content -->
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2 hover:text-blue-600">
                        {{ item.title }}
                    </h3>
                    <p class="text-sm text-gray-500 mb-1">{{ new Date(item.pubDate).toLocaleString() }}</p>
                    <p v-if="item.author" class="text-sm text-gray-600 mb-2">By {{ item.author }}</p>
                    <p class="text-gray-700 line-clamp-3">{{ item.description }}</p>
                </div>
            </a>
        </div>
    </div>
</template>
