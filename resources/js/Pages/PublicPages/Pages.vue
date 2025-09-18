<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-tertiary-light p-6">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-secondary-dark">Content Management</h1>
                        <p class="text-secondary-light mt-2">Create and manage your website pages</p>
                    </div>
                    <Link
                        href="/admin/create_page"
                        class="group flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white rounded-xl shadow-sm hover:bg-primary-dark transition-all duration-200 transform hover:-translate-y-0.5"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="font-medium">New Page</span>
                    </Link>
                </div>
            </div>

            <!-- Stats Grid -->
            <div  class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Pages -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-tertiary-dark/10 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-primary/10 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-secondary-light mb-1">Total Pages</p>
                        <p class="text-3xl font-bold text-secondary-dark">{{ pages.total }}</p>
                    </div>
                </div>

                <!-- Published -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-tertiary-dark/10 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-100 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-secondary-light mb-1">Published</p>
                        <p class="text-3xl font-bold text-secondary-dark">{{ publishedCount }}</p>
                    </div>
                </div>

                <!-- Drafts -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-tertiary-dark/10 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-yellow-100 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-secondary-light mb-1">Drafts</p>
                        <p class="text-3xl font-bold text-secondary-dark">{{ draftCount }}</p>
                    </div>
                </div>

                <!-- Last Updated -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-tertiary-dark/10 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-100 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-secondary-light mb-1">Last Updated</p>
                        <p class="text-lg font-bold text-secondary-dark">{{ lastUpdated }}</p>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-tertiary-dark/10 overflow-hidden">
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-tertiary-dark/10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h2 class="text-lg font-semibold text-secondary-dark">All Pages</h2>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 text-sm border border-tertiary-dark/20 rounded-lg hover:bg-tertiary-light transition-colors">
                            Filter
                        </button>
                        <button class="px-4 py-2 text-sm border border-tertiary-dark/20 rounded-lg hover:bg-tertiary-light transition-colors">
                            Sort
                        </button>
                    </div>
                </div>

                <!-- Pages List -->
                <div class="divide-y divide-tertiary-dark/10">
                    <div
                        v-for="page in pages.data"
                        :key="page.id"
                        class="p-6 hover:bg-tertiary-light/20 transition-colors duration-200"
                    >
                        <div class="flex items-start justify-between">
                            <div class="flex items-start gap-4 flex-1 min-w-0">
                                <div class="p-3 bg-primary/10 rounded-xl flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-secondary-dark truncate">{{ page.title }}</h3>
                                    <p class="text-sm text-secondary-light mt-1">/{{ page.slug }}</p>

                                    <div class="flex items-center gap-4 mt-3">
                    <span class="text-sm px-3 py-1 rounded-full font-medium"
                          :class="{
                        'bg-green-100 text-green-700': page.status === 'published',
                        'bg-yellow-100 text-yellow-700': page.status === 'draft',
                        'bg-gray-100 text-gray-700': page.status === 'archived'
                      }">
                      {{ page.status }}
                    </span>
                                        <span class="text-sm text-secondary-light">{{ formatDate(page.updated_at) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 ml-4 flex-shrink-0">
                                <Link
                                    :href="`/admin/edit_page/${page.slug}`"
                                    class="p-2 text-secondary hover:text-primary hover:bg-primary/10 rounded-lg transition-colors"
                                    title="Edit Page"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </Link>

                                <div
                                    class="p-2 text-secondary hover:text-green-600 hover:bg-green-100 rounded-lg transition-colors"
                                    title="publish"
                                >
                               <StatusToggle :page="page" />
                                </div>

                                <button
                                    @click="destroy(page.id)"
                                    class="p-2 text-secondary hover:text-red-600 hover:bg-red-100 rounded-lg transition-colors"
                                    title="Delete Page"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="pages.data.length === 0" class="text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 bg-tertiary-light rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-tertiary-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-secondary-dark mb-2">No pages created yet</h3>
                    <p class="text-secondary-light mb-6">Get started by creating your first page</p>
                    <Link
                        href="/admin/create_page"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create First Page
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { computed } from 'vue';
import StatusToggle from "@/Components/Editor/StatusToggle.vue";

const props = defineProps({
    pages: {
        type: Object,
        required: true,
        default: () => ({ data: [], total: 0 })
    }
});

// Calculate stats
const publishedCount = computed(() => {
    return props.pages.data.filter(page => page.status === 'published').length;
});

const draftCount = computed(() => {
    return props.pages.data.filter(page => page.status === 'draft').length;
});

const lastUpdated = computed(() => {
    if (props.pages.data.length === 0) return 'Never';
    const dates = props.pages.data.map(page => new Date(page.updated_at));
    const latest = new Date(Math.max(...dates));
    return formatDate(latest);
});

const destroy = (id) => {
    if (confirm("Are you sure you want to delete this page? This action cannot be undone.")) {
        router.delete(`/pages/${id}`);
    }
};

const formatDate = (date) => {
    if (!date) return '';
    const dateObj = new Date(date);
    return dateObj.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};
</script>

<style scoped>
.truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>
