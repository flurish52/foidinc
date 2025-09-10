<template>
    <div class="px-4 md:px-6 py-6 space-y-8">
        <PageContent :article="sampleArticle" />
    </div>
</template>

<script setup>
import PageContent from "@/Components/DynamicPage/PageContent.vue";
const sampleArticle = {
    title: "Pope Leo XIV Canonizes Youth Icons",
    excerpt: "Pope Leo XIV has canonized two young figures, emphasizing the values of faith and youth engagement.",
    thumbnail: "https://picsum.photos/id/1035/800/400",
    body: [
        "On Sunday, Pope Leo XIV celebrated the canonization of two young men whose lives exemplify service and dedication.",
        "The ceremony took place at St. Peter's Basilica, attended by clergy and pilgrims from around the world.",
        "Their stories inspire a new generation of Catholics to engage with their communities and live their faith fully."
    ],
    images: [
        "https://picsum.photos/id/1036/800/400",
        "https://picsum.photos/id/1037/800/400"
    ],
    slider: [
        "https://picsum.photos/id/1038/400/250",
        "https://picsum.photos/id/1039/400/250",
        "https://picsum.photos/id/1040/400/250"
    ]
};
</script>
