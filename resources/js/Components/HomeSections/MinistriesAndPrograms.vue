<template>
    <section class="py-10 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <Link
                v-for="(card, index) in cards"
                :key="index"
                :href="`/page/${card.page.slug}`"
                class="flex flex-col rounded-xl overflow-hidden bg-white shadow-md hover:shadow-xl border transition"
            >
                <!-- Image -->
                <div class="h-48">
                    <img
                        :src="`/storage/${card.thumbnail}`"
                        :alt="card.title"
                        class="w-full h-full object-cover"
                    />
                </div>

                <!-- Title -->
                <div class="flex items-center justify-center p-6">
                    <h3 class="text-lg font-semibold text-gray-800 text-center">
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
