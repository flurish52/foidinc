<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 p-6">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Route Management</h1>
                    <p class="text-gray-600 mt-2">Manage all website routes and navigation links</p>
                </div>
                <button class="flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="font-medium">Add New Route</span>
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-blue-100 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Routes</p>
                    <p class="text-3xl font-bold text-gray-900">{{ route_link.total }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-green-100 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Public Routes</p>
                    <p class="text-3xl font-bold text-gray-900">{{ publicCount }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-purple-100 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Admin Routes</p>
                    <p class="text-3xl font-bold text-gray-900">{{ adminCount }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-yellow-100 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Nested Routes</p>
                    <p class="text-3xl font-bold text-gray-900">{{ nestedCount }}</p>
                </div>
            </div>
        </div>

        <!-- Routes Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-lg font-semibold text-gray-900">All Routes</h2>
                <div class="flex gap-2">
                    <select class="px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>All Visibility</option>
                        <option>Public</option>
                        <option>Admin</option>
                    </select>
                    <button class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Filter
                    </button>
                </div>
            </div>

            <!-- Routes List -->
            <div class="divide-y divide-gray-200">
                <div
                    v-for="route in route_link.data"
                    :key="route.id"
                    class="p-6 hover:bg-gray-50 transition-colors duration-200"
                    :class="{ 'bg-blue-50': route.deleted_at }"
                >
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-4 flex-1 min-w-0">
                            <div class="p-3 rounded-xl flex-shrink-0" :class="route.visibility === 'admin' ? 'bg-purple-100' : 'bg-blue-100'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="route.visibility === 'admin' ? 'text-purple-600' : 'text-blue-600'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ route.name }}</h3>
                                    <span class="text-xs px-2 py-1 rounded-full font-medium"
                                          :class="{
                      'bg-green-100 text-green-700': route.visibility === 'public',
                      'bg-purple-100 text-purple-700': route.visibility === 'admin',
                      'bg-gray-100 text-gray-700': route.deleted_at
                    }">
                    {{ route.visibility }} {{ route.deleted_at ? '(Deleted)' : '' }}
                  </span>
                                </div>

                                <p class="text-sm text-gray-600 mb-3">
                                    <span class="font-mono">{{ route.slug }}</span>
                                    <span v-if="route.parent_id" class="text-xs text-gray-500 ml-2">(Child route)</span>
                                </p>

                                <div class="flex items-center gap-4 text-sm text-gray-500">
                                    <span>Position: {{ route.position }}</span>
                                    <span>•</span>
                                    <span>ID: {{ route.id }}</span>
                                    <span>•</span>
                                    <span>Created: {{ formatDate(route.created_at) }}</span>
                                </div>

                                <!-- Children Routes -->
                                <div v-if="route.children && route.children.length" class="mt-4 pl-6 border-l-2 border-gray-200">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Sub-routes:</h4>
                                    <div class="space-y-2">
                                        <div
                                            v-for="child in route.children"
                                            :key="child.id"
                                            class="p-3 bg-gray-50 rounded-lg"
                                        >
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <span class="text-sm font-medium text-gray-900">{{ child.name }}</span>
                                                    <span class="text-xs text-gray-600 ml-2 font-mono">{{ child.slug }}</span>
                                                </div>
                                                <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">
                          Child
                        </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 ml-4 flex-shrink-0">
                            <button class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-100 rounded-lg transition-colors" title="Edit Route">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>

                            <button class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-100 rounded-lg transition-colors" title="Delete Route">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-if="route_link.data.length === 0" class="text-center py-16">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No routes configured</h3>
                <p class="text-gray-600 mb-6">Start by adding your first route</p>
                <button class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add First Route
                </button>
            </div>

            <!-- Pagination -->
            <div v-if="route_link.data.length > 0" class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">
                        Showing {{ route_link.from }} to {{ route_link.to }} of {{ route_link.total }} routes
                    </p>
                    <div class="flex gap-1">
                        <button
                            v-for="(link, index) in route_link.links"
                            :key="index"
                            class="px-3 py-1.5 text-sm rounded-lg border transition-colors"
                            :class="{
                'bg-blue-600 text-white border-blue-600': link.active,
                'text-gray-700 border-gray-300 hover:bg-gray-100': !link.active && link.url,
                'text-gray-400 border-gray-200 cursor-not-allowed': !link.url
              }"
                            v-html="link.label"
                            :disabled="!link.url"
                        ></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { computed } from 'vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    route_link: {
        type: Object,
        required: true,
        default: () => ({ data: [], total: 0 })
    }
})

// Calculate stats
const publicCount = computed(() => {
    return props.route_link.data.filter(route => route.visibility === 'public').length
})

const adminCount = computed(() => {
    return props.route_link.data.filter(route => route.visibility === 'admin').length
})

const nestedCount = computed(() => {
    return props.route_link.data.filter(route => route.children && route.children.length > 0).length
})

const formatDate = (dateString) => {
    if (!dateString) return 'N/A'
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}
</script>

<style scoped>
.font-mono {
    font-family: ui-monospace, SFMono-Regular, 'SF Mono', Consolas, 'Liberation Mono', Menlo, monospace;
}
</style>
