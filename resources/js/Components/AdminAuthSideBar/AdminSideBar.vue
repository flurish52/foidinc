<template>
    <div>
        <!-- Toggle Button (visible only on small screens) -->
        <button
            class="md:hidden absolute p-2 m-2 border rounded bg-gray-200"
            @click="isOpen = !isOpen"
        >
            ☰
        </button>

        <!-- Sidebar -->
        <aside
            :class="[
        'fixed  top-0 left-0 min-h-screen w-64 bg-gray-100 border-r transform transition-transform duration-200 z-50',
        isOpen ? 'translate-x-0' : '-translate-x-full',
        'md:translate-x-0 md:static md:block'
      ]"
        >
            <div class="overflow-y-scroll">
                <div class="hidden md:block p-4 text-lg font-semibold border-b">
                    {{ $page.props.auth.user.name }}
                </div>
                <!-- Public and Auth Links -->
<!--                <SidebarSection title="Admin" :links="links"/>-->
                <!-- Admin Links -->
                <SidebarSection
                    v-if="admin_links.length"
                    title="Admin"
                    :links="admin_links"
                />
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div
            v-if="isOpen"
            class="fixed inset-0 bg-black bg-opacity-40 md:hidden"
            @click="isOpen = false"
        ></div>
    </div>
</template>

<script setup>
import {ref} from 'vue'
import SidebarSection from './SidebarSection.vue'

const isOpen = ref(false)

defineProps({
    admin_links: {
        type: Array,
        default: () => []
    }
})
</script>
