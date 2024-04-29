<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Principal" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 " style="text-align: center;">Canales</h2>
            <a v-if="$page.props.auth.user.role_id == 1" :href="route('channel.crear', { id: $page.props.auth.user.id })"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear</button></a>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-black">
                <div class="bg-black overflow-hidden shadow-sm sm:rounded-lg " style="">
                    <ul v-if="channels2.length > 0" class="block bg-black" style="overflow-y: auto;   max-height: 400px; ">
                        <li v-for="channel in channels2" :key="channel.id">
                            <div class="flex flex-col pb-3 bg-black">
        <a style="text-decoration: none;" :href="route('post.posts', { id: channel.id })" class="block mb-1 text-gray-500 md:text-lg text-white font-semibold"> Titulo:{{ channel.name }}
        <dd class="text-lg font-semibold text-white"> <p> Descripcion: {{ channel.description }}</p></dd>
        <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Creado:{{ formaterDate(channel.created_at) }}</dt>
    </a>
    <button v-if="channel.is_active && channel.user_id == $page.props.auth.user.id" @click="deleteChannel(channel)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded float-right">Eliminar</button>
    </div>
                        </li>
                    </ul>
                    <div v-else class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
  <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
  </svg>
  <span class="sr-only">Info</span>
  <div>
    <span class="font-medium">No existen Canales aun </span>
  </div>
</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
export default {
    props: {
        channels: Object
    },
    data() {
        return {
            channels2: this.channels,
        }
    },
    methods:{
        pollRoute() {
            this.pollInterval = setInterval(() => {
                axios.get(route('channel.index.json'))
                    .then(response => {
                        console.log(response.data);
                        this.channels2 = response.data.channels;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }, 3000);
        },
        deleteChannel(channel) {
            axios.delete(route('channel.delete', { id: channel.id }))
                .then(response => {
                    console.log('Canal desactivado:', response.data);
                })
                .catch(error => {
                    console.log(error);
                });
        },formaterDate(date){
        return new Date(date).toLocaleString();
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
};
</script>
