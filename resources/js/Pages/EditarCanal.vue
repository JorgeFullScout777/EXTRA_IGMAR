<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Crear Post" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 " style="text-align: center;">Actualizar canal</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <form>
                            <div class="mb-4">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                                <input type="text" name="title" id="title" v-model="canal.name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200" placeholder="Titulo del post">
                            </div>
                            <div class="mb-4">
                                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Descripcion</label>
                                <textarea name="content" id="content" v-model="canal.description" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200" rows="4" placeholder="Contenido del post"></textarea>
                            </div>
                            <button @click="sendChannel()" type="button" class="px-4 py-2 mt-4 text-white bg-indigo-500 rounded-md hover:bg-indigo-600">Actualizar canal</button>
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
        channel: Object,
    },
    data() {
        return {
            canal:{
                // channel_id: this.channel_id,
                name: this.channel.name,
                description: this.channel.description,
                // user_id: this.$page.props.auth.user.id,
            },

        }
    },
    methods: {
        sendChannel() {
            axios.put(route('channel.update', this.channel.id), this.canal)
                .then(response => {
                    console.log(response.data);
                    router.replace(route('channel.user'));
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