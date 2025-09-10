<template>
    <!-- TopHeader sticky on mobile only -->
    <header class="sticky top-0 z-50 md:static w-full">
        <TopHeader class="block md:hidden"/>
    </header>
    <NavBar class="hidden md:block"/>
    <HeroSlider/>

    <section class="px-4 md:px-12  ">
        <SectionHeader class="mx-12 mt-6 text-center" title="Ministries and Programs" />
        <MinistriesAndPrograms />

        <TodaysReading />

        <RecentNews />

    </section>
    <footer>
        <Footer />
    </footer>
</template>
<script setup>
import {ref} from 'vue';
import axios from 'axios';
import NavBar from "@/Components/GuestNavBar/NavBar.vue";
import TopHeader from "@/Components/GuestNavBar/TopHeader.vue";
import HeroSlider from "@/Components/HomeSections/HeroSlider.vue";
import MinistriesAndPrograms from "@/Components/HomeSections/MinistriesAndPrograms.vue";
import TodaysReading from "@/Components/HomeSections/TodaysReading.vue";
import RecentNews from "@/Components/HomeSections/RecentNews.vue";
import Footer from "@/Components/HomeSections/Footer.vue";
import SectionHeader from "@/Components/HomeSections/SectionHeader.vue";

const title = ref('');
const content = ref('');

const savePage = async () => {
    try {
        await axios.post('/pages', {
            title: title.value,
            content: content.value
        });
        alert('Saved!');
    } catch (error) {
        console.error(error);
        alert('Failed to save page.');
    }
};
</script>
