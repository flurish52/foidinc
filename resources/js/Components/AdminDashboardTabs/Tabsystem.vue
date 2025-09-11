<script setup>
import { ref } from 'vue'

const props = defineProps({
    items: {
        type: Array,
        required: true // example: [{ key: 'overview', label: 'Overview' }, ...]
    },
    modelValue: {
        type: String,
        required: false
    }
})

const emit = defineEmits(['update:modelValue'])

const active = ref(props.modelValue || props.items[0].key)

function setActive(key) {
    active.value = key
    emit('update:modelValue', key)
}
</script>

<template>
    <div class="border-b border-gray-200">
        <nav class="flex space-x-6" aria-label="Tabs">
            <button
                v-for="item in items"
                :key="item.key"
                @click="setActive(item.key)"
                :class="[
          'px-4 py-2 text-sm font-medium transition-colors duration-150',
          active === item.key
            ? 'border-b-2 border-indigo-500 text-indigo-600'
            : 'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent'
        ]">
                {{ item.label }}
            </button>
        </nav>
    </div>
</template>
