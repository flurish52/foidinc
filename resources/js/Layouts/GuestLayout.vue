<script setup>
import { ref, onMounted, onUnmounted } from "vue"
import TopHeader from "@/Components/GuestNavBar/TopHeader.vue"
import NavBar from "@/Components/GuestNavBar/NavBar.vue"
import Footer from "@/Components/HomeSections/Footer.vue"

const showButton = ref(false)

const checkScroll = () => {
    showButton.value = window.scrollY > 200
}

const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: "smooth" })
}

onMounted(() => {
    window.addEventListener("scroll", checkScroll)
})

onUnmounted(() => {
    window.removeEventListener("scroll", checkScroll)
})
</script>

<template>
    <div id="top">
        <TopHeader />
        <NavBar />
        <div class="flex flex-col md:flex-row mt-16">
            <div class="w-full bg-white px-smpad md:px-lgpad shadow-md sm:rounded-lg">
                <slot />
            </div>
        </div>
        <Footer />

        <!-- Back to Top Button -->
        <transition
            enter-active-class="transform transition duration-300"
            enter-from-class="opacity-0 translate-y-4 rotate-90"
            enter-to-class="opacity-100 translate-y-0 rotate-0"
            leave-active-class="transform transition duration-300"
            leave-from-class="opacity-100 translate-y-0 rotate-0"
            leave-to-class="opacity-0 translate-y-4 rotate-90"
        >
            <button
                v-if="showButton"
                @click="scrollToTop"
                class="fixed bottom-6 right-6 w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center shadow-lg hover:bg-primary-dark focus:outline-none"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                </svg>
            </button>
        </transition>
    </div>
</template>

