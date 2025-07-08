<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    articles: Array,
    canCreateArticles: Boolean,
});
const flash = computed(() => usePage().props.flash || {});

</script>

<template>
    <AppLayout title="Articles">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Articles
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div v-if="flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ flash.success }}</span>
                    </div>

                    <div class="flex justify-end mb-4">
                        <Link :href="route('articles.create')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                            Create New Article
                        </Link>
                    </div>

                    <div v-if="articles.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="article in articles" :key="article.id" class="border border-gray-200 rounded-lg shadow-sm p-4 flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ article.title }}</h3>
                                <p class="text-gray-600 text-sm mb-3">{{ article.short_description }}</p>
                                <p class="text-gray-700 text-base line-clamp-3">{{ article.text }}</p>
                                <p class="text-gray-500 text-xs mt-2">Type: <span class="font-semibold">{{ article.type }}</span></p>
                            </div>
                            <div class="mt-4 flex space-x-2">
                                <Link :href="route('articles.show', article.id)" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-3 rounded-lg text-sm transition duration-300 ease-in-out">
                                    View
                                </Link>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center text-gray-500 py-8">
                        <p>No articles found. Start by creating one!</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
