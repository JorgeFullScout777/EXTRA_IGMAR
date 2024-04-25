<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Principal" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 " style="text-align: center;">Usuarios</h2>
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
                                    Nombre
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rol
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="user in users" :key="user.id" :class="{ 'bg-red-100': !user.is_active }">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ user.id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ user.name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ user.email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <p v-if="user.role_id == 1">Administrador</p>
                                                <p v-if="user.role_id == 2">Usuario</p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button @click="editChannel(user)" class="text-indigo-600 hover:text-indigo-900">Editar</button>
                                    <button v-if="user.is_active" @click="deleteChannel(user)" class="text-red-600 hover:text-red-900">Desactivar</button>
                                    <button v-if="!user.is_active" @click="enableChannel(user)" class="text-green-600 hover:text-red-900">Activar</button>
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
            users: [],
        }
    },
    methods:{
        getChannels() {
            axios.get(route('user.index'))
                .then(response => {
                    console.log(response.data);
                    this.users = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        editChannel(users) {
            console.log('Editando usuario:', users);
        },
        deleteChannel(user) {
            axios.delete(route('user.delete', { id: user.id }))
                .then(response => {
                    console.log('usuario desactivado:', response.data);
                    this.getChannels();
                })
                .catch(error => {
                    console.log(error);
                });
        },
        enableChannel(user) {
            axios.put(route('user.enable', { id: user.id }))
                .then(response => {
                    console.log('user activado:', response.data);
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
