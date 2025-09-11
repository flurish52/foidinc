<template>
    <div>
        <h3 class="px-4 py-3 text-xs font-semibold   uppercase tracking-wider">
            {{ title }}
        </h3>
        <ul class="space-y-1 overflow-hidden">
            <li v-for="link in links" :key="link.id" class="group">
                <Link
                    :href="`${link.slug}`"
                    class="flex items-center px-4 py-3 text-secondary transition-all duration-200 rounded-xl hover:bg-primary/10 hover:text-primary-dark hover:translate-x-1 group-hover:border-l-4 group-hover:border-primary"
                    :class="{ 'bg-primary/5 text-primary-dark border-l-4 border-primary': $page.url === link.slug }"
                >
                    <span class="text-sm font-medium">{{ link.name }}</span>
                </Link>

                <!-- children -->
                <ul v-if="link.children && link.children.length" class="ml-6 mt-1 space-y-1">
                    <li v-for="child in link.children" :key="child.id">
                        <Link
                            :href="`${child.slug}`"
                            class="flex items-center px-4 py-2 text-xs text-secondary-light/80 transition-all duration-200 rounded-lg hover:bg-primary/5 hover:text-primary-dark hover:translate-x-1"
                            :class="{ 'bg-primary/5 text-primary-dark': $page.url === child.slug }"
                        >
                            <span class="font-normal">{{ child.name }}</span>
                        </Link>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
defineProps({
    title: String,
    links: {
        type: Array,
        required: true
    }
})
</script>
