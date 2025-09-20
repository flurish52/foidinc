<template>
    <aside class="hidden md:block w-64 sticky top-4  text-secondary shadow-md h-full overflow-auto">
        <ul>
            <SidebarItem
                v-for="(item, index) in $page.props.links"
                :key="index"
                :item="item"
            />
        </ul>
    </aside>
</template>
<script setup>
import SidebarItem from "./SidebarItem.vue";
</script>
