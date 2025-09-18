<template>
    <div class="min-h-screen flex overflow-hidden bg-gray-100">
        <!-- Sidebar -->
        <aside
            :class="[
        'fixed inset-y-0 left-0 z-30 w-64 bg-white border-r transform transition-transform duration-200 ease-in-out md:static md:translate-x-0 md:fixed',
        isOpen ? 'translate-x-0' : '-translate-x-full'
      ]"
        >
            <AdminSideBar :admin_links="$page.props.admin_links"/>
        </aside>

        <!-- Overlay for mobile -->
        <div
            v-if="isOpen"
            class="fixed inset-0 bg-black bg-opacity-40 z-20 md:hidden"
            @click="isOpen = false"
        ></div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden md:ml-64">
            <!-- Top navigation -->
            <nav class="sticky top-0 z-20 bg-white border-b flex justify-between items-center">
                <button
                    class="p-2 m-2 rounded bg-gray-200 md:hidden"
                    @click="isOpen = !isOpen"
                >☰</button>

                <div class="flex items-center p-6 border-b border-gray-700">
          <span class="text-lg font-semibold text-gray-600">
            {{ $page.props.auth.user.name }}
          </span>
                </div>

                <div class="flex items-center gap-4 pr-6">
                    <form @submit.prevent="submit">
                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="rounded-md bg-red-700 p-2 text-l text-white font-bold underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >Log Out</Link>
                    </form>
                </div>
            </nav>

            <!-- Page content -->
            <main class="flex-1 overflow-auto">
                <div class="mx-auto p-4">
                    <slot/>
                </div>
            </main>
        </div>
    </div>
</template>


<script setup>
import { ref } from "vue"
import AdminSideBar from "@/Components/AdminAuthSideBar/AdminSideBar.vue"
import {Link} from "@inertiajs/vue3";

const isOpen = ref(false)
const submit = () => {
    form.post(route('verification.send'));
};


</script>
