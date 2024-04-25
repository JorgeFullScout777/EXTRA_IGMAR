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
                    <ul>
                        <li v-for="post in posts2" :key="post.id">
                            <a :href="route('post.show', { id: post.id })">{{ post.title }}</a>
                            <button v-if="post.is_active && post.user_id == $page.props.auth.user.id" @click="deletePost(post)" class="text-red-600 hover:text-red-900">Eliminar</button>
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
            this.pollInterval = setInterval(() => {
                axios.get(route('post.posts.json', { id: this.channel_id }))
                    .then(response => {
                        console.log(response.data);
                        this.posts2 = response.data.posts;
                    })
                    .catch(error => {
                        console.log('mundo');
                        console.log(error);
                    });
            }, 3000);
        },
        deletePost(post) {
            axios.delete(route('post.delete', { id: post.id }))
                .then(response => {
                    console.log('post desactivado:', response.data);
                })
                .catch(error => {
                    console.log(error);
                });
        },
    },
    mounted() {
        this.pollRoute();
    },
    beforeUnmount() {
        clearInterval(this.pollInterval);
    }
}
</script>