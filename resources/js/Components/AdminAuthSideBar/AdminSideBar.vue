<template>
    <div class="fixed">
        <!-- Sidebar -->
        <aside
            :class="[
        'fixed  top-0  left-0 min-h-screen w-64 bg-gray-200 border-r transform transition-transform duration-200 z-50',
        'md:translate-x-0 md:static md:block'
      ]"
        >
            <div class="overflow-y-scroll">
                <div class="hidden md:block p-4  font-semibold border-b text-xl">
                    {{ $page.props.auth.user.name }}
                </div>
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
import SidebarSection from './SideBarSection.vue'

const isOpen = ref(false)

const admin_links = [
    { name: "Dashboard", slug: "/admin/dashboard" },
    { name: "Staff", slug: "/admin/users" },
    { name: "Edit home page", slug: "/admin/edit_home" },
    { name: "Pages", slug: "/admin/pages" },
    { name: "Mass intentions", slug: "/admin/mass_intentions" },
    { name: "Contact Messages", slug: "/admin/contact_messages" },
    { name: "Monthly Letters", slug: "/admin/newsletters" },
    { name: "Calender/Events", slug: "/admin/calendar" },
    // { name: "Setting", slug: "/admin/setting" }
]

</script>

<style scoped>
/* global.css */
::-webkit-scrollbar {
    width: 4px;
}

::-webkit-scrollbar-track {
    background: #1f2937; /* gray-800 */
}

::-webkit-scrollbar-thumb {
    background-color: #4b5563; /* gray-600 */
    border-radius: 10px;
}

</style>
