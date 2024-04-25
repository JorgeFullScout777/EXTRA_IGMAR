<template>
    <div>
        <!-- Mostrar la publicación -->
        <h1>{{ publicacion.titulo }}</h1>
        <p>{{ publicacion.contenido }}</p>

        <!-- Mostrar los comentarios -->
        <h2>Comentarios</h2>
        <ul>
            <li v-for="comentario in comentarios" :key="comentario.id">
                {{ comentario.texto }}
            </li>
        </ul>






        <form @submit.prevent="agregarComentario">
   <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
       <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
           <label for="comment" class="sr-only">Your comment</label>
           <textarea id="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="Write a comment..." required ></textarea>
       </div>
       <div class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
           <button type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
               Post comment
           </button>
           <div class="flex ps-0 space-x-1 rtl:space-x-reverse sm:ps-2">
               <button type="button" class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                   <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 20">
                        <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M1 6v8a5 5 0 1 0 10 0V4.5a3.5 3.5 0 1 0-7 0V13a2 2 0 0 0 4 0V6"/>
                    </svg>
                   <span class="sr-only">Attach file</span>
               </button>
           </div>
       </div>
   </div>
</form>   <!-- Formulario para agregar un nuevo comentario -->
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            publicacion: {}, // Aquí almacenaremos la publicación
            comentarios: [], // Aquí almacenaremos los comentarios
            nuevoComentario: '' // Aquí almacenaremos el nuevo comentario ingresado por el usuario
        };
    },
    mounted() {
        // Método para realizar polling a los comentarios de la publicación
            setInterval(() => {
                axios.get(`/api/publicaciones/${this.publicacion.id}/comentarios`)
                    .then(response => {
                        this.comentarios = response.data;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }, 5000); // Realizar polling cada 5 segundos (ajusta el intervalo según tus necesidades)
    
    },
    methods: {
        agregarComentario() {
            // Aquí puedes hacer una petición HTTP para agregar el nuevo comentario
            // y luego actualizar la lista de comentarios
            // Ejemplo:
            // agregarComentario(this.nuevoComentario);
            // this.comentarios = obtenerComentarios();
            this.nuevoComentario = ''; // Limpiar el campo de texto después de agregar el comentario
        }
    }
};
</script>