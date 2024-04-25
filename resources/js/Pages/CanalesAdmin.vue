<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Principal" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 " style="text-align: center;">Canales</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre del Canal
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Descripcion
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="channel in channels" :key="channel.id" :class="{ 'bg-red-100': !channel.is_active }">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ channel.id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ channel.name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ channel.description }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <!-- <button @click="editChannel(channel)" class="text-indigo-600 hover:text-indigo-900">Editar</button> -->
                                    <button v-if="channel.is_active" @click="deleteChannel(channel)" class="text-red-600 hover:text-red-900">Desactivar</button>
                                    <button v-if="!channel.is_active" @click="enableChannel(channel)" class="text-green-600 hover:text-red-900">Activar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
export default {
    data() {
        return {
            channels: [],
        }
    },
    methods:{
        getChannels() {
            axios.get(route('channel.index.json.admin'))
                .then(response => {
                    console.log(response.data);
                    this.channels = response.data.channels;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        editChannel(channel) {
            console.log('Editando canal:', channel);
        },
        deleteChannel(channel) {
            axios.delete(route('channel.delete', { id: channel.id }))
                .then(response => {
                    console.log('Canal desactivado:', response.data);
                    this.getChannels();
                })
                .catch(error => {
                    console.log(error);
                });
        },
        enableChannel(channel) {
            axios.put(route('channel.enable', { id: channel.id }))
                .then(response => {
                    console.log('Canal activado:', response.data);
                    this.getChannels();
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    mounted() {
        this.getChannels();
    }
};
</script>
