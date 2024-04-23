<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Principal" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 " style="text-align: center;">Posts del dia</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <ul>
                        <li v-for="publicacion in publicaciones" :key="publicacion.id">
                                {{ publicacion.titulo }}
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
    data() {
        return {
            publicaciones: [] // Aquí se almacenarán las publicaciones del usuario
        };
    },
    mounted() {
        axios.get('/api/publicaciones')
            .then(response => {
                this.publicaciones = response.data;
            })
            .catch(error => {
                console.error(error);
            });
    }
};
</script>
