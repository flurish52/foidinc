<template>
    <div class="w-full">
        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-hidden rounded-xl shadow-sm border border-tertiary-dark/20">
            <table class="w-full">
                <thead class="bg-tertiary-light">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">S/N</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">Name</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">Contact Info</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">Message</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-secondary-dark uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-tertiary-dark/10">
                <tr v-for="(message, index) in messages.data" :key="message.id" class="hover:bg-tertiary-light/30 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-secondary-dark">{{ index+1 }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-secondary-dark">{{ message.name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-secondary">{{ message.email }}</div>
                        <div v-if="message.phone" class="text-sm text-secondary-light">{{ message.phone }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-secondary-dark line-clamp-2">{{ message.message }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-secondary-light">{{ formatDate(message.created_at) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button @click="viewMessage(message)" class="text-primary hover:text-primary-dark mr-3">View</button>
                        <button @click="deleteMessage(message)" class="text-red-500 hover:text-red-700">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4">
            <div v-for="message in messages.data" :key="message.id" class="bg-white rounded-xl shadow-sm p-4 border border-tertiary-dark/10">
                <div class="flex justify-between items-start">
                    <h3 class="text-lg font-medium text-secondary-dark">{{ message.name }}</h3>
                    <span class="text-sm text-secondary-light">{{ formatDate(message.created_at) }}</span>
                </div>

                <div class="mt-2 space-y-1">
                    <div class="flex items-center text-sm text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ message.email }}
                    </div>

                    <div v-if="message.phone" class="flex items-center text-sm text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        {{ message.phone }}
                    </div>
                </div>

                <div class="mt-3">
                    <p class="text-sm text-secondary-dark line-clamp-3">{{ message.message }}</p>
                </div>

                <div class="mt-4 flex space-x-3">
                    <button @click="viewMessage(message)" class="flex-1 bg-primary text-white py-2 px-4 rounded-lg text-sm font-medium hover:bg-primary-dark transition-colors">
                        View Message
                    </button>
                    <button @click="deleteMessage(message)" class="flex-1 border border-red-500 text-red-500 py-2 px-4 rounded-lg text-sm font-medium hover:bg-red-50 transition-colors">
                        Delete
                    </button>
                </div>
            </div>
        </div>
        <!-- Pagination -->
        <div class="mt-6 flex items-center justify-between">
            <div class="text-sm text-secondary-light">
                Showing {{ messages.from }} to {{ messages.to }} of {{ messages.total }} results
            </div>

            <div class="flex space-x-2">
                <button
                    v-for="(link, index) in messages.links"
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
        <!-- Message Detail Modal -->
        <div v-if="selectedMessage" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-xl font-bold text-secondary-dark">Message Details</h2>
                        <button @click="selectedMessage = null" class="text-secondary-light hover:text-secondary-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-secondary-light">From</h3>
                            <p class="text-lg text-secondary-dark">{{ selectedMessage.name }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-sm font-medium text-secondary-light">Email</h3>
                                <p class="text-secondary-dark">{{ selectedMessage.email }}</p>
                            </div>

                            <div v-if="selectedMessage.phone">
                                <h3 class="text-sm font-medium text-secondary-light">Phone</h3>
                                <p class="text-secondary-dark">{{ selectedMessage.phone }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-secondary-light">Message</h3>
                            <p class="text-secondary-dark whitespace-pre-wrap">{{ selectedMessage.message }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-secondary-light">Received</h3>
                            <p class="text-secondary-dark">{{ formatDate(selectedMessage.created_at) }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button @click="selectedMessage = null" class="px-4 py-2 border border-secondary-light text-secondary-dark rounded-lg hover:bg-tertiary-light transition-colors">
                            Close
                        </button>
                        <button @click="deleteMessage(selectedMessage)" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                            Delete Message
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import {router} from "@inertiajs/vue3";

const props = defineProps({
    messages: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['paginate', 'delete'])

const selectedMessage = ref(null)

const viewMessage = (message) => {
    selectedMessage.value = message
}

const deleteMessage = (selectedMessage) => {
    if (confirm('Are you sure you want to delete this mass intention?')) {
        axios.delete(`/delete_contact_message/${selectedMessage.id}`)
            .then(res=>{
                if(res.status === 200){
                    alert(res.data.message)
                    router.visit(window.location.href, {preserveScroll: true})
                }
            })
            .catch(err =>{
                console.log(err)
                alert("Couldn't delete item, please try again")
            })
    }
}

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
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
