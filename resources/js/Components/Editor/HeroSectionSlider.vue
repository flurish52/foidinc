<template>
    <div class="w-full mx-auto px-6 space-y-6">
        <!-- Title -->
        <h1 class="text-2xl font-bold text-gray-800">Hero Slider Editor</h1>

        <!-- Upload Area -->
        <div
            @click="triggerUpload"
            @dragover.prevent="dragOver = true"
            @dragleave="dragOver = false"
            @drop.prevent="handleDrop"
            :class="{
                'border-blue-500 bg-blue-50': dragOver,
                'border-gray-300 bg-gray-50': !dragOver
            }"
            class="border-2 border-dashed rounded-lg p-8 text-center cursor-pointer transition-colors duration-200"
        >
            <input
                type="file"
                ref="fileInput"
                @change="handleUpload"
                multiple
                accept="image/*"
                class="hidden"
            />
            <div class="flex flex-col items-center justify-center space-y-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                <p class="text-lg font-medium text-gray-700">
                    Drag & drop images here or click to browse
                </p>
                <p class="text-sm text-gray-500">
                    Recommended size: 1600×600px (JPEG, PNG)
                </p>
            </div>
        </div>

        <!-- Preview + Sorting -->
        <div v-if="slides.length" class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-700">Slides ({{ slides.length }})</h2>
                <span class="text-sm text-gray-500">Drag to reorder or use arrows</span>
            </div>

            <div class="grid gap-4">
                <div
                    v-for="(slide, index) in slides"
                    :key="index"
                    class="relative bg-white rounded-lg border border-gray-200 p-4 flex gap-4 items-start shadow-sm hover:shadow-md transition-shadow duration-200"
                >
                    <!-- Thumbnail -->
                    <div class="flex-shrink-0">
                        <img
                            :src="slide.preview || `/storage/${slide.image}`"
                            class="w-32 h-20 object-cover rounded-md border border-gray-200"
                        />
                    </div>

                    <!-- Content -->
                    <div class="flex-1 space-y-3">
                        <input
                            v-model="slide.text"
                            type="text"
                            placeholder="Enter caption text (optional)"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        />
                        <div class="flex gap-2">
                            <button
                                @click="moveUp(index)"
                                :disabled="index === 0"
                                class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-md border border-gray-300 hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                            >
                                Move Up
                            </button>
                            <button
                                @click="moveDown(index)"
                                :disabled="index === slides.length - 1"
                                class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-md border border-gray-300 hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                            >
                                Move Down
                            </button>
                        </div>
                    </div>

                    <!-- Remove Button -->
                    <button
                        @click="removeSlide(index)"
                        class="absolute top-3 right-3 bg-white text-gray-400 hover:text-red-500 p-1 rounded-full border border-gray-200 hover:border-red-300 shadow-sm transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="pt-4 border-t border-gray-200">
            <button
                @click="saveSlides"
                :disabled="submitting || slides.length === 0"
                class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center justify-center"
            >
                <svg v-if="submitting" xmlns="http://www.w3.org/2000/svg" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ submitting ? 'Saving Changes...' : 'Save Slides' }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import axios from 'axios'

const slides = ref([])
const fileInput = ref(null)
const dragOver = ref(false)
const submitting = ref(false)
const form = useForm({ sliders: [] })

// Trigger hidden input
const triggerUpload = () => fileInput.value.click()

// Handle file selection
const handleUpload = e => {
    const files = Array.from(e.target.files)
    files.forEach(file => addSlide(file))
}

// Drag & drop
const handleDrop = e => {
    dragOver.value = false
    const files = Array.from(e.dataTransfer.files)
    files.forEach(file => {
        if (file.type.startsWith('image/')) addSlide(file)
    })
}

// Add new slide
const addSlide = file => {
    const reader = new FileReader()
    reader.onload = () => {
        slides.value.unshift({
            file,
            preview: reader.result,
            text: ''
        })
    }
    reader.readAsDataURL(file)
}


// Remove slide
const removeSlide = index => {
    slides.value.splice(index, 1)
}

// Reorder slides
const moveUp = index => {
    if (index === 0) return
    const temp = slides.value[index]
    slides.value.splice(index, 1)
    slides.value.splice(index - 1, 0, temp)
}
const moveDown = index => {
    if (index === slides.value.length - 1) return
    const temp = slides.value[index]
    slides.value.splice(index, 1)
    slides.value.splice(index + 1, 0, temp)
}

// Fetch existing slides from backend and prefill
const fetchHeroSlides = async () => {
    try {
        const res = await axios.get('/hero/slider')
        if (res.status === 200 && res.data.sliders) {
            // Reverse so latest slides appear first
            slides.value = res.data.sliders
                .slice() // copy to avoid mutating original
                .reverse()
                .map(slide => ({
                    image: slide.image,
                    text: slide.text || '',
                    preview: `/storage/${slide.image}`
                }))
        }
    } catch (err) {
        console.error(err)
    }
}


// Submit slides to backend
const saveSlides = async () => {
    submitting.value = true
    const data = new FormData()

    slides.value.forEach((slide, index) => {
        if (slide.file) {
            data.append(`sliders[${index}][image]`, slide.file)
        } else if (slide.image) {
            data.append(`sliders[${index}][image]`, slide.image)
        }
        data.append(`sliders[${index}][text]`, slide.text || '')
    })

    try {
        await axios.post('/hero/slider/edit', data, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        fetchHeroSlides()
    } catch (err) {
        console.error(err)
    } finally {
        submitting.value = false
    }
}

// Prefill slides on mount
onMounted(() => {
    fetchHeroSlides()
})
</script>
