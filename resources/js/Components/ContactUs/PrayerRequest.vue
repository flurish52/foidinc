<template>
    <form @submit.prevent="submitForm" class="space-y-6 max-w-lg mx-auto p-6 bg-white rounded-lg shadow-sm">
        <HeaderSection title="Prayer Request" />

        <p class="text-green-600 font-medium">{{ message }}</p>
        <p class="text-red-600 font-medium">{{ error }}</p>

        <div class="space-y-1">
            <label class="block text-sm font-medium text-secondary-dark">First Name <span class="text-red-500">*</span></label>
            <input
                v-model="form.first_name"
                type="text"
                required
                placeholder="Enter your first name"
                class="w-full px-4 py-3 border border-tertiary-dark rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 placeholder-tertiary-dark"
            />
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-medium text-secondary-dark">Last Name <span class="text-red-500">*</span></label>
            <input
                v-model="form.last_name"
                type="text"
                required
                placeholder="Enter your last name"
                class="w-full px-4 py-3 border border-tertiary-dark rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 placeholder-tertiary-dark"
            />
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-medium text-secondary-dark">Email <span class="text-red-500">*</span></label>
            <input
                v-model="form.email"
                type="email"
                required
                placeholder="user@mydomain.com"
                class="w-full px-4 py-3 border border-tertiary-dark rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 placeholder-tertiary-dark"
            />
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-medium text-secondary-dark">Prayer Request <span class="text-red-500">*</span></label>
            <textarea
                v-model="form.prayer_request"
                rows="5"
                required
                placeholder="Type your prayer request here..."
                class="w-full px-4 py-3 border border-tertiary-dark rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 placeholder-tertiary-dark resize-none"
            ></textarea>
        </div>

        <p class="text-green-600 font-medium">{{ message }}</p>
        <p class="text-red-600 font-medium">{{ error }}</p>

        <button
            type="submit"
            class="w-full bg-primary text-white px-6 py-3 rounded-lg font-medium hover:bg-primary-dark transition-colors duration-200 focus:ring-2 focus:ring-offset-2 focus:ring-primary focus:outline-none"
        >
            Submit
        </button>
    </form>
</template>

<script setup>
import { ref } from 'vue'
import HeaderSection from '@/Components/DynamicPage/HeaderSection.vue'

const form = ref({
    first_name: '',
    last_name: '',
    email: '',
    prayer_request: ''
})

let message = ref('')
let error = ref('')

const submitForm = () => {
    axios.post('/prayer_request', form.value)
        .then(res => {
            message.value = res.data.message
            error.value = ''
            form.value = { first_name: '', last_name: '', email: '', prayer_request: '' }
        })
        .catch(err => {
            error.value = err?.response?.data?.message || 'Submission failed'
            message.value = ''
        })
}
</script>
