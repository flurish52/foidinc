<template>
    <article class="max-w-4xl mx-auto bg-white shadow rounded-lg p-6 space-y-6">
        <!-- Article Header -->
        <HeaderSection :title="article.title" />

        <p class="text-gray-700 font-sans">{{ article.excerpt }}</p>

        <!-- Thumbnail -->
        <img
            v-if="article.thumbnail"
            :src="article.thumbnail"
            :alt="article.title"
            class="w-full h-auto rounded-lg shadow-sm"
        />

        <!-- Article Body -->
        <div class="prose prose-sm md:prose lg:prose-lg">
            <p v-for="(paragraph, i) in article.body" :key="i">{{ paragraph }}</p>
        </div>

        <!-- Inline Images -->
        <div v-if="article.images && article.images.length" class="space-y-4">
            <img
                v-for="(img, i) in article.images"
                :key="i"
                :src="img"
                alt="Article image"
                class="w-full rounded-lg shadow"
            />
        </div>

        <!-- Slider at the end -->
        <div v-if="article.slider && article.slider.length" class="mt-6">
            <h3 class="font-semibold text-lg mb-2">Related Images</h3>
            <div class="flex overflow-x-auto space-x-4">
                <div
                    v-for="(slide, i) in article.slider"
                    :key="i"
                    class="flex-shrink-0 w-64 h-40 rounded-lg overflow-hidden shadow"
                >
                    <img :src="slide" alt="Slide" class="w-full h-full object-cover" />
                </div>
            </div>
        </div>
    </article>
</template>

<script setup>
import HeaderSection from './HeaderSection.vue';

const props = defineProps({
    article: {
        type: Object,
        required: true
    }
});
</script>
