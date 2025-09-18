<template>
    <AuthenticatedLayout>
        <div class="p-6">
            <h1 class="text-xl font-bold mb-4">Upload Newsletter</h1>

            <div v-if="successMessage" class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ successMessage }}
            </div>

            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block mb-1 font-medium">Title</label>
                    <input v-model="form.title" type="text" class="w-full border rounded p-2" />
                </div>

                <div>
                    <label class="block mb-1 font-medium">Select Page</label>
                    <select v-model="form.page_id" class="w-full border rounded p-2">
                        <option value="">-- Choose a Page --</option>
                        <template v-for="page in $page.props.links" :key="page.id">
                            <option :value="page.id">
                                {{ page.title }}
                            </option>
                            <template v-if="page.children && page.children.length">
                                <PageOptions :children="page.children" :prefix="'-'" />
                            </template>
                        </template>
                    </select>
                </div>


                <div>
                    <label class="block mb-1 font-medium">PDF File</label>
                    <input type="file" @change="handleFile" accept="application/pdf" />
                </div>

                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">
                    Upload
                </button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import PageOptions from "@/Components/NewsLetters/PageOptions.vue";

const { props } = usePage()
const pages = props.pages || []

// Format today's date as "September 18, 2025"
const today = new Date()
const defaultTitle = today.toLocaleDateString('en-US', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
})

const form = useForm({
    title: defaultTitle,
    page_id: '',
    file: null,
})

const successMessage = ref('')

const handleFile = (e) => {
    form.file = e.target.files[0]
}

const submit = () => {
    form.post(route('newsletters.store'), {
        onSuccess: () => {
            successMessage.value = 'Newsletter uploaded successfully.'
            resetForm()
            setTimeout(() => {
                successMessage.value = ''
            }, 3000)
        },
        onError: () => {
            successMessage.value = 'Something went wrong. Please try again.'
            setTimeout(() => {
                successMessage.value = ''
            }, 3000)
        },
    })
}


const resetForm = () => {
    form.reset()
    form.title = defaultTitle
}
</script>
