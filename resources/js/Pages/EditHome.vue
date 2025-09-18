<template>
    <AuthenticatedLayout>
    <div class="flex gap-4">
        <!-- Sidebar / Menu -->
        <div class="w-48 bg-white border border-gray-200 p-4 space-y-2">
            <button
                v-for="tab in tabs"
                :key="tab.id"
                @click="activeTab = tab.id"
                :class="{
          'bg-blue-500 text-white': activeTab === tab.id,
          'bg-gray-100 text-gray-700': activeTab !== tab.id
        }"
                class="w-full text-left px-3 py-2 rounded transition-colors"
            >
                {{ tab.title }}
            </button>
        </div>

        <!-- Content -->
        <div class="flex-1 p-4 bg-gray-50 rounded">
            <component :is="activeComponent"></component>
        </div>
    </div>
    </AuthenticatedLayout>
</template>

<script setup>
import HeroSectionSlider from "@/Components/Editor/HeroSectionSlider.vue";
import MinistriesAndProgramsEditor from "@/Components/Editor/MinistriesAndProgramsEditor.vue";// import TodaysReading from './TodaysReading.vue'
import TodaysReading from "@/Components/HomeSections/TodaysReading.vue";
import { ref, computed } from 'vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import RecentNews from "@/Components/HomeSections/RecentNews.vue";

const tabs = [
    { id: 'sliders', title: 'Sliders', component: HeroSectionSlider },
    { id: 'ministries', title: 'Ministries and Programs', component: MinistriesAndProgramsEditor },
    { id: 'reading', title: "Today's Reading", component: TodaysReading },
    { id: 'news', title: 'New from Vatican', component: RecentNews },
]

const activeTab = ref('sliders')

const activeComponent = computed(() => {
    return tabs.find(t => t.id === activeTab.value)?.component
})
</script>
