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
                <h2 class="text-3xl md:text-5xl font-heading text-white drop-shadow-lg">
                    {{ slide.title }}
                </h2>
                <p class="mt-2 text-white text-lg md:text-xl drop-shadow-md">
                    {{ slide.subtitle }}
                </p>
            </div>
        </div>

        <!-- Prev/Next Buttons -->
        <button
            @click="prevSlide"
            class="absolute left-4 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white px-3 py-2 rounded hover:bg-opacity-70 transition z-50"
        >
            Prev
        </button>
        <button
            @click="nextSlide"
            class="absolute right-4 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white px-3 py-2 rounded hover:bg-opacity-70 transition z-50"
        >
            Next
        </button>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const slides = [
    {
        src: 'https://picsum.photos/id/1015/1200/500',
        title: 'Welcome to Our Diocese',
        subtitle: 'Join us in faith and community'
    },
    {
        src: 'https://picsum.photos/id/1016/1200/500',
        title: 'Helping Hands',
        subtitle: 'Come over to Macedonia and help us (Act 16:9)'
    },
    {
        src: 'https://picsum.photos/id/1018/1200/500',
        title: 'Community Events',
        subtitle: 'Engage and grow with our parish programs'
    },
    {
        src: 'https://picsum.photos/id/1020/1200/500',
        title: 'Your Support Matters',
        subtitle: 'Donate and make a difference today'
    }
];

const currentIndex = ref(0);
let interval = null;

const nextSlide = () => {
    currentIndex.value = (currentIndex.value + 1) % slides.length;
};

const prevSlide = () => {
    currentIndex.value = (currentIndex.value - 1 + slides.length) % slides.length;
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
