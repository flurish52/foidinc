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
            <main v-if="pageContent"  class="flex-1 md:ml-6">
                <HeaderSection :title="pageContent.title" />

                <!-- Editor content with clickable images -->
                <div
                    v-html="pageContent.content"
                    class="editor-content space-y-8"
                    @click="handleImageClick"
                ></div>
                <!-- Slider if present -->
                <div v-if="pageContent.sliders" class="my-2">
                    <ImageSlider :images="JSON.parse(pageContent.sliders)" />
                </div>
            </main>
            <main v-else  class="flex-1 md:ml-6">
                <HeaderSection :title="pageContent.title" />

                <!-- Editor content with clickable images -->
                <div
                    v-html="pageContent.content"
                    class="editor-content space-y-8"
                    @click="handleImageClick"
                ></div>

                <!-- Slider if present -->
                <div v-if="pageContent.sliders" class="my-2">
                    <ImageSlider :images="JSON.parse(pageContent.sliders)" />
                </div>
            </main>
        </div>

        <Footer />

        <!-- Modal for clicked images -->
        <div
            v-if="modalOpen"
            @click.self="closeModal"
            class="fixed inset-0 bg-black/80 flex items-center justify-center z-50"
        >
            <button
                @click="closeModal"
                class="absolute top-2 right-2 text-white px-3 py-1 rounded hover:bg-gray-200"
            >
                X
            </button>
            <div class="relative">
                <img
                    :src="modalSrc"
                    :style="{ transform: `scale(${zoom})` }"
                    class="max-h-[90vh] max-w-[90vw] object-contain transition-transform duration-200"
                />

                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex space-x-2">
                    <button @click="zoomIn" class="bg-white text-black px-3 py-1 rounded hover:bg-gray-200">+</button>
                    <button @click="zoomOut" class="bg-white text-black px-3 py-1 rounded hover:bg-gray-200">-</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import SideBar from "@/Components/GuestSideBar/SideBar.vue";
import ImageSlider from "@/Components/DynamicPage/ImageSlider.vue";
import TopHeader from "@/Components/GuestNavBar/TopHeader.vue";
import NavBar from "@/Components/GuestNavBar/NavBar.vue";
import Footer from "@/Components/HomeSections/Footer.vue";
import HeaderSection from "@/Components/DynamicPage/HeaderSection.vue";

defineProps({
    pageContent: Object
});

// Modal state
import { ref } from "vue";

const modalOpen = ref(false);
const modalSrc = ref("");
const zoom = ref(1);

// Handle image clicks inside editor content
const handleImageClick = (e) => {
    if (e.target.tagName === "IMG") {
        modalSrc.value = e.target.src;
        zoom.value = 1;
        modalOpen.value = true;
    }
};

const closeModal = () => {
    modalOpen.value = false;
};

const zoomIn = () => {
    zoom.value = Math.min(zoom.value + 0.2, 3);
};

const zoomOut = () => {
    zoom.value = Math.max(zoom.value - 0.2, 0.5);
};
</script>
<style>
.editor-content img {
    cursor: pointer;
}
.editor-content a {
    color: blue;
    text-decoration-color: blue;
}
.editor-content a:visited {
    color: purple;
    text-decoration-color: purple;
}

</style>
