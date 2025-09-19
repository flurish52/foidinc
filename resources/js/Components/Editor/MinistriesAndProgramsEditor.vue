<template>
    <section class="py-6 max-w-5xl mx-auto space-y-6">
        <!-- Form Row -->
        <div class="flex gap-3 items-center border p-4 rounded">
            <input v-model="newCard.title" placeholder="Card Title" class="border p-2 rounded flex-1"/>

            <select v-model="newCard.page_id" class="border p-2 rounded flex-1">
                <option value="">Select Page</option>
                <option v-for="page in $page.props.links" :key="page.id" :value="page.id">
                    {{ page.title }}
                </option>
            </select>

            <input type="file" @change="onFileChange" ref="fileInput" class="hidden"/>
            <button @click="$refs.fileInput.click()" class="px-2 py-1 bg-gray-200 rounded">Upload</button>
            <img v-if="newCard.preview && editingCard === null" :src="newCard.preview"
                 class="w-16 h-16 object-cover rounded"/>
            <img v-else :src="`/storage/${newCard.preview}`" class="w-16 h-16 object-cover rounded"/>

            <button v-if="editingCard === null" @click="addCard" class="px-3 py-1 bg-indigo-600 text-white rounded">
                Add
            </button>
            <button v-else @click="updateCard" class="px-3 py-1 bg-indigo-600 text-white rounded">update</button>
        </div>

        <!-- Cards List -->
        <div v-if="cards?.length" class="space-y-3">
            <div
                v-for="card in cards"
                :key="card.id"
                class="flex items-center justify-between border p-4 rounded"
            >
                <div class="flex items-center gap-4">
                    <img v-if="card.thumbnail" :src="'/storage/' + card.thumbnail"
                         class="w-16 h-16 object-cover rounded"/>
                    <div>
                        <p class="font-medium">{{ card.title }}</p>
                        <p class="text-sm text-gray-500">{{ card.page?.title }}</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button @click="editCard(card)" class="px-3 py-1 bg-blue-500 text-white rounded">Edit</button>
                    <button @click="deleteCard(card.id)" class="px-3 py-1 bg-red-500 text-white rounded">Delete</button>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import {ref, onMounted} from 'vue'
import axios from 'axios';
import {router, useForm} from "@inertiajs/vue3";

const cards = ref([])
const newCard = ref({title: '', page_id: '', file: null, preview: ''})

onMounted(async () => {
    const res = await axios.get('/projects')
    cards.value = res.data.cards
})

const onFileChange = (event) => {
    const file = event.target.files[0]
    if (!file) return
    newCard.value.file = file
    newCard.value.preview = URL.createObjectURL(file)
}

const addCard = async () => {
    if (!newCard.value.title || !newCard.value.page_id) return

    const formData = new FormData()
    formData.append('title', newCard.value.title)
    formData.append('page_id', newCard.value.page_id)
    if (newCard.value.file) {
        formData.append('thumbnail', newCard.value.file)
    }

    const res = await axios.post('/project/store', formData, {
        headers: {'Content-Type': 'multipart/form-data'}
    })

    cards.value = res.data.cards
    newCard.value = {title: '', page_id: '', file: null, preview: ''}
}


const editingCard = ref(null)

const editCard = (card) => {
    editingCard.value = card.id
    newCard.value.id = card.id
    newCard.value.title = card.title
    newCard.value.page_id = card.page?.id
    newCard.value.preview = card.thumbnail
    newCard.value.thumbnail = null

}

const updateCard = () => {
    const form = useForm({
        id: newCard.value.id,
        title: newCard.value.title,
        page_id: newCard.value.page_id,
        thumbnail: newCard.value.thumbnail
    })

    form.post(route('projects.update', newCard.value.id), {
        forceFormData: true,
        onSuccess: () => {
            editingCard.value = null
            newCard.value = {id: null, title: '', page_id: '', thumbnail: null, preview: null}
            router.visit(window.location.href, {preserveScroll: true})
        }
    })
}


const deleteCard = async (id) => {
    await axios.delete(`/project/${id}`)
    cards.value = cards.value.filter((c) => c.id !== id)
}
</script>
