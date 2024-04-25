<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import Swal from 'sweetalert2';
</script>
<template>
    <Head title="Mis publicaciones" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 " style="text-align: center;">Mis Posts</h2>
        </template>
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div v-if="publicaciones==" class="bg-white overflow-hidden shadow-sm sm:rounded-lg"  style="text-align: center;">
                            <ol class="relative border-s border-gray-200 dark:border-gray-700" v-for="publicacion in publicaciones" :key="publicacion.id">
    <li  class="mb-10 ms-4" >
        <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">February 2022</time>
        <button @click="eliminarPost(publicacion.id)" type="button" style="float: right;" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" >Eliminar Post</button>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-black">{{publicacion.titulo}}</h3>
        <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">Descripcion del post Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus quam omnis voluptatibus quidem doloribus facere assumenda deleniti tenetur! Porro necessitatibus mollitia modi tenetur saepe, perspiciatis odio temporibus repellat harum aliquid!</p>

    </li>
    
        </ol>
      </div>
     </div>
    </div> 
    </AuthenticatedLayout>  

</template>

<script>

export default {

    props: {
        publicaciones: Array
    },
    data() {
        return {
            publicaciones: [
                { id: 1, titulo: 'Publicación 1' },
                { id: 2, titulo: 'Publicación 2' },
                { id: 3, titulo: 'Publicación 3' }
            ]
        };
    },
    mounted() {
        // Aquí puedes hacer una llamada a la API para obtener las publicaciones del usuario
        // y luego asignarlas a la propiedad "publicaciones"
    },
    methods: {
        eliminarPost(id) {
            // Aquí puedes hacer una llamada a la API para eliminar el post con el ID proporcionado
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Llamar a la API para eliminar el post
                    axios.delete(`/api/publicaciones/${id}`)
                .then(response => {
                    console.log(`Post con ID ${id} eliminado`);
                })
                .catch(error => {
                    console.error(error);
                });
                    // Aquí puedes hacer una llamada a la API para eliminar el post con el ID proporcionado
                    Swal.fire(
                        'Eliminado',
                        'El post ha sido eliminado.',
                        'success'
                    );
                }
            });
        }
    }
};
</script>