<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    short_description: '',
    text: '',
    type: 'blog',
});
const submit = () => {
    form.post(route('articles.store'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <AppLayout title="Create New Article">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create New Article
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                            <input type="text" id="title" v-model="form.title"
                                   class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   :class="{ 'border-red-500': form.errors.title }" maxlength="100" required>
                            <p v-if="form.errors.title" class="text-red-500 text-xs italic">{{ form.errors.title }}</p>
                        </div>

                        <div class="mb-4">
                            <label for="short_description" class="block text-gray-700 text-sm font-bold mb-2">Short Description:</label>
                            <input type="text" id="short_description" v-model="form.short_description"
                                   class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   :class="{ 'border-red-500': form.errors.short_description }" maxlength="255" required>
                            <p v-if="form.errors.short_description" class="text-red-500 text-xs italic">{{ form.errors.short_description }}</p>
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Article Type:</label>
                            <select id="type" v-model="form.type"
                                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    :class="{ 'border-red-500': form.errors.type }" required>
                                <option value="blog">Blog</option>
                                <option value="news">News</option>
                            </select>
                            <p v-if="form.errors.type" class="text-red-500 text-xs italic">{{ form.errors.type }}</p>
                        </div>

                        <div class="mb-6">
                            <label for="text" class="block text-gray-700 text-sm font-bold mb-2">Content:</label>
                            <textarea id="text" v-model="form.text"
                                      class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-32"
                                      :class="{ 'border-red-500': form.errors.text }"></textarea>
                            <p v-if="form.errors.text" class="text-red-500 text-xs italic">{{ form.errors.text }}</p>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" :disabled="form.processing"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300 ease-in-out"
                                    :class="{ 'opacity-50 cursor-not-allowed': form.processing }">
                                Create Article
                            </button>
                            <Link :href="route('articles.index')" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
