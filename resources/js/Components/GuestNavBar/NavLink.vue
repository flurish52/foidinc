<script setup>
import Dropdown from "./DropDown.vue"
import { Link } from "@inertiajs/vue3"

defineProps({
    name: String,
    slug: String,
    children: {
        type: Array,
        default: () => []
    }
})

const isActive = (slug, children, currentUrl) => {
    const parentUrl = slug === "/" ? "/" : `/page/${slug}`

    if (currentUrl === parentUrl) return true

    if (children && children.length) {
        return children.some(child => currentUrl === `/page/${child.slug}`)
    }

    return false
}
</script>

<template>
    <li
        class="relative group h-14 flex items-center"
        :class="{
        'bg-tertiary text-secondary': isActive(slug, children, $page.url),
        'text-tertiary-dark hover:bg-tertiary hover:text-secondary': !isActive(slug, children, $page.url)
    }"
    >
        <Link
            :href="slug === '/' ? '/' : `/page/${slug}`"
            class="flex items-center gap-1 px-4 font-medium transition-colors"
        >
            {{ name }}
            <svg
                v-if="children && children.length"
                class="w-4 h-4 transition-colors"
                :class="{
                'text-secondary': isActive(slug, children, $page.url),
                'text-tertiary-dark group-hover:text-secondary': !isActive(slug, children, $page.url)
            }"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </Link>

        <Dropdown v-if="children && children.length" :items="children" />
    </li>
</template>
