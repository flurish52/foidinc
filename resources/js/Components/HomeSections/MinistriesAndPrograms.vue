<template>
    <section class="py-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <Link
                v-for="(card, index) in cards"
                :key="index"
                :href="card.link"
                class="flex flex-col  hover:border-4 hover:border-primary rounded-lg overflow-hidden shadow hover:shadow-lg transition"
            >
                <!-- Image: 70% of card -->
                <div class="h-[70%]">
                    <img
                        :src="card.image"
                        :alt="card.title"
                        class="w-full h-full object-cover"
                    />
                </div>

                <!-- Title -->
                <div class="h-[30%] flex items-center justify-center bg-white p-4">
                    <h3 class="text-lg font-medium text-gray-800 text-center">
                        {{ card.title }}
                    </h3>
                </div>
            </Link>
        </div>
    </section>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
const cards = [
    {
        link: "/project/1",
        title: "Project One",
        image: "https://picsum.photos/id/1011/400/300"
    },
    {
        link: "/project/2",
        title: "Project Two",
        image: "https://picsum.photos/id/1012/400/300"
    },
    {
        link: "/project/3",
        title: "Project Three",
        image: "https://picsum.photos/id/1013/400/300"
    },
    {
        link: "/project/4",
        title: "Project Four",
        image: "https://picsum.photos/id/1014/400/300"
    },
    {
        link: "/project/5",
        title: "Project Five",
        image: "https://picsum.photos/id/1015/400/300"
    }
];
</script>
