<template>
    <li class="mb-1 py-1">
        <div class="flex items-center cursor-pointer hover:text-primary transition-colors">
            <Link :href="slug === '/' ? '' : `/page/${slug}`" class="flex-1">{{ item.title ==='Home'? '': item.title }}</Link>
        </div>

        <!-- Nested children always shown -->
        <ul v-show="true" class="ml-2 mt-1 space-y-1">
        <hr>
            <SidebarItem
                v-for="(child, index) in item.children"
                :key="index"
                :item="child"
            />
        <hr />
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
