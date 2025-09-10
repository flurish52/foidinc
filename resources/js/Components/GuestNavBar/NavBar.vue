<template>
    <nav class="sticky top-0 bg-primary-dark shadow-md z-50 bg-primary-dark">
        <div class="max-w-7xl flex items-center justify-center mx-auto px-6 h-fit">
            <ul class="flex items-center justify-center space-x-8">
                <NavLink
                    v-for="(link, index) in links"
                    :key="index"
                    :name="link.name"
                    :href="link.href"
                    :children="link.children"
                />
            </ul>
        </div>
    </nav>
</template>
<script setup>
import NavLink from "./NavLink.vue"

const links = [
    { name: "Home", href: "/" },
    { name: "About", href: "/page/about", children: [
            { name: "Mission Areas", href: "/page/mission-areas" },
            { name: "Projects", href: "/page/projects" },
        ]
    },
    { name: "Events", href: "/page/events" },
    { name: "News", href: "/page/news" },
    { name: "Donate", href: "/donate" },
    { name: "Contact Us", href: "/contact",
        children: [
            { name: "Mission Areas", href: "/page/mission-areas" },
            { name: "Projects", href: "/page/projects" },
        ]
    },
    { name: "Our Bishop", href: "/page/bishop" }
    ]
</script>
