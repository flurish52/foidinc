<template>
    <li class="mb-1 bg-tertiary py-1">
        <div class="flex items-center justify-between cursor-pointer hover:text-primary transition-colors">
            <Link :href="item.href" class="flex-1">{{ item.name }}</Link>

            <!-- Show plus if there are children -->
            <button
                v-if="item.children && item.children.length"
                @click="toggle"
                class="ml-1 text-sm font-bold"
            >
                {{ open ? "-" : "+" }}
            </button>
        </div>

        <!-- Nested children -->
        <ul v-show="open" class="ml-2 mt-1 space-y-1">
            <SidebarItem
                v-for="(child, index) in item.children"
                :key="index"
                :item="child"
            />
        </ul>
    </li>
</template>

<script setup>
import { ref } from "vue";
import SidebarItem from "./SidebarItem.vue";
import {Link} from "@inertiajs/vue3";

defineProps({
    item: {
        type: Object,
        required: true
    }
});

const open = ref(false);

const toggle = () => {
    open.value = !open.value;
};
</script>
