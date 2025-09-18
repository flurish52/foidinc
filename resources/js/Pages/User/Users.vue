<template>
    <AuthenticatedLayout>
        <div class="p-6" :class="{ 'dark': isDarkMode }">
            <!-- Header with theme toggle -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Staff Management</h1>
                    <Link
                        href="/register"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-blue-700 transition-colors"
                    >
                        New staff
                    </Link>
            </div>
            <!-- Desktop table -->
            <div class="hidden md:block bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-left">
                    <tr>
                        <th class="p-4 font-medium text-gray-600 dark:text-gray-300">Name</th>
                        <th class="p-4 font-medium text-gray-600 dark:text-gray-300">Email</th>
                        <th class="p-4 font-medium text-gray-600 dark:text-gray-300">Role</th>
                        <th class="p-4 font-medium text-gray-600 dark:text-gray-300 text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    <tr
                        v-for="user in users"
                        :key="user.id"
                        class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors duration-150"
                    >
                        <td
                            class="p-4 text-gray-800 dark:text-gray-200 font-medium">{{ user.name }}</td>
                        <td class="p-4 text-gray-600 dark:text-gray-400">{{ user.email }}</td>
                        <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 capitalize">
                                    {{ user.role ?? 'User' }}
                                </span>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <button @click="openView(user)" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 p-1.5 rounded-md hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button @click="openEdit(user)" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 p-1.5 rounded-md hover:bg-green-50 dark:hover:bg-green-900/30 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button @click="openDelete(user)" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 p-1.5 rounded-md hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- Mobile cards -->
            <div class="grid grid-cols-1 gap-4 md:hidden">
                <div
                    v-for="user in users"
                    :key="user.id"
                    class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700"
                >
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="font-semibold text-gray-800 dark:text-white text-lg">{{ user.name }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ user.email }}</div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 capitalize">
                            {{ user.role ?? 'User' }}
                        </span>
                    </div>

                    <!-- Actions -->
                    <div class="mt-4 flex space-x-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                        <button @click="openView(user)" class="flex items-center text-blue-600 dark:text-blue-400 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View
                        </button>
                        <button @click="openEdit(user)" class="flex items-center text-green-600 dark:text-green-400 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </button>
                        <button @click="openDelete(user)" class="flex items-center text-red-600 dark:text-red-400 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </div>
                </div>
            </div>

            <!-- View Modal -->
            <div v-if="showView" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-full max-w-md shadow-xl">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">User Details</h2>
                        <button @click="closeModals" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</label>
                            <p class="text-gray-800 dark:text-white mt-1">{{ selectedUser.name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                            <p class="text-gray-800 dark:text-white mt-1">{{ selectedUser.email }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</label>
                            <p class="text-gray-800 dark:text-white mt-1 capitalize">{{ selectedUser.role ?? 'User' }}</p>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button @click="closeModals" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors font-medium">Close</button>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div v-if="showEdit" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-full max-w-md shadow-xl">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Edit User</h2>
                        <button @click="closeModals" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form @submit.prevent="updateUser" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                            <input v-model="form.name" type="text" required class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                            <input v-model="form.email" type="email" required class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
                            <select v-model="form.role" class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                                <option value="viewer">Viewer</option>
                            </select>
                        </div>
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="closeModals" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors font-medium">Cancel</button>
                            <button type="submit" class="px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-sm">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Modal -->
            <div v-if="showDelete" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-full max-w-md shadow-xl">
                    <div class="flex items-center mb-5">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Confirm Deletion</h2>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Are you sure you want to delete <strong class="text-gray-800 dark:text-white">{{ selectedUser.name }}</strong>? This action cannot be undone.</p>
                    <div class="flex justify-end space-x-3">
                        <button @click="closeModals" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors font-medium">Cancel</button>
                        <button @click="deleteUser" class="px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium shadow-sm">Delete User</button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue"
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import {Link, router} from "@inertiajs/vue3";

const isDarkMode = ref(false)
const showView = ref(false)
const showEdit = ref(false)
const showDelete = ref(false)
const selectedUser = ref({})
const form = reactive({ name: "", email: "", role: "user" })

// Props
defineProps({
    users: {
        type: Array,
        required: true,
    },
})


// Actions
const openView = (user) => {
    selectedUser.value = user
    showView.value = true
}
const openEdit = (user) => {
    selectedUser.value = user
    form.name = user.name
    form.email = user.email
    form.role = user.role ?? "user"
    showEdit.value = true
}
const openDelete = (user) => {
    selectedUser.value = user
    showDelete.value = true
}
const closeModals = () => {
    showView.value = false
    showEdit.value = false
    showDelete.value = false
    selectedUser.value = null
}

// CRUD stubs
const updateUser = () => {
    axios.patch(`/admin/update/${selectedUser.value.id}`, form)
        .then(response => {
            alert(response.data.message || 'User updated successfully!');
            router.visit(window.location.href, {preserveScroll: true})
            // closeModals();
        })
        .catch(error => {
            alert(error.response?.data?.message || 'An error occurred.');
            // closeModals();
        });

    // closeModals()
}
const deleteUser = () => {
    axios.delete(`/admin/delete/${selectedUser.value.id}`)
        .then(response => {
            alert(response.data.message || 'User deleted successfully!');
            router.visit(window.location.href, {preserveScroll: true})
            closeModals();
        })
        .catch(error => {
            alert(error.response?.data?.message || 'An error occurred.');
            closeModals();
        });
};

</script>
