<template>
        <hr>
    <li class="mb-1 py-1 px-3">
        <div class="flex items-center cursor-pointer hover:text-primary transition-colors">
            <Link :href="slug === '/' ? '' : `/page/${item.slug}`" class="flex-1">{{ item.title ==='Home'? '': item.title }}</Link>
        </div>

        <!-- Nested children always shown -->
        <ul v-show="true" class="mt-1 space-y-1">
            <SidebarItem
                v-for="(child, index) in item.children"
                :key="index"
                :item="child"
            />
        </ul>
    </li>

</template>

<script setup>
import SidebarItem from "./SidebarItem.vue";
import {Link} from "@inertiajs/vue3";

defineProps({
    item: {
        type: Object,
        required: true
    }
});
</script>
