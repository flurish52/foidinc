<template>
    <TopHeader/>
    <NavBar/>
    <div class="flex mx-auto p-6">
        <aside class="hidden md:block w-64 flex-shrink-0 sticky top-16 h-[calc(100vh-4rem)] overflow-auto">
            <SideBar/>
        </aside>

        <div>
            <SectionHeader title="Search" />

            <input
                type="text"
                v-model="query"
                @input="fetchResults"
                placeholder="Search pages and projects..."
                class="w-full h-12 mx-6 rounded-md border border-gray-300 px-4 py-2
                       focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />

            <div class="mt-4 space-y-3">
                <div
                    v-for="item in results"
                    :key="item.type + '-' + item.id"
                    class="p-3 border rounded bg-white shadow-sm"
                >
                    <span class="text-xs uppercase text-indigo-600">{{ item.type }}</span>

                    <h3 class="font-semibold">
                        <Link v-if="item.slug" :href="`/page/${item.slug}`">
                            {{ item.title }}
                        </Link>
                        <span v-else>
                            {{ item.title }}
                        </span>
                    </h3>
                    <p v-if="item.snippet" class="text-sm text-gray-600">
                        {{ item.snippet }}
                    </p>
                </div>
                <div v-if="!results.length && query.length" class="text-gray-500">
                    No results found
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue"
import axios from "axios"
import TopHeader from "@/Components/GuestNavBar/TopHeader.vue"
import NavBar from "@/Components/GuestNavBar/NavBar.vue"
import SideBar from "@/Components/GuestSideBar/SideBar.vue"
import SectionHeader from "@/Components/HomeSections/SectionHeader.vue"
import { Link } from "@inertiajs/vue3"

const query = ref("")
const results = ref([])

onMounted(() => {
    const params = new URLSearchParams(window.location.search)
    query.value = params.get("q") || ""
    if (query.value) {
        fetchResults()
    }
})

const fetchResults = () => {
    if (!query.value.trim()) {
        results.value = []
        return
    }

    axios.get("/search", { params: { q: query.value } })
        .then(res => {
            results.value = res.data.results || []
        })
        .catch(() => {
            results.value = []
        })
}
</script>
