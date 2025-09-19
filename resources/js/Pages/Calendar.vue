<template>
    <AuthenticatedLayout>
        <div class="p-6">
            <h1 class="text-xl font-bold mb-4">Manage Calendar</h1>

            <!-- Success Message -->
            <div
                v-if="$page.props?.flash?.success"
                class="p-2 bg-green-200 text-green-800 rounded mb-4"
            >
                {{ $page.props.flash.success }}
            </div>

            <!-- Form -->
            <form v-if="form" @submit.prevent="submit" class="space-y-4 mb-6">
                <div>
                    <label class="block mb-1 font-medium">Event Title</label>
                    <input v-model="form.title" type="text" class="w-full border rounded p-2" />
                </div>

                <div>
                    <label class="block mb-1 font-medium">Date</label>
                    <input v-model="form.date" type="date" class="w-full border rounded p-2" />
                </div>

                <div>
                    <label class="block mb-1 font-medium">Description</label>
                    <textarea v-model="form.description" class="w-full border rounded p-2"></textarea>
                </div>

                <div v-if="$page.props?.pages && $page.props.pages.length">
                    <label class="block mb-1 font-medium">Select Page</label>
                    <select v-model="form.page_id" class="w-full border rounded p-2">
                        <option value="">-- Choose a Page --</option>
                        <option v-for="page in $page.props.pages" :key="page.id" :value="page.id">
                            {{ page.title }}
                        </option>
                    </select>
                </div>

                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">
                    Create Event
                </button>
            </form>

            <!-- Events -->
            <div v-if="$page.props?.events && $page.props.events.length">
                <h2 class="text-lg font-bold mb-2">Events</h2>
                <ul class="space-y-2">
                    <li
                        v-for="event in $page.props.events"
                        :key="event.id"
                        class="border p-2 rounded"
                    >
                        <strong>{{ event.title }}</strong>
                        <span v-if="event.date"> - {{ event.date }}</span>
                        <span v-if="event.page"> (Page: {{ event.page.title }})</span>
                        <p v-if="event.description">{{ event.description }}</p>
                    </li>
                </ul>
            </div>
            <div v-else class="text-gray-500">No events available</div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const form = useForm({
    title: '',
    date: '',
    description: '',
    page_id: ''
})

const submit = () => {
    form.post(route('calendar.store'))
}
</script>
