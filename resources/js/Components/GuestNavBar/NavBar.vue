<template>
    <nav class="sticky hidden md:block top-0 bg-primary-dark shadow-md z-50 bg-primary-dark">
        <div class="max-w-7xl flex items-center justify-center mx-auto px-6 h-fit">
            <ul class="flex items-center justify-center space-x-8">
                <NavLink
                    v-for="(link, index) in $page.props.links"
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
