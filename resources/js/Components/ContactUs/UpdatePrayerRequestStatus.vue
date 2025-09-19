<template>
    <!-- Modal Background -->
    <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" @click.self="closeModal">
        <!-- Modal Container -->
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-primary text-white p-6">
                <h2 class="text-xl font-bold">Update Prayer request Status</h2>
                <p class="text-primary-light mt-1">Update the status for {{ prayerRequest?.first_name }} {{ prayerRequest?.last_name }}</p>
                <div v-if="message" class="p-2 text-sm font-medium text-green-700 bg-green-100 border border-green-300 rounded">
                    {{ message }}
                </div>

                <div v-if="error" class="p-2 mt-2 text-sm font-medium text-red-700 bg-red-100 border border-red-300 rounded">
                    {{ error }}
                </div>

            </div>

            <!-- Modal Content -->
            <div class="p-6">
                <!-- Status Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-secondary-dark mb-2">Select Status</label>
                    <div class="grid grid-cols-2 gap-3">
                        <button
                            v-for="option in statusOptions"
                            :key="option.value"
                            @click="selectedStatus = option.value"
                            class="p-3 rounded-lg border text-center transition-all duration-200"
                            :class="{
                'border-primary bg-primary/10 text-primary-dark': selectedStatus === option.value,
                'border-tertiary-dark/30 hover:border-primary/50': selectedStatus !== option.value
              }"
                        >
                            <span class="block text-sm font-medium">{{ option.label }}</span>
                        </button>
                    </div>
                </div>

                <!-- Additional Notes (optional) -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-secondary-dark mb-2">Notes (Optional)</label>
                    <textarea
                        v-model="notes"
                        rows="3"
                        placeholder="Add any additional notes here..."
                        class="w-full px-4 py-2 border border-tertiary-dark/30 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 resize-none"
                    ></textarea>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-tertiary-light px-6 py-4 flex justify-end space-x-3">
                <button
                    @click="closeModal"
                    class="px-4 py-2 border border-secondary-light text-secondary-dark rounded-lg hover:bg-white transition-colors"
                >
                    Cancel
                </button>
                <button
                    @click="submitUpdate"
                    class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="!selectedStatus"
                >
                    Update Status
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue'

const props = defineProps({
    isOpen: {
        type: Boolean,
        default: false
    },
    prayerRequest: {
        type: Object,
        default: null
    }
})

const emit = defineEmits(['close', 'update-status'])

// Status options with colors and labels
const statusOptions = [
    { value: 'pending', label: 'Pending', color: 'bg-yellow-100 text-yellow-800' },
    { value: 'approved', label: 'Approved', color: 'bg-blue-100 text-blue-800' },
    { value: 'rejected', label: 'Reject', color: 'bg-red-100 text-red-800' },
    { value: 'fulfilled', label: 'Fulfilled', color: 'bg-green-100 text-green-800' }
]

const selectedStatus = ref('')
const notes = ref('')
let message = ref('')
let error = ref('')

// Show notes field for rejected status
const showNotesField = computed(() => selectedStatus.value === 'rejected')

// Watch for modal opening and reset form
watch(() => props.isOpen, (newVal) => {
    if (newVal) {
        selectedStatus.value = props.intention?.status || ''
        notes.value = ''
    }
})

// Close modal handler
const closeModal = () => {
    emit('close')
}

// Submit status update
const submitUpdate = () => {
    if (!selectedStatus.value) return
    let formData = {
        prayerRequest: props.prayerRequest?.id,
        status: selectedStatus.value,
        notes: notes.value
    }
    console.log(props.prayerRequest.id)
    axios.patch('/update_prayer_request/status', formData)
        .then(res=>{
            if (res.status === 200){
                message.value =  res.data.message
                error.value = ''

                setTimeout(()=>{
                    closeModal()
                    message.value = ''
                    selectedStatus.value = ''
                    notes.value = ''
                    emit('update-status')
                }, 3000)
            }
        })
        .catch(err =>{
            if (err){
                error.value = err.response.data.message
                message.value = ''
            }
        })
}
</script>
