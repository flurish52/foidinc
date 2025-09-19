<template>
    <section class="py-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <Link
                v-for="(card, index) in cards"
                :key="index"
                :href="`/page/${card.page.slug}`"
                class="flex flex-col  hover:border-4 hover:border-primary rounded-lg overflow-hidden shadow hover:shadow-lg transition"
            >
                <!-- Image: 70% of card -->
                <div class="h-[70%]">
                    <img
                        :src="`/storage/${card.thumbnail}`"
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
import {onMounted, ref} from "vue";
import axios from "axios";
const cards =   ref([])

onMounted(async () => {
    const res = await axios.get('/projects')
    cards.value = res.data.cards
})
</script>
