<template>
    <section class="bg-white shadow rounded-lg p-4 md:p-6 w-full md:w-1/2 mt-4 md:mt-0">
        <h2 class="text-xl md:text-2xl font-heading font-bold mb-6">News from the Vatican</h2>

        <div class="space-y-6">
            <div
                v-for="(item, index) in news"
                :key="index"
                class="flex flex-col md:flex-row border-b border-gray-200 pb-4 hover:shadow-md transition-shadow rounded-lg overflow-hidden"
            >
                <!-- Thumbnail -->
                <div class="md:w-32 md:h-32 flex-shrink-0 mb-3 md:mb-0">
                    <img
                        :src="item.thumbnail"
                        :alt="item.title"
                        class="w-full h-full object-cover rounded-lg"
                    />
                </div>

                <!-- Text -->
                <div class="md:ml-4 flex flex-col justify-between">
                    <div>
                        <h3 class="font-semibold text-lg hover:text-primary transition-colors">
                            {{ item.title }}
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">{{ item.time }} by {{ item.author }}</p>
                        <p class="text-gray-700 mt-2 text-sm">{{ item.summary }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
const news = [
    {
        title: 'Traditionalists rejoice that top US cardinal allowed to celebrate old Latin Mass at St. Peter’s',
        time: '4 hours ago',
        author: 'Nicole Winfield',
        summary: 'Traditionalist Catholics celebrated news Monday that the Vatican under Pope Leo XIV had given them permission to celebrate the old Latin Mass in St. Peter’s Basilica during their upcoming pilgrimage.',
        thumbnail: 'https://picsum.photos/id/1019/200/200'
    },
    {
        title: 'Leo gives first exclusive interview to Crux correspondent for new bio',
        time: 'yesterday',
        author: 'Crux Staff',
        summary: 'Notoriously media-shy Pope Leo XIV has given his first-ever papal interview to Crux Senior Correspondent Elise Ann Allen as part of her new biography of the pontiff.',
        thumbnail: 'https://picsum.photos/id/1020/200/200'
    },
    {
        title: 'Pope makes saints of youth icons who capture cornerstones of his agenda',
        time: '2 days ago',
        author: 'Elise Ann Allen',
        summary: 'Pope Leo XIV Sunday canonized two young men whose legacies arguably encapsulate different aspects of his own papacy, and which speak more broadly to a younger generation of Catholics eager for new...',
        thumbnail: 'https://picsum.photos/id/1021/200/200'
    }
];
</script>
