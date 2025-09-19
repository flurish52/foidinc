<template>
    <TopHeader />
    <NavBar  />
    <div class="max-w-7xl mx-auto p-4 flex mt-16">

        <!-- Sidebar -->
        <SideBar class="w-64 flex-shrink-0" />

        <!-- Main content (centered) -->
        <div class="flex-1 flex justify-center items-start">
            <div class="w-full max-w-xl">

                <!-- Toggle buttons -->
                <div class="flex mb-6 space-x-2 justify-center">
                    <button
                        @click="activeForm = 'contact'"
                        :class="activeForm === 'contact' ? 'bg-primary-dark text-white' : 'bg-gray-200 text-gray-700'"
                        class="px-4 py-2 rounded"
                    >
                        Contact Us
                    </button>
                    <button
                        @click="activeForm = 'mass'"
                        :class="activeForm === 'mass' ? 'bg-primary-dark text-white' : 'bg-gray-200 text-gray-700'"
                        class="px-4 py-2 rounded"
                    >
                        Mass Intentions
                    </button>
                    <button
                        @click="activeForm = 'prayer request'"
                        :class="activeForm === 'prayer request' ? 'bg-primary-dark text-white' : 'bg-gray-200 text-gray-700'"
                        class="px-4 py-2 rounded"
                    >
                        Prayer Request
                    </button>
                </div>
                <!-- Forms -->
                <ContactUsForm v-if="activeForm === 'contact'" />
                <MassIntentionsForm v-if="activeForm === 'mass'" />
                <PrayerRequest v-if="activeForm === 'prayer request'" />

            </div>
        </div>
    </div>
    <Footer />
</template>
<script setup>
import { ref } from 'vue';
import ContactUsForm from "@/Components/ContactUs/ContactUsForm.vue";
import MassIntentionsForm from "@/Components/ContactUs/MassIntentionsForm.vue";
import SideBar from "@/Components/GuestSideBar/SideBar.vue";
import TopHeader from "@/Components/GuestNavBar/TopHeader.vue";
import NavBar from "@/Components/GuestNavBar/NavBar.vue";
import Footer from "@/Components/HomeSections/Footer.vue";
import PrayerRequest from "@/Components/ContactUs/PrayerRequest.vue";

const activeForm = ref('contact'); // default form
</script>
