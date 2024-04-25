<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Posts" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 " style="text-align: center;">Posts del canal</h2>
            <a :href="route('post.crear', { id: channel_id })"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear</button></a>

        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="mt-8">
                        <!-- Your content here -->
                    </div>
                    <ul>
                        <li v-for="post in posts2" :key="post.id">
                            <a :href="route('post.show', { id: post.id })">{{ post.title }}</a>
                            <button v-if="post.is_active" @click="deletePost(post)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded float-right">Desactivar</button>
                            <button v-if="!post.is_active" @click="enablePost(post)" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded float-right">Activar</button>
                            <p class="border-t border-gray-200 mt-4"></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>  

        

    </AuthenticatedLayout>
</template>
<script>
import axios from 'axios';
export default {
    props: {
        channel_id: Number,
        posts: Object
    },
    data() {
        return {
            posts2: this.posts,
        }
    },
    methods:{
        pollRoute() {
            axios.get(route('post.posts.json.all', { id: this.channel_id }))
                .then(response => {
                    console.log(response.data);
                    this.posts2 = response.data.posts;
                })
                .catch(error => {
                    console.log('mundo');
                    console.log(error);
                });
        },
        deletePost(post) {
            axios.delete(route('post.delete', { id: post.id }))
                .then(response => {
                    console.log('Post eliminado:', response.data);
                    location.reload();
                })
                .catch(error => {
                    console.log(error);
                });
        },
        enablePost(post) {
            axios.put(route('post.enable', { id: post.id }))
                .then(response => {
                    console.log('Post activado:', response.data);
                    location.reload();
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    mounted() {
        this.pollRoute();
    },
}
</script>