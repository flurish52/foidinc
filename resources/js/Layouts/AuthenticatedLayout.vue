<template>
    <div class="min-h-screen flex overflow-hidden bg-gray-100">
        <!-- Sidebar (fixed on md and up) -->
        <aside class="hidden md:flex md:flex-col md:w-64 md:fixed md:inset-y-0 md:left-0 md:overflow-y-auto overflow-x-hidden bg-white border-r z-30">
            <AdminSideBar
                :admin_links="$page.props.admin_links"
            />
        </aside>

        <!-- Main area. add left padding equal to sidebar width on md+ -->
        <div class="flex-1 flex flex-col md:pl-64 overflow-hidden">
            <!-- Top navigation. keep it inside main so it stays with content -->
            <nav class="sticky top-0 z-20 bg-white border-b">
                <!-- your nav content here -->
            </nav>

            <!-- Page content. this is the scrolling region -->
            <main class="flex-1 overflow-auto">
                <div class="max-w-7xl mx-auto p-4">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
<script setup>
import AdminSideBar from "@/Components/AdminAuthSideBar/AdminSideBar.vue";
</script>
