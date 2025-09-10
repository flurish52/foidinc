<template>
    <form @submit.prevent="submitForm" class="space-y-6 max-w-lg mx-auto p-6 bg-white rounded-lg shadow-sm">
        <HeaderSection title="Contact us" />
        <p class="text-green-600 font-medium">
            {{ message }}
        </p>
        <p class="text-red-600 font-medium">
            {{ error }}
        </p>
        <div class="space-y-1">
            <label class="block text-sm font-medium text-secondary-dark">First Name <span class="text-red-500">*</span></label>
            <input
                v-model="form.first_name"
                type="text"
                required
                class="w-full px-4 py-3 border border-tertiary-dark rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 placeholder-tertiary-dark"
                placeholder="Enter your first name"
            />
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-medium text-secondary-dark">Last Name <span class="text-red-500">*</span></label>
            <input
                v-model="form.last_name"
                type="text"
                required
                class="w-full px-4 py-3 border border-tertiary-dark rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 placeholder-tertiary-dark"
                placeholder="Enter your last name"
            />
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-medium text-secondary-dark">Phone Number</label>
            <input
                v-model="form.phone"
                type="tel"
                class="w-full px-4 py-3 border border-tertiary-dark rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 placeholder-tertiary-dark"
                placeholder="Enter your phone number"
            />
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-medium text-secondary-dark">Email <span class="text-red-500">*</span></label>
            <input
                v-model="form.email"
                type="email"
                required
                class="w-full px-4 py-3 border border-tertiary-dark rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 placeholder-tertiary-dark"
                placeholder="user@mydomain.com"
            />
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-medium text-secondary-dark">Message</label>
            <textarea
                v-model="form.message"
                rows="4"
                class="w-full px-4 py-3 border border-tertiary-dark rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 placeholder-tertiary-dark resize-none"
                placeholder="Type your message here..."
            ></textarea>
        </div>
        <p class="text-green-600 font-medium">
            {{ message }}
        </p>
        <p class="text-red-600 font-medium">
            {{ error }}
        </p>
        <button
            type="submit"
            class="w-full bg-primary text-white px-6 py-3 rounded-lg font-medium hover:bg-primary-dark transition-colors duration-200 focus:ring-2 focus:ring-offset-2 focus:ring-primary focus:outline-none"
        >
            Submit
        </button>
    </form>
</template>

<script setup>
import {ref} from 'vue';
import HeaderSection from "@/Components/DynamicPage/HeaderSection.vue";

const form = ref({
    first_name: '',
    last_name: '',
    phone: '',
    email: '',
    message: ''
});
let message = ref('')
let error = ref('')

const submitForm = () => {
    let formData = form.value
    axios.post('/contact_us', formData)
        .then(res=>{
            message.value = res.data.message
            form.value = {
                first_name: '',
                last_name: '',
                phone: '',
                email: '',
                message: ''
            }
        })
        .catch(err =>{
            if (err)
                error.value =  err.response.data.message
        });
};
</script>
