<template>
    <nav
        style="font-family: sans-serif"
        class="sticky hidden md:block text-tertiary-dark top-0 shadow-md z-50 bg-primary px-lgpad"
    >
        <div class="flex items-center h-14">
            <ul class="flex w-full items-center justify-between">
                <NavLink
                    v-for="(link, index) in $page.props.links.filter(l => l.main)"
                    :key="index"
                    :name="link.title"
                    :slug="link.slug"
                    :children="link.children"
                />
            </ul>
        </div>
    </nav>
</template>
<script setup>
import NavLink from "./NavLink.vue"
</script>
