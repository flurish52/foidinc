<template>
    <AuthenticatedLayout>
        <div class="p-6 space-y-8">
        <!-- Header -->
        <div>
            <h1 class="text-3xl font-bold text-secondary-dark">Mass Intentions Dashboard</h1>
            <p class="text-secondary-light mt-2">Overview of all mass intention requests and their status</p>
        </div>

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Intentions Card -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-primary">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-secondary-light">Total Intentions</p>
                        <p class="text-3xl font-bold text-secondary-dark mt-1">{{ stats.total }}</p>
                    </div>
                    <div class="p-3 bg-primary/10 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-secondary-light mt-3">All mass intention requests</p>
            </div>

            <!-- Pending Card -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-secondary-light">Pending</p>
                        <p class="text-3xl font-bold text-secondary-dark mt-1">{{ stats.pending }}</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-secondary-light mt-3">Awaiting review</p>
            </div>

            <!-- Approved Card -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-secondary-light">Approved</p>
                        <p class="text-3xl font-bold text-secondary-dark mt-1">{{ stats.approved }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-secondary-light mt-3">Approved intentions</p>
            </div>

            <!-- Fulfilled Card -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-secondary-light">Fulfilled</p>
                        <p class="text-3xl font-bold text-secondary-dark mt-1">{{ stats.fulfilled }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-secondary-light mt-3">Completed intentions</p>
            </div>
        </div>

        <!-- Recent Intentions Section -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-tertiary-dark/10">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-secondary-dark">Recent Mass Intentions</h2>
                    <button class="text-primary hover:text-primary-dark text-sm font-medium">
                        View All
                    </button>
                </div>
            </div>

            <!-- Intentions Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-tertiary-light">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">Requester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-tertiary-dark/10">
                    <tr v-for="intention in recentIntentions" :key="intention.id" class="hover:bg-tertiary-light/30 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0 bg-primary/10 rounded-full flex items-center justify-center">
                                    <span class="text-primary font-medium">{{ getInitials(intention.first_name, intention.last_name) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-secondary-dark">{{ intention.first_name }} {{ intention.last_name }}</div>
                                    <div class="text-sm text-secondary-light">{{ intention.email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-secondary-dark">{{ formatDate(intention.created_at) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-secondary-dark">{{ intention.city }}</div>
                            <div class="text-sm text-secondary-light">{{ intention.state }} {{ intention.zip }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium capitalize"
                      :class="getStatusClass(intention.status)">
                  {{ intention.status }}
                </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-primary hover:text-primary-dark mr-3">View</button>
                            <button class="text-secondary hover:text-secondary-dark">Edit</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div v-if="recentIntentions.length === 0" class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-tertiary-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-secondary-dark">No mass intentions</h3>
                <p class="mt-1 text-sm text-secondary-light">Get started by creating a new mass intention.</p>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { computed } from 'vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    massIntentions: {
        type: Array,
        default: () => []
    }
})

// Calculate stats from intentions
const stats = computed(() => {
    return {
        total: props.massIntentions.data.length,
        pending: props.massIntentions.data.filter(i => i.status === 'pending').length,
        approved: props.massIntentions.data.filter(i => i.status === 'approved').length,
        fulfilled: props.massIntentions.data.filter(i => i.status === 'fulfilled').length,
        rejected: props.massIntentions.data.filter(i => i.status === 'rejected').length
    }
})

// Get recent intentions (last 5)
const recentIntentions = computed(() => {
    return [...props.massIntentions.data]
        .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
        .slice(0, 5)
})

// Get status badge class
const getStatusClass = (status) => {
    const statusClasses = {
        pending: 'bg-yellow-100 text-yellow-800',
        approved: 'bg-blue-100 text-blue-800',
        fulfilled: 'bg-green-100 text-green-800',
        rejected: 'bg-red-100 text-red-800'
    }
    return statusClasses[status] || 'bg-gray-100 text-gray-800'
}

// Format date
const formatDate = (dateString) => {
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}

// Get user initials
const getInitials = (firstName, lastName) => {
    return `${firstName.charAt(0)}${lastName.charAt(0)}`.toUpperCase()
}
</script>
