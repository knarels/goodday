<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, usePage, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    article: Object,
    canUpdateArticle: Boolean,
    canDeleteArticle: Boolean,
});
const flash = computed(() => usePage().props.flash || {});
const deleteArticle = (id) => {
    if (confirm('Are you sure you want to delete this article?')) {
        const form = useForm({});
        form.delete(route('articles.destroy', id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Article deleted successfully!');
            },
            onError: (errors) => {
                console.error('Error deleting article:', errors);
            }
        });
    }
};
</script>

<template>
    <AppLayout :title="article.title">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ article.title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div v-if="flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ flash.success }}</span>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ article.title }}</h3>
                        <p class="text-gray-600 text-lg mb-3">{{ article.short_description }}</p>
                        <p class="text-gray-700 text-base leading-relaxed whitespace-pre-wrap">{{ article.text }}</p>
                        <p class="text-gray-500 text-sm mt-4">Type: <span class="font-semibold">{{ article.type }}</span></p>
                        <p class="text-gray-500 text-xs mt-1">Created: {{ new Date(article.created_at).toLocaleDateString() }}</p>
                        <p v-if="article.updated_at" class="text-gray-500 text-xs">Last Updated: {{ new Date(article.updated_at).toLocaleDateString() }}</p>
                    </div>

                    <div class="flex space-x-4">
                        <Link v-if="canUpdateArticle" :href="route('articles.edit', article.id)" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                            Edit Article
                        </Link>
                        <button v-if="canDeleteArticle" @click="deleteArticle(article.id)" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                            Delete Article
                        </button>
                        <Link :href="route('articles.index')" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800 py-2 px-4">
                            Back to Articles
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
