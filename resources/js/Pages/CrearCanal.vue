<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Crear Canal" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 " style="text-align: center;">Crear canal</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <form>
                            <div class="mb-4">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                                <input type="text" name="title" id="title" v-model="channel.name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200" placeholder="Nombre del canal">
                            </div>
                            <div class="mb-4">
                                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Descripcion</label>
                                <textarea name="content" id="content" v-model="channel.description" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200" rows="4" placeholder="Descripcion del canal"></textarea>
                            </div>
                            <button @click="sendChannel()" type="button" class="px-4 py-2 mt-4 text-white bg-indigo-500 rounded-md hover:bg-indigo-600">Crear canal</button>
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
    data() {
        return {
            channel:{
                name: '',
                description: '',
                user_id: this.$page.props.auth.user.id,
            },

        }
    },
    methods: {
        sendChannel() {
            axios.post(route('channel.store'), this.channel)
                .then(response => {
                    console.log(response.data);
                    router.replace(route('channel.index'));
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