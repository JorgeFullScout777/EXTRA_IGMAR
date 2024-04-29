<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Posts" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 " style="text-align: center;">Posts del canal: {{ channel_name }}</h2>
            <a :href="route('post.crear', { id: channel_id })"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear</button></a>

        </template>
        <div class="py-12"  >
            
            <div  class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="posts2.length>0" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <ul style="overflow-y: auto;   max-height: 400px;">
                        <li v-for="post in posts2" :key="post.id" class="bg-black">
                            <button  v-if="$page.props.auth.user.role_id == 1 || post.user_id == $page.props.auth.user.id" @click="deletePost(post)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded float-right">Eliminar</button>
                            <a style="text-decoration: none; " :href="route('post.show', { id: post.id })" class="block max-w-sm p-6 bg-black border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

<h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ post.title }}</h5>
<h6 class="text-gray-700 dark:text-gray-400 ">{{ formaterDate(post.created_at) }}</h6>
<p class="font-normal text-gray-700 dark:text-gray-400">{{ post.content }}</p>
</a>

                        </li>
                    </ul>
                </div>
                <div v-else class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
  <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
  </svg>
  <span class="sr-only">Info</span>
  <div>
    <span class="font-medium">No existen publicaciones!!!</span> Se el primero en hacer una publicación.
  </div>
</div>
            </div>
        </div>  

        

    </AuthenticatedLayout>
</template>
<script>
import axios from 'axios';
import Swal from 'sweetalert2';
export default {
    props: {
        channel_id: Number,
        channel_name: String,
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
                        router.get(route('channel.index'))
                        console.log(error);
                    });
            }, 3000);
        },
        deletePost(post) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(route('post.delete', { id: post.id }))
                .then(response => {
                    Swal.fire({
                        title: 'Post eliminado',
                        icon: 'success',
                        showConfirmButton: true,
                        timer: 1500
                    });
                    console.log('Post eliminado:', response.data);
                })
                .catch(error => {
                    console.log(error);

                });
                }
            });

        },formaterDate(date){
        return new Date(date).toLocaleString();
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