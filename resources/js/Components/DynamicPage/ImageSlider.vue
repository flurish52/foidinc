<template>
    <div class="relative w-full max-w-2xl mx-auto overflow-hidden rounded-2xl shadow-lg my-3">
        <!-- Images -->
        <div
            class="flex transition-transform duration-700 ease-in-out"
            :style="{ transform: `translateX(-${currentIndex * 100}%)` }"
        >
            <div
                v-for="(image, index) in images"
                :key="index"
                class="w-full flex-shrink-0 cursor-pointer"
            >
                <img
                    :src="`/storage/${image}`"
                    alt="Slider Image"
                    class="w-full h-64 object-cover"
                    @click="openModal(index)"
                />
            </div>
        </div>
        <!-- Prev Button -->
        <button
            @click="prevSlide"
            class="absolute top-1/2 left-3 -translate-y-1/2 bg-black/40 text-white p-2 rounded-full hover:bg-black/70"
        >
            ‹
        </button>
        <!-- Next Button -->
        <button
            @click="nextSlide"
            class="absolute top-1/2 right-3 -translate-y-1/2 bg-black/40 text-white p-2 rounded-full hover:bg-black/70"
        >
            ›
        </button>

        <!-- Indicators -->
        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex space-x-2">
            <button
                v-for="(image, index) in images"
                :key="index"
                @click="goToSlide(index)"
                :class="[
          'w-3 h-3 rounded-full',
          currentIndex === index ? 'bg-white' : 'bg-gray-400'
        ]"
            ></button>
        </div>
        <!-- Modal -->
        <div
            v-if="modalOpen"
            @click.self="closeModal"
            class="fixed inset-0 bg-black/80 flex items-center justify-center z-50"
        >
            <button
                @click="closeModal"
                class="absolute top-2 right-0 text-2xl text-white px-3 py-1 rounded hover:bg-gray-200"
            >
                X
            </button>
            <div class="relative">
                <img
                    :src="`/storage/${images[modalIndex]}`"
                    :style="{ transform: `scale(${zoom})` }"
                    class="max-h-[90vh] max-w-[90vw] object-contain transition-transform duration-200"
                />
                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex space-x-2">
                    <button @click="zoomIn" class="bg-white text-black px-3 py-1 rounded hover:bg-gray-200">
                        +
                    </button>
                    <button @click="zoomOut" class="bg-white text-black px-3 py-1 rounded hover:bg-gray-200">
                        -
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
const props = defineProps({
    images: {
        type: Array,
        required: true
    },
    interval: {
        type: Number,
        default: 3000
    }
})
const currentIndex = ref(0)
let slideInterval = null
const nextSlide = () => {
    currentIndex.value = (currentIndex.value + 1) % props.images.length
}
const prevSlide = () => {
    currentIndex.value =
        (currentIndex.value - 1 + props.images.length) % props.images.length
}
const goToSlide = (index) => {
    currentIndex.value = index
}
// Modal logic
const modalOpen = ref(false)
const modalIndex = ref(0)
const zoom = ref(1)
const openModal = (index) => {
    modalIndex.value = index
    zoom.value = 1
    modalOpen.value = true
}
const closeModal = () => {
    modalOpen.value = false
}
const zoomIn = () => {
    zoom.value = Math.min(zoom.value + 0.2, 3)
}
const zoomOut = () => {
    zoom.value = Math.max(zoom.value - 0.2, 0.5)
}
onMounted(() => {
    slideInterval = setInterval(nextSlide, props.interval)
})
onBeforeUnmount(() => {
    clearInterval(slideInterval)
})
</script>
