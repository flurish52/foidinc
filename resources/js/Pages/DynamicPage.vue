<template>
    <div>
        <TopHeader />
        <NavBar />
        <div class="flex flex-col md:flex-row max-w-7xl mx-auto mt-16 px-4 md:px-6">
            <!-- Sidebar -->
            <aside class="hidden md:block w-64 flex-shrink-0 sticky top-16 h-[calc(100vh-4rem)] overflow-auto">
                <SideBar />
            </aside>
            <!-- Main content -->
            <main class="flex-1 md:ml-6">
            <HeaderSection :title="pageContent.title" />
                <div v-html="pageContent.content" class="space-y-8"></div>
            </main>

        </div>
    </div>
    <Footer />
</template>

<script setup>
import SideBar from "@/Components/GuestSideBar/SideBar.vue";
import TopHeader from "@/Components/GuestNavBar/TopHeader.vue";
import NavBar from "@/Components/GuestNavBar/NavBar.vue";
import Footer from "@/Components/HomeSections/Footer.vue";
import HeaderSection from "@/Components/DynamicPage/HeaderSection.vue";

defineProps({
    pageContent: Object
})
</script>
