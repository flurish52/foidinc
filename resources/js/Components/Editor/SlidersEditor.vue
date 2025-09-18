<template>
    <div class="space-y-4">
        <!-- Upload Area -->
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Slider Editor</h1>
        <div
            @click="triggerUpload"
            @dragover.prevent="dragOver = true"
            @dragleave="dragOver = false"
            @drop.prevent="handleDrop"
            :class="{'border-blue-500 bg-blue-50': dragOver, 'border-gray-300': !dragOver}"
            class="border-2 border-dashed rounded-xl p-8 text-center cursor-pointer transition-colors"
        >
            <input
                type="file"
                ref="fileInput"
                @change="handleUpload"
                multiple
                accept="image/*"
                class="hidden"
            >
            <div class="flex flex-col items-center justify-center space-y-2">
                <p class="text-gray-700 font-medium">Drag & drop images here or click to browse</p>
                <p class="text-sm text-gray-500">Recommended size: 800x800px (JPEG, PNG)</p>
            </div>
        </div>
        <!-- Preview -->
        <div v-if="images.length" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">

            <div v-for="(img, index) in images" :key="index" class="relative group rounded-lg overflow-hidden border border-gray-300">
                <img :src="img.preview || `/storage/${img}`" class="w-full h-40 object-cover">
                <!-- Remove Button -->
                <button @click="removeImage(index)" class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full hover:bg-red-600">
                    ✕
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => []
    }
})
const emit = defineEmits(['update:modelValue'])

const images = ref([...props.modelValue])
const fileInput = ref(null)
const dragOver = ref(false)

// Trigger hidden input
const triggerUpload = () => fileInput.value.click()

// Handle file selection
const handleUpload = (e) => {
    const files = Array.from(e.target.files)
    files.forEach(file => {
        const reader = new FileReader()
        reader.onload = () => {
            images.value.push({ file, preview: reader.result })
            emitImages()
        }
        reader.readAsDataURL(file)
    })
    // e.target.value = ''
}

// Drag & drop
const handleDrop = (e) => {
    dragOver.value = false
    const files = Array.from(e.dataTransfer.files)
    files.forEach(file => {
        if (!file.type.startsWith('image/')) return
        const reader = new FileReader()
        reader.onload = () => {
            images.value.push({ file, preview: reader.result })
            emitImages()
        }
        reader.readAsDataURL(file)
    })
}

// Remove image
const removeImage = (index) => {
    images.value.splice(index, 1)
    emitImages()
}

// Emit only the data parent cares about
const emitImages = () => {
    const payload = images.value.map(img => img.file || img)
    emit('update:modelValue', payload)
}

// Watch external changes
watch(() => props.modelValue, (val) => {
    images.value = val.map(i => (i instanceof File ? { file: i, preview: URL.createObjectURL(i) } : i))
}, { deep: true })
</script>
