<template>
    <div class="relative w-full h-[500px] overflow-hidden rounded-lg shadow-lg">
        <!-- Slides -->
        <div
            class="absolute inset-0 transition-all duration-700"
            v-for="(slide, index) in slides"
            :key="index"
            :class="currentIndex === index ? 'opacity-100 z-10' : 'opacity-0 z-0'"
        >
            <img
                :src="slide.src"
                alt="Hero image"
                class="w-full h-full object-cover"
            />
            <!-- Text Overlay -->
            <div
                class="absolute inset-0 flex flex-col justify-center items-center text-center px-4"
            >
                <h2 class="text-3xl md:text-5xl font-heading text-white"
                    style="text-shadow: 2px 2px 8px rgba(0,0,0,0.9);">
                    {{ slide?.text }}
                </h2>

            </div>
        </div>

        <!-- Prev/Next Buttons -->
        <button
            @click="prevSlide"
            class="absolute left-smpad md:left-lgpad top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white px-3 py-2 rounded hover:bg-opacity-70 transition z-40"
        >
            Prev
        </button>
        <button
            @click="nextSlide"
            class="absolute right-smpad md:right-lgpad top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white px-3 py-2 rounded hover:bg-opacity-70 transition z-40"
        >
            Next
        </button>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import axios from "axios";

const slides = ref([]);

const fetchHeroSlides = async () => {
    try {
        const res = await axios.get('/hero/slider')
        if (res.status === 200 && res.data.sliders) {
            slides.value = res.data.sliders.map(slide => ({
                text: slide.text || '',
                src: `/storage/${slide.image}`
            }))
        }
    } catch (err) {
        console.error(err)
    }
}

onMounted(()=>{
    fetchHeroSlides()
})

const currentIndex = ref(0);
let interval = null;

const nextSlide = () => {
    currentIndex.value = (currentIndex.value + 1) % slides.value.length;
};

const prevSlide = () => {
    currentIndex.value = (currentIndex.value - 1 + slides.value.length) % slides.value.length;
};

// Auto-slide every 5 seconds
onMounted(() => {
    interval = setInterval(nextSlide, 5000);
});

onUnmounted(() => {
    clearInterval(interval);
});
</script>

<style scoped>
/* Smooth fade effect */
div > div {
    transition: opacity 0.7s ease;
}
</style>
