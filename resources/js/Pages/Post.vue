<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Posts" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 " style="text-align: center;">Post de {{ post.username }}</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">{{ post.title }}</h3>
                        <p class="text-sm text-gray-500">{{ post.created_at }}</p>
                        <p class="text-sm text-gray-500">{{ post.username }}</p>
                        <p class="mt-2">{{ post.content }}</p>
                    </div>
                </div>
                <div class="mt-8"></div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">Comentarios</h3>
                        <ul>
                            <li v-for="comment in comments2" :key="comment.id">
                                <p class="border-t border-gray-200 mt-4"></p>
                                <p>{{ comment.content }}</p>
                                <p class="text-sm text-gray-500">{{ comment.created_at }}</p>
                                <p class="text-sm text-gray-500">{{ comment.username }}</p>
                                <p class="border-t border-gray-200 mt-4"></p>
                            </li>
                        </ul>
                        <div class="mt-8">
                                <textarea v-model="comment.content" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200" rows="4" placeholder="Escribe tu comentario"></textarea>
                                <button type="button" @click="sendComment()" class="px-4 py-2 mt-4 text-white bg-indigo-500 rounded-md hover:bg-indigo-600">Enviar comentario</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </AuthenticatedLayout>
</template>
<script>
import axios from 'axios';
export default {
    props: {
        post:Object,
        comments: Object
    },
    data() {
        return {
            comment:{
                content: '',
                post_id: this.post.id,
                user_id: this.$page.props.auth.user.id,
            },
            comments2: this.comments,
        }
    },
    methods: {
        sendComment() {
            event.preventDefault();
            console.log('Enviando comentario');
            axios.post(route('comment.store'), this.comment)
                .then(response => {
                    this.comment.content = '';
                    console.log('Comentario enviado:', response.data);
                })
                .catch(error => {
                    console.error('Error al enviar el comentario:', error);
                });
        },
        pollRoute() {
            this.pollInterval = setInterval(() => {
                axios.get(route('comment.comments', { id: this.post.id }))
                    .then(response => {
                        console.log('Polling:', response.data);
                        this.comments2 = response.data["data"];
                    })
                    .catch(error => {
                        console.error('Error while polling:', error);
                    });
            }, 3000);
        }
    },
    mounted() {
        this.pollRoute();
    },
    beforeUnmount() {
    clearInterval(this.pollInterval);
    }
}
</script>