<template>
    <UpdatePrayerRequestStatus
        :isOpen="isModalOpen"
        :prayerRequest="selectedRequest"
        @close="isModalOpen = false"
        @update-status="handleStatusUpdate"
    />

    <div class="w-full">
        <!-- Desktop Table View -->
        <div v-if="prayerRequests?.data?.length" class="hidden md:block overflow-hidden rounded-xl shadow-sm border border-tertiary-dark/20">
            <table class="w-full">
                <thead class="bg-tertiary-light">
                <tr>
                    <th class="py-4 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">S/N</th>
                    <th class="px-2 py-4 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">Requester</th>
                    <th class="px-2 py-4 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">Contact Info</th>
                    <th class="px-2 py-4 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">Prayer Request</th>
                    <th class="px-2 py-4 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">Status</th>
                    <th class="px-2 py-4 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">Date</th>
                    <th class="px-2 py-4 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-tertiary-dark/10">
                <tr v-for="(request, index) in prayerRequests.data" :key="request.id" class="hover:bg-tertiary-light/30 transition-colors duration-150">
                    <td class="px-2 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-secondary-dark">{{ index + 1 }}</div>
                    </td>
                    <td class="px-2 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-secondary-dark">{{ request.first_name }} {{ request.last_name }}</div>
                    </td>
                    <td class="px-2 py-4 whitespace-nowrap">
                        <div class="text-sm text-secondary-dark">{{ request.email }}</div>
                    </td>
                    <td class="px-2 py-4">
                        <div class="text-sm text-secondary-dark line-clamp-2">{{ request.prayer_request }}</div>
                    </td>
                    <td class="px-2 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium capitalize" :class="statusClasses[request.status]">
                                {{ request.status }}
                            </span>
                    </td>
                    <td class="px-2 py-4 whitespace-nowrap">
                        <div class="text-sm text-secondary-light">{{ formatDate(request.created_at) }}</div>
                    </td>
                    <td class="px-2 py-4 whitespace-nowrap text-sm font-medium">
                        <button @click="viewRequest(request)" class="text-primary hover:text-primary-dark mr-3">View</button>
                        <button @click="updateStatus(request)" class="text-secondary hover:text-secondary-dark mr-3">Status</button>
                        <button @click="deleteRequest(request)" class="text-red-500 hover:text-red-700">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div v-if="prayerRequests?.data?.length" class="md:hidden space-y-4">
            <div v-for="request in prayerRequests.data" :key="request.id" class="bg-white rounded-xl shadow-sm p-4 border border-tertiary-dark/10">
                <div class="flex justify-between items-start">
                    <h3 class="text-lg font-medium text-secondary-dark">{{ request.first_name }} {{ request.last_name }}</h3>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium capitalize" :class="statusClasses[request.status]">
                        {{ request.status }}
                    </span>
                </div>

                <div class="mt-2">
                    <p class="text-sm text-secondary-dark line-clamp-3">{{ request.prayer_request }}</p>
                </div>

                <div class="mt-4 flex space-x-3">
                    <button @click="viewRequest(request)" class="flex-1 bg-primary text-white py-2 px-4 rounded-lg text-sm font-medium hover:bg-primary-dark transition-colors">View Details</button>
                    <button @click="deleteRequest(request)" class="flex-1 border border-red-500 text-red-500 py-2 px-4 rounded-lg text-sm font-medium hover:bg-red-50 transition-colors">Delete</button>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="prayerRequests?.links?.length" class="mt-6 flex items-center justify-between">
            <div class="text-sm text-secondary-light">
                Showing {{ prayerRequests.from }} to {{ prayerRequests.to }} of {{ prayerRequests.total }} results
            </div>

            <div class="flex space-x-2">
                <button
                    v-for="(link, index) in prayerRequests.links"
                    :key="index"
                    @click="link.url && $emit('paginate', link.url)"
                    class="px-3 py-1 rounded-lg text-sm font-medium transition-colors"
                    :class="{
                        'bg-primary text-white': link.active,
                        'text-secondary-dark hover:bg-tertiary-light': !link.active && link.url,
                        'text-secondary-light cursor-not-allowed': !link.url
                    }"
                    v-html="link.label"
                ></button>
            </div>
        </div>

        <!-- Prayer Request Detail Modal -->
        <div v-if="selectedRequest" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-40">
            <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-xl font-bold text-secondary-dark">Prayer Request Details</h2>
                        <button @click="selectedRequest = null" class="text-secondary-light hover:text-secondary-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-secondary-light">Requester</h3>
                            <p class="text-lg text-secondary-dark">{{ selectedRequest.first_name }} {{ selectedRequest.last_name }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-secondary-light">Email</h3>
                            <p class="text-secondary-dark">{{ selectedRequest.email }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-secondary-light">Prayer Request</h3>
                            <p class="text-secondary-dark whitespace-pre-wrap">{{ selectedRequest.prayer_request }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-sm font-medium text-secondary-light">Status</h3>
                                <p class="text-secondary-dark capitalize">{{ selectedRequest.status }}</p>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-secondary-light">Submitted</h3>
                                <p class="text-secondary-dark">{{ formatDate(selectedRequest.created_at) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button @click="selectedRequest = null" class="px-4 py-2 border border-secondary-light text-secondary-dark rounded-lg hover:bg-tertiary-light transition-colors">Close</button>
                        <button @click="updateStatus(selectedRequest)" class="px-4 py-2 bg-secondary text-white rounded-lg hover:bg-secondary-dark transition-colors">Update Status</button>
                        <button @click="deleteRequest(selectedRequest)" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import UpdatePrayerRequestStatus from "@/Components/ContactUs/UpdatePrayerRequestStatus.vue";

const props = defineProps({
    prayerRequests: {
        type: Object,
        required: true
    }
})

const isModalOpen = ref(false)
const selectedRequest = ref(null)

const statusClasses = {
    pending: 'bg-yellow-100 text-yellow-800',
    approved: 'bg-blue-100 text-blue-800',
    rejected: 'bg-red-100 text-red-800',
    fulfilled: 'bg-green-100 text-green-800'
}

const openModal = (request) => {
    isModalOpen.value = true
}

const viewRequest = (request) => {
    selectedRequest.value = request
}

const updateStatus = (request) => {
    selectedRequest.value = request
    openModal(request)
}

const handleStatusUpdate = () => {
    selectedRequest.value = null
    router.visit(window.location.href, { preserveScroll: true })
}

const deleteRequest = (request) => {
    if (confirm('Are you sure you want to delete this prayer request?')) {
        axios.delete(`/prayer_request/${request.id}`)
            .then(res => {
                if (res.status === 200) alert(res.data.message)
            })
            .catch(() => alert("Couldn't delete item, please try again"))
    }
}

const formatDate = (dateString) => {
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })
}
</script>
