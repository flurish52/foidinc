<template>
    <GuestLayout>
        <div class="flex min-h-screen w-full ">
            <!-- Sidebar -->
            <aside class="hidden md:block w-64 flex-shrink-0 sticky top-16 h-[calc(100vh-4rem)] overflow-auto">
                <SideBar/>
            </aside>
            <!-- Main content -->
            <main v-if="pageContent && Object.keys(pageContent).length" class="flex-1 md:pl-12">
                <HeaderSection v-if="pageContent.title" :title="pageContent.title"/>
                {{ pageContent.status }}
                <div
                    v-if="pageContent.content"
                    v-html="parseYouTubeEmbeds(pageContent.content)"
                    class="editor-content text-gray-600 break-words prose md:max-w-full md:w-full [&>img]:max-w-full [&>img]:h-auto [&>iframe]:w-full [&>iframe]:aspect-video"
                    @click="handleImageClick"
                ></div>

                <div v-if="pageContent.project && pageContent.project.length">
                    <h3 class="font-semibold mt-4">Projects</h3>
                    <ul>
                        <li v-for="project in pageContent.project" :key="project.id">
                            {{ project.title }}
                        </li>
                    </ul>
                </div>

                <div v-if="pageContent && pageContent.calendar && pageContent.calendar.length">
                    <Calendar :events="pageContent.calendar"/>
                </div>

                <div v-if="pageContent.newsletters && pageContent.newsletters.length">
                    <SectionHeader title="Newsletters" class="mt-6 text-gray-500"/>
                    <ul>
                        <li v-for="letter in pageContent.newsletters" :key="letter.id">
                            <a :href="`/storage/${letter.file_path}`" target="_blank" class="text-indigo-600 underline">
                                {{ letter.title }}
                            </a>
                        </li>
                    </ul>
                </div>

                <div v-if="pageContent.sliders" class="my-2">
                    <ImageSlider :images="JSON.parse(pageContent.sliders)"/>
                </div>
            </main>

            <!-- Fallback -->
            <main v-else class="flex-1 ">
                <HeaderSection :title="pageContent.title"/>
                <p class="text-gray-500">Nothing yet.</p>
            </main>
        </div>

    </GuestLayout>
</template>

<script setup>
import SideBar from "@/Components/GuestSideBar/SideBar.vue";
import ImageSlider from "@/Components/DynamicPage/ImageSlider.vue";
import TopHeader from "@/Components/GuestNavBar/TopHeader.vue";
import NavBar from "@/Components/GuestNavBar/NavBar.vue";
import Footer from "@/Components/HomeSections/Footer.vue";
import HeaderSection from "@/Components/DynamicPage/HeaderSection.vue";

const props = defineProps({
    pageContent: Object
});

// Modal state
import {ref} from "vue";
import NewslettersDisplay from "@/Components/NewsLetters/NewslettersDisplay.vue";
import SectionHeader from "@/Components/HomeSections/SectionHeader.vue";
import Calendar from "@/Components/DynamicPage/Calendar.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";

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


const parseYouTubeEmbeds = (content) => {
    if (!content) return ""

    const regex = /https?:\/\/(?:www\.)?(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([A-Za-z0-9_-]{11})[^ \n]*/g

    return content.replace(regex, (match, videoId) => {
        return `<div class="video-wrapper">
              <iframe width="560" height="315"
                src="https://www.youtube.com/embed/${videoId}"
                frameborder="0" allowfullscreen>
              </iframe>
            </div>`
    })
}



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

.editor-content .video-wrapper {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 */
    height: 0;
}

.editor-content img,
.editor-content iframe,
.editor-content video {
    max-width: 100%;
    height: auto;
    display: block;
}

/* Headers inside editor content */
.editor-content h1,
.editor-content h2,
.editor-content h3,
.editor-content h4,
.editor-content h5,
.editor-content h6 {
    font-family: 'Roboto', sans-serif;
    font-weight: 600;
    margin-top: 1.5em;
    margin-bottom: 0.75em;
    line-height: 1.25;
}

.editor-content h1 { font-size: 2rem; }
.editor-content h2 { font-size: 1.75rem; }
.editor-content h3 { font-size: 1.5rem; }
.editor-content h4 { font-size: 1.25rem; }
.editor-content h5 { font-size: 1rem; }
.editor-content h6 { font-size: 0.875rem; }

/* Force word wrapping */
.editor-content {
    white-space: pre-wrap;
    word-break: break-word;
    overflow-wrap: break-word;
}
</style>


