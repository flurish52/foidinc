<template>
    <aside class="w-64 sticky top-4 bg-tertiary-light text-secondary shadow-md h-full overflow-auto p-4">
        <ul>
            <SidebarItem
                v-for="(item, index) in links"
                :key="index"
                :item="item"
            />
        </ul>
    </aside>
</template>
<script setup>
import { ref } from "vue";
import SidebarItem from "./SidebarItem.vue";

// Example nested links
const links = ref([
    {
        name: "Home",
        href: "/",
    },
    {
        name: "About",
        href: "/page/about",
        children: [
            {
                name: "Our Mission",
                href: "/page/about/mission",
                children: [
            {
                name: "Our Mission",
                href: "/page/about/mission",
                children: [
                    {
                        name: "Our Mission",
                        href: "/page/about/mission",
                        children: [
                            {
                                name: "Our Mission",
                                href: "/page/about/mission",
                            }
                        ]
                    }
                ]
            },
            ]
            },
            {
                name: "Team",
                href: "/about/team",
                children: [
                    { name: "Staff", href: "/about/team/staff" },
                    { name: "Board", href: "/about/team/board" },
                ],
            },
        ],
    },
    {
        name: "Projects",
        href: "/projects",
    },
]);
</script>
