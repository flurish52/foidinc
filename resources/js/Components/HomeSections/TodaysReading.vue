<template>
    <div class="py-6 bg-gray-50">
        <h1 class="text-3xl font-bold text-center my-6">Today's Readings</h1>

        <div class="grid gap-6 md:grid-cols-2">
            <div v-for="(item, index) in readings" :key="index" class="bg-white shadow-md rounded-lg p-5 hover:shadow-xl transition">
                <h2 class="text-xl font-semibold mb-3 text-blue-700">{{ item.title }}</h2>

                <ul class="space-y-2">
                    <li>
                        <a :href="item.reading1Link" target="_blank" class="text-blue-600 hover:underline">
                            {{ item.reading1 }}
                        </a>
                    </li>
                    <li v-if="item.psalm">
                        <a :href="item.psalmLink" target="_blank" class="text-green-600 hover:underline">
                            {{ item.psalm }}
                        </a>
                    </li>
                    <li>
                        <a :href="item.gospelLink" target="_blank" class="text-red-600 hover:underline">
                            {{ item.gospel }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const readings = ref([]);

onMounted(async () => {
    const res = await fetch('/readings/daily-readings');
    const data = await res.json();

    readings.value = data.slice(0, 2).map(item => {
        const div = document.createElement('div');
        div.innerHTML = item.description;

        const reading1El = div.querySelector('h4');
        const reading1Link = reading1El?.querySelector('a')?.href || '#';
        const reading1Text = reading1El?.textContent || '';

        const psalmEl = Array.from(div.querySelectorAll('p')).find(p => p.textContent.includes('Psalm'));
        const psalmLink = psalmEl?.querySelector('a')?.href || '#';
        const psalmText = psalmEl?.textContent || '';

        const gospelEl = Array.from(div.querySelectorAll('h4')).find(h => h.textContent.includes('Gospel'));
        const gospelLink = gospelEl?.querySelector('a')?.href || '#';
        const gospelText = gospelEl?.textContent || '';

        return {
            title: item.title,
            reading1: reading1Text,
            reading1Link,
            psalmLink,
            gospel: gospelText,
            gospelLink
        };
    });
});
</script>
