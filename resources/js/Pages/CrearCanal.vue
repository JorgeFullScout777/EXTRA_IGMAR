<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Crear Post" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 " style="text-align: center;">Crear post</h2>
        </template>
        <div class="py-12">
            <p>{{post}}</p>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <form>
                            <div class="mb-4">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titulo</label>
                                <input type="text" name="title" id="title" v-model="post.title" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200" placeholder="Titulo del post">
                            </div>
                            <div class="mb-4">
                                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Contenido</label>
                                <textarea name="content" id="content" v-model="post.content" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200" rows="4" placeholder="Contenido del post"></textarea>
                            </div>
                            <button @click="sendPost()" type="button" class="px-4 py-2 mt-4 text-white bg-indigo-500 rounded-md hover:bg-indigo-600">Crear post</button>
                        </form>
                    </div>
                </div>
                <div class="mt-8"></div>
            </div>
        </div>  
    </AuthenticatedLayout>
</template>
<script>
import axios from 'axios';
export default {
    props: {
        channel_id: Number,
    },
    data() {
        return {
            post:{
                channel_id: this.channel_id,
                title: '',
                content: '',
                user_id: this.$page.props.auth.user.id,
            },

        }
    },
    methods: {
        sendPost() {
            axios.post(route('post.store'), this.post)
                .then(response => {
                    console.log(response.data);
                    router.replace(route('post.posts', { id: this.post.channel_id }));
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    mounted() {
    },
}
</script>