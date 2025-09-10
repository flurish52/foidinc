<template>
        <form @submit.prevent="submitForm" class="space-y-6 max-w-lg mx-auto p-6 bg-white rounded-lg shadow-sm">
            <HeaderSection title="Mass Intentions" />
            <p class="text-secondary-dark mb-6 leading-relaxed">
                If you would like us to offer a Mass for your specific intentions, kindly fill out the form below.
                You can make a donation on our secure online donation page.
            </p>
            <p class="text-green-600 font-medium">
                {{ message }}
            </p>
            <p class="text-red-600 font-medium">
                {{ error }}
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-secondary-dark">First Name <span class="text-red-500">*</span></label>
                    <input
                        v-model="form.first_name"
                        type="text"
                        required
                        class="w-full px-4 py-3 border border-tertiary-dark rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 placeholder-tertiary-dark"
                        placeholder="Enter first name"
                    />
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-secondary-dark">Last Name <span class="text-red-500">*</span></label>
                    <input
                        v-model="form.last_name"
                        type="text"
                        required
                        class="w-full px-4 py-3 border border-tertiary-dark rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 placeholder-tertiary-dark"
                        placeholder="Enter last name"
                    />
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-medium text-secondary-dark">City <span class="text-red-500">*</span></label>
                <input
                    v-model="form.city"
                    type="text"
                    required
                    class="w-full px-4 py-3 border border-tertiary-dark rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 placeholder-tertiary-dark"
                    placeholder="Enter your city"
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-secondary-dark">State</label>
                    <select
                        v-model="form.state"
                        class="w-full px-4 py-3 border border-tertiary-dark rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 appearance-none bg-white"
                    >
                        <option value="">Select State</option>
                        <option value="AK">AK</option>
                        <!-- Add more states as needed -->
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-secondary-dark">Zip</label>
                    <input
                        v-model="form.zip"
                        type="text"
                        class="w-full px-4 py-3 border border-tertiary-dark rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 placeholder-tertiary-dark"
                        placeholder="Enter zip code"
                    />
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-medium text-secondary-dark">Phone Number</label>
                <input
                    v-model="form.phone"
                    type="tel"
                    class="w-full px-4 py-3 border border-tertiary-dark rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 placeholder-tertiary-dark"
                    placeholder="Enter phone number"
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
                <label class="block text-sm font-medium text-secondary-dark">Mass Intention Details</label>
                <textarea
                    v-model="form.details"
                    rows="4"
                    class="w-full px-4 py-3 border border-tertiary-dark rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors duration-200 placeholder-tertiary-dark resize-none"
                    placeholder="Please provide the details of your Mass intention"
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
import {reactive, ref} from 'vue';
import HeaderSection from "@/Components/DynamicPage/HeaderSection.vue";

const form = ref({
    first_name: '',
    last_name: '',
    city: '',
    state: '',
    zip: '',
    phone: '',
    email: '',
    details: ''
});
let message = ref('')
let error = ref('')

const submitForm = () => {
    let formData = form.value
    axios.post('/mass_intentions', formData)
        .then(res=>{
           message.value = res.data.message
            form.value = {
                first_name: '',
                last_name: '',
                city: '',
                state: '',
                zip: '',
                phone: '',
                email: '',
                details: ''
            }
        })
        .catch(err =>{
            if (err)
           error.value =  err.response.data.message
        });
};
</script>
