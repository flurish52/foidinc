<template>
    <AuthenticatedLayout>
        <Head title="Register" />

        <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900">
            <div class="w-full max-w-md">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Add staff</h2>
                </div>

                <!-- Form Card -->
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border border-gray-100 dark:border-gray-700">
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Name Field -->
                        <div>
                            <InputLabel for="name" value="Full Name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" />

                            <TextInput
                                id="name"
                                type="text"
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors"
                                placeholder="Enter your full name"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                            />

                            <InputError class="mt-2 text-sm text-red-600 dark:text-red-400" :message="form.errors.name" />
                        </div>

                        <!-- Email Field -->
                        <div>
                            <InputLabel for="email" value="Email Address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" />

                            <TextInput
                                id="email"
                                type="email"
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors"
                                placeholder="your.email@example.com"
                                v-model="form.email"
                                required
                                autocomplete="email"
                            />

                            <InputError class="mt-2 text-sm text-red-600 dark:text-red-400" :message="form.errors.email" />
                        </div>

                        <!-- Password Field -->
                        <div>
                            <InputLabel for="password" value="Password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" />

                            <TextInput
                                id="password"
                                type="password"
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors"
                                placeholder="Create a strong password"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                            />

                            <InputError class="mt-2 text-sm text-red-600 dark:text-red-400" :message="form.errors.password" />
                        </div>

                        <!-- Confirm Password Field -->
                        <div>
                            <InputLabel
                                for="password_confirmation"
                                value="Confirm Password"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                            />

                            <TextInput
                                id="password_confirmation"
                                type="password"
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors"
                                placeholder="Confirm your password"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                            />

                            <InputError
                                class="mt-2 text-sm text-red-600 dark:text-red-400"
                                :message="form.errors.password_confirmation"
                            />
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between mt-8">

                            <PrimaryButton
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-medium rounded-lg shadow-sm transition-all duration-200 transform hover:-translate-y-0.5"
                                :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                                :disabled="form.processing"
                            >
                                <span v-if="!form.processing">Create user</span>
                                <span v-else class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Processing...
                                </span>
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
                </div>
            </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onSuccess: () => {
            alert('Staff added successfully!');
            form.reset('name', 'email', 'password', 'password_confirmation');
        }
    });
};

</script>
