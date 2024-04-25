<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Posts" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 " style="text-align: center;">Posts del canal</h2>

        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <ul>
                        <li v-for="post in posts" :key="post.id">
                            <a :href="route('post.show', { id: post.id })">{{ post.title }}</a>
                            <p class="border-t border-gray-200 mt-4"></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>  

    </AuthenticatedLayout>
</template>
<script>
export default {
    props: {
        posts:Object
    }
}
</script>