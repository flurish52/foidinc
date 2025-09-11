<template>
    <AuthenticatedLayout>
        <div class="p-6 space-y-8">
            <!-- Header -->
            <div>
                <h1 class="text-3xl font-bold text-secondary-dark">Contact Messages</h1>
                <p class="text-secondary-light mt-2">Manage all incoming contact form messages</p>
            </div>

            <!-- Stats Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Messages Card -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-primary">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-secondary-light">Total Messages</p>
                            <p class="text-3xl font-bold text-secondary-dark mt-1">{{ contactMessages.total }}</p>
                        </div>
                        <div class="p-3 bg-primary/10 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-secondary-light mt-3">All contact messages</p>
                </div>

                <!-- Unread Card -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-secondary-light">Unread</p>
                            <p class="text-3xl font-bold text-secondary-dark mt-1">{{ unreadCount }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-secondary-light mt-3">Require attention</p>
                </div>

                <!-- This Week Card -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-secondary-light">This Week</p>
                            <p class="text-3xl font-bold text-secondary-dark mt-1">{{ thisWeekCount }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-secondary-light mt-3">Recent messages</p>
                </div>

                <!-- With Phone Card -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-secondary-light">With Phone</p>
                            <p class="text-3xl font-bold text-secondary-dark mt-1">{{ withPhoneCount }}</p>
                        </div>
                        <div class="p-3 bg-purple-100 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-secondary-light mt-3">Include phone number</p>
                </div>
            </div>

            <!-- Messages Section -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-tertiary-dark/10 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-secondary-dark">Recent Messages</h2>
                    <div class="flex space-x-2">
                        <button
                            class="px-3 py-1.5 text-sm border border-tertiary-dark/30 rounded-lg hover:bg-tertiary-light transition-colors">
                            Filter
                        </button>
                        <button
                            class="px-3 py-1.5 text-sm border border-tertiary-dark/30 rounded-lg hover:bg-tertiary-light transition-colors">
                            Sort
                        </button>
                    </div>
                </div>

                <!-- Messages List -->
                <RecentContactUsMessages :messages="contactMessages"/>

                <!-- Empty State -->
                <div v-if="contactMessages.data.length === 0" class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-tertiary-dark" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-secondary-dark">No messages yet</h3>
                    <p class="mt-1 text-sm text-secondary-light">All contact messages will appear here.</p>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {computed} from 'vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import RecentContactUsMessages from "@/Components/ContactUs/RecentContactUsMessages.vue";

const props = defineProps({
    contactMessages: {
        type: Object,
        required: true,
        default: () => ({
            data: [],
            total: 0,
            from: 0,
            to: 0,
            links: []
        })
    }
})

const emit = defineEmits(['paginate'])

// Calculate stats (these would ideally come from the backend)
const unreadCount = computed(() => {
    return props.contactMessages.data.filter(msg => !msg.read).length
})

const thisWeekCount = computed(() => {
    const oneWeekAgo = new Date()
    oneWeekAgo.setDate(oneWeekAgo.getDate() - 7)
    return props.contactMessages.data.filter(msg => new Date(msg.created_at) > oneWeekAgo).length
})

const withPhoneCount = computed(() => {
    return props.contactMessages.data.filter(msg => msg.phone).length
})

// Format date
const formatDate = (dateString) => {
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}

// Get user initials
const getInitials = (name) => {
    if (!name) return '?'
    return name.split(' ').map(n => n.charAt(0)).join('').toUpperCase().substring(0, 2)
}
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
