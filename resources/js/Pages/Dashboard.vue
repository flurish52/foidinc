<template>
    <AuthenticatedLayout>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <UpdateIntentionStatus
                :isOpen="isModalOpen"
                :intention="selectedIntention"
                @close="isModalOpen = false"
                @update-status="handleStatusUpdate"
            />
            <div
                v-for="(card, index) in cardsData"
                :key="index"
                class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-tertiary-dark/10">
                <!-- Card Header -->
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-secondary-dark">{{ card.title }}</h3>
                    <div class="p-3 rounded-full" :class="card.bgColor">
                        <component :is="card.icon" class="w-5 h-5 text-white"/>
                    </div>
                </div>
                <!-- Main Content -->
                <div class="space-y-2">
                    <div v-if="card.type === 'donation'" class="space-y-1">
                        <p class="text-3xl font-bold text-primary">{{ card.count }}</p>
                        <p class="text-2xl font-semibold text-green-600">${{ card.amount?.toLocaleString() }}</p>
                        <p class="text-sm text-secondary-light">Total received</p>
                    </div>
                    <div v-else>
                        <p class="text-3xl font-bold text-primary">{{ card.count }}</p>
                        <p class="text-sm text-secondary-light">Total {{ card.title.toLowerCase() }}</p>
                    </div>
                </div>
                <!-- Progress Bar (Optional) -->
                <div v-if="card.percentage" class="mt-4">
                    <div class="w-full bg-tertiary-dark/20 rounded-full h-2">
                        <div
                            class="h-2 rounded-full transition-all duration-1000"
                            :class="card.progressColor"
                            :style="{ width: card.percentage + '%' }"
                        ></div>
                    </div>
                    <p class="text-xs text-secondary-light mt-1">{{ card.percentage }}% from last month</p>
                </div>
            </div>
        </div>

        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="mt-4">
                <SectionHeader class="text-gray-600" title="Recent Activities"/>
                <Tabsystem :items="tabItems" v-model="activeTab"/>

                <div class="mt-4 w-full">
                    <div v-if="activeTab === 'contacts'">
                        <h2 class="text-lg font-semibold">Contact messages</h2>
                        <RecentContactUsMessages :messages="recentContacts"/>
                    </div>
                    <div v-else-if="activeTab === 'intentions'">
                        <h2 class="text-lg font-semibold">Mass intention</h2>
                        <RecentMassIntentions :intentions="recentIntentions" />
                    </div>
                    <div v-else-if="activeTab === 'donations'">
                        <h2 class="text-lg font-semibold">Donations</h2>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
<script setup>
import {defineProps, ref} from 'vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const MassIcon = {template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>'}
const MessageIcon = {template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>'}
const DonationIcon = {template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'}
import Tabsystem from "@/Components/AdminDashboardTabs/Tabsystem.vue";
import SectionHeader from "@/Components/HomeSections/SectionHeader.vue";
import RecentContactUsMessages from "@/Components/ContactUs/RecentContactUsMessages.vue";
import RecentMassIntentions from "@/Components/ContactUs/RecentMassIntentions.vue";
import UpdateProfileInformationForm from "@/Pages/Profile/Partials/UpdateProfileInformationForm.vue";
import UpdateIntentionStatus from "@/Components/ContactUs/UpdateIntentionStatus.vue";

const props = defineProps({
    massIntentions: Number,
    contactMessages: Number,
    donationsTotal: Number,
    DonationAmounts: Number,
    recentContacts: Array,
    recentIntentions: Array,
})

const cardsData = ref([
    {
        title: 'Mass Intentions',
        count: props.massIntentions,
        type: 'count',
        icon: MassIcon,
        bgColor: 'bg-primary',
        percentage: 12,
        progressColor: 'bg-primary'
    },
    {
        title: 'Contact Messages',
        count: props.contactMessages,
        type: 'count',
        icon: MessageIcon,
        bgColor: 'bg-secondary',
        percentage: 8,
        progressColor: 'bg-secondary'
    },
    {
        title: 'Donations',
        count: 0,
        type: 'donation',
        amount: 0,
        icon: DonationIcon,
        bgColor: 'bg-green-500',
        percentage: 15,
        progressColor: 'bg-green-500'
    }
])
const activeTab = ref('contacts')
const tabItems = [
    {key: 'contacts', label: 'Contact messages'},
    {key: 'intentions', label: 'Mass intentions'},
    {key: 'donations', label: 'Donations'},
]
</script>
