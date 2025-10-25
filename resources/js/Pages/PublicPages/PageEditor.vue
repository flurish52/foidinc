<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50">
            <!-- Header -->
            <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <!-- Left side -->
                        <div class="flex items-center space-x-4">
                            <h1 class="text-lg font-semibold text-gray-900">
                                {{ isEditing ? 'Edit Page' : 'New Page' }}
                            </h1>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 rounded-full" :class="autoSaveStatus === 'saved' ? 'bg-green-400' : autoSaveStatus === 'saving' ? 'bg-yellow-400' : 'bg-gray-300'"></div>
                                <span class="text-sm text-gray-500">
                  {{ autoSaveText }}
                </span>
                            </div>
                        </div>

                        <!-- Right side -->
                        <div class="flex items-center space-x-3">
                            <button
                                @click="saveDraft"
                                :disabled="saving"
                                class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
                            >
                                {{ saving ? 'Saving...' : 'Save' }}
                            </button>
                            <button
                                @click="publish"
                                :disabled="saving || !page.title || !content"
                                class="px-4 py-1.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                {{ page.status === 'published' ? 'Update' : 'Publish' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div v-if="!showPreview" class="space-y-6">
                    <!-- Article Title -->
                    <div>
            <textarea
                v-model="page.title"
                placeholder="Page title..."
                class="w-full text-4xl font-bold text-gray-900 placeholder-gray-400 border-none resize-none overflow-hidden bg-transparent focus:outline-none focus:ring-0"
                rows="1"
                ref="titleInput"
                @input="autoResize"
            ></textarea>
                    </div>

                    <!-- Article Meta -->
                    <div class="flex items-center justify-around space-x-4 text-sm text-gray-500 pb-4 border-b border-gray-200">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ formatDate(page.updated_at || new Date()) }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 rounded-full" :class="page.status === 'published' ? 'bg-green-500' : 'bg-yellow-500'"></div>
                            <span class="capitalize">{{ page.status || 'draft' }}</span>
                        </div>
                        <!-- Parent Page Select -->
                        <div class="mt-4">
                            <label for="parent" class="block text-sm font-medium text-gray-700">Parent Page</label>
                            <select
                                id="parent"
                                v-model="page.parent_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >
                                <option value="">None</option>
                                <option
                                    v-for="link in $page.props.links"
                                    :key="link.id"
                                    :value="link.id"
                                >
                                    {{ link.title }}
                                </option>
                            </select>
                        </div>

                        <!-- Main nav select -->
                        <div class="mt-4">
                            <label for="parent" class="block text-sm font-medium text-gray-700">Main nav?</label>
                            <select
                                id="parent"
                                v-model="page.main"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >
                                <option value="0"  selected>No</option>
                                <option value="1" > Yes </option>
                            </select>
                        </div>
                        <!-- page position -->
                        <div class="mt-4">
                            <label for="parent" class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                            <input
                                type="number"
                                v-model="page.position"
                                id="parent"
                                class="w-full rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 text-sm text-gray-800"
                                placeholder="Enter a number"
                            >
                        </div>
                    </div>
                    <!-- Rich Text Editor -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <RichEditor
                            v-model="page.content"
                            upload-url="/api/upload-image"
                            class="min-h-[600px]"
                        />
                    </div>

                    <div>
                        <SlidersEditor  v-model="sliders" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, watch, onMounted, nextTick } from 'vue'
import axios from 'axios'
import RichEditor from "@/Components/GuestNavBar/RichEditor.vue"
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import SlidersEditor from "@/Components/Editor/SlidersEditor.vue"
import {router} from "@inertiajs/vue3";

// Props
const props = defineProps({
    page: Object
})

// Determine editing mode
const isEditing = ref(!!props.page)

// Initialize page dynamically
const page = ref({
    id: props.page?.id || null,
    parent_id: props.page?.parent_id || '',
    title: props.page?.title || '',
    slug: props.page?.slug || '',
    thumbnail: props.page?.thumbnail || null,
    sliders: props.page?.sliders || '[]',
    status: props.page?.status || 'draft',
    content: props.page?.content || '',
    main: props.page?.main || 0,
    position: props.page?.position || 0,
})

// Initialize sliders safely
const sliders = ref([])
try {
    sliders.value = page.value.sliders ? JSON.parse(page.value.sliders) : []
} catch {
    sliders.value = []
}

// Initialize content ref for editor
const content = ref(page.value.content || '')

// Auto-resize title
const titleInput = ref(null)
const autoResize = () => {
    nextTick(() => {
        if (titleInput.value) {
            titleInput.value.style.height = 'auto'
            titleInput.value.style.height = titleInput.value.scrollHeight + 'px'
        }
    })
}
watch(() => page.value.title, autoResize)

// Word count
const wordCount = computed(() => {
    const text = content.value.replace(/<[^>]*>/g, '').trim()
    return text ? text.split(/\s+/).length : 0
})

// Auto-save status
const autoSaveStatus = ref('saved') // 'saved', 'saving', 'error'
const autoSaveText = computed(() => {
    switch (autoSaveStatus.value) {
        case 'saving': return 'Saving...'
        case 'saved': return 'All changes saved'
        case 'error': return 'Error saving'
        default: return 'Not saved'
    }
})

// Format date
const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric', month: 'long', day: 'numeric',
        hour: '2-digit', minute: '2-digit'
    })
}

// Toggle preview
const showPreview = ref(false)
// Watch sliders to update page.sliders
watch(sliders, (val) => {
    page.value.sliders = JSON.stringify(val || [])
}, { deep: true })

// Save functions
const saveDraft = async () => {
    await savePage()
}

const publish = async () => {
    if (!page.value.title || !content.value) {
        alert('Title and content are required')
        return
    }
    page.value.status = 'published'
    const response = await axios.patch(`/admin/update_status/${page.value.slug}`, {status: page.value.status})
    if (!response?.data) throw new Error('No response data received')
    router.visit(`/admin/edit_page/${page.value.slug}`)


}

const saving = ref(false)
const savePage = async () => {
    saving.value = true
    autoSaveStatus.value = 'saving'
    try {
        const formData = new FormData()
        formData.append('title', page.value.title || '')
        formData.append('content', page.value.content || '')
        formData.append('status', page.value.status || 'draft')
        formData.append('thumbnail', page.value.thumbnail || '')
        formData.append('parent_id', page.value.parent_id || '')
        formData.append('main', page.value.main || 0)
        formData.append('position', page.value.position || 0)

        if (Array.isArray(sliders.value)) {
            sliders.value.forEach((item) => {
                if (!item) return
                if (typeof item === 'string') formData.append('sliders_existing[]', item)
                else formData.append('sliders_new[]', item)
            })
        }

        if (isEditing.value) formData.append('_method', 'PATCH')

        const url = isEditing.value
            ? `/admin/edit_page/${page.value.id}`
            : '/admin/store_page'

        const response = await axios.post(url, formData)

        if (!response?.data) throw new Error('No response data received')
        router.visit(`/admin/edit_page/${response.data.data.slug}`)

        isEditing.value = true
        autoSaveStatus.value = 'saved'

        if (page.value.status === 'published') alert('Page published successfully!')

    }
    catch (error) {
        console.error('Save failed:', error)
        autoSaveStatus.value = 'error'
        alert('Failed to save: ' + (error.response?.data?.message || error.message))
    } finally {
        saving.value = false
    }
}

// Auto-save setup
let autoSaveTimeout
const setupAutoSave = () => {
    watch([() => page.value.title, content], () => {
        if (autoSaveTimeout) clearTimeout(autoSaveTimeout)
        autoSaveStatus.value = 'unsaved'

        autoSaveTimeout = setTimeout(() => {
            if (page.value.title && content.value) saveDraft()
        }, 2000)
    })
}


// Initialize on mounted
onMounted(() => {
    autoResize()
    setupAutoSave()
})
</script>


<style scoped>
/* Custom prose styles for preview */
.prose-content :deep(h1),
.prose-content :deep(h2),
.prose-content :deep(h3),
.prose-content :deep(h4),
.prose-content :deep(h5),
.prose-content :deep(h6) {
    @apply font-semibold text-gray-900 mt-8 mb-4;
}

.prose-content :deep(h1) { @apply text-3xl; }
.prose-content :deep(h2) { @apply text-2xl; }
.prose-content :deep(h3) { @apply text-xl; }
.prose-content :deep(h4) { @apply text-lg; }

.prose-content :deep(p) {
    @apply mb-4 text-gray-700 leading-relaxed;
}

.prose-content :deep(img) {
    @apply rounded-lg shadow-sm my-6;
}

.prose-content :deep(ul),
.prose-content :deep(ol) {
    @apply mb-4 ml-6;
}

.prose-content :deep(li) {
    @apply mb-2;
}

.prose-content :deep(blockquote) {
    @apply border-l-4 border-gray-300 pl-4 italic text-gray-600 my-4;
}

.prose-content :deep(a) {
    @apply text-blue-600 hover:text-blue-800 underline;
}

.prose-content :deep(hr) {
    @apply border-gray-300 my-8;
}
</style>
