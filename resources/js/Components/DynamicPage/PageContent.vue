<template>
    <article class="max-w-4xl mx-auto bg-white shadow rounded-lg p-6 space-y-6">
        <!-- HTML content -->
        <div class="prose" v-html="pageContent.content"></div>
{{pageContent}}
        <!-- Thumbnail -->
        <img
            v-if="$pageContent.thumbnail"
            :src="pageContent.thumbnail"
            :alt="pageContent.title"
            class="w-full h-auto rounded-lg shadow-sm"
        />

        <!-- Slider -->
        <div
            v-if="pageContent.sliders && pageContent.sliders.length"
            class="mt-6"
        >
            <h3 class="font-semibold text-lg mb-2">Related Images</h3>
            <div class="flex overflow-x-auto space-x-4">
                <div
                    v-for="(slide, i) in pageContent.sliders"
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

defineProps({
    pageContent: Object
})
</script>
