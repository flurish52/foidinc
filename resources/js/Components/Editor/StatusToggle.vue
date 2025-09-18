<script setup>
import {ref, watch, toRefs} from 'vue'
import axios from 'axios'

const props = defineProps({
    page: {
        type: Object,
        required: true
    }
})

const {page} = toRefs(props)
const isToggled = ref(page.value.status === 'published')

const toggleStatus = async () => {
    const status = isToggled.value ? 'published' : 'draft'
    try {
        await axios.patch(`/admin/update_status/${page.value.slug}`, {status})
        console.log('Status updated to', status)
        page.value.status = status
    } catch (error) {
        console.error('Failed to update status', error)
        // revert toggle if failed
        isToggled.value = !isToggled.value
    }
}

watch(() => page.value.status, (newStatus) => {
    isToggled.value = newStatus === 'published'
})
</script>

<template>
    <label class="relative inline-flex items-center cursor-pointer">
        <input type="checkbox" class="sr-only peer"
               v-model="isToggled"
               @change="toggleStatus">
        <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-blue-600 transition-colors"></div>
        <div
            class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md peer-checked:translate-x-5 transition-transform"></div>
    </label>
</template>
