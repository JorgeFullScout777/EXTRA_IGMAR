<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Posts" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 " style="text-align: center;">Post de {{ post.username }}</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">{{ post.title }}</h3>
                        <p class="text-sm text-gray-500">{{ post.created_at }}</p>
                        <p class="text-sm text-gray-500">{{ post.username }}</p>
                        <p class="mt-2">{{ post.content }}</p>
                        <div>
                                    <button type="button" @click="editpost(post.id,)" v-if="post.user_id==$page.props.auth.user.id"  class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">Editar</button>
                                    <button type="button" @click="eliminarpost(post.id)" v-if="post.user_id==$page.props.auth.user.id || $page.props.auth.user.rol_id==1" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">Eliminar</button>
                        </div>
                    </div>
                </div>
                <div class="mt-8"></div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 ">
                        <h3 class="text-lg font-semibold">Comentarios</h3>
                        <ul style="  overflow-y: auto;   max-height: 400px; " >
                            <li v-for="comment in comments2" :key="comment.id">
                                <p class="border-t border-gray-200 mt-4"></p>
                                <p class="text-sm text-gray-500">  {{ comment.username }} </p>
                                <h5>  {{ comment.content }} </h5>
                                <h6 class=" items-center text-xs font-normal text-gray-500 hover:underline dark:text-gray-400">
                                    Creado:{{ formaterDate(comment.created_at)}}
                                </h6>
                                <h6 class=" items-center text-xs font-normal text-gray-500 hover:underline dark:text-gray-400">
                                    Editado:{{ formaterDate(comment.updated_at) }}</h6>

                                <div>
                                    <button type="button" @click="editcomment(comment.id,)" v-if="comment.user_id==$page.props.auth.user.id" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">Editar</button>
                                    <button type="button" @click="eliminarcomment(comment.id)" v-if="comment.user_id==$page.props.auth.user.id || $page.props.auth.user.rol_id==1" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">Eliminar</button>
                                </div>
                 </li>
                        </ul>

                        <div class="mt-8">
                                <textarea v-model="comment.content" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200" rows="4" placeholder="Escribe tu comentario"></textarea>
                                <button type="button" @click="sendComment()" class="px-4 py-2 mt-4 text-white bg-indigo-500 rounded-md hover:bg-indigo-600">Enviar comentario</button>
                        </div>
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
        post:Object,
        comments: Object
    },
    data() {
        return {
            comment:{
                content: '',
                post_id: this.post.id,
                user_id: this.$page.props.auth.user.id,
            },
            comments2: this.comments,
        }
    },
    methods: {
        sendComment() {
            event.preventDefault();
            console.log('Enviando comentario');
            axios.post(route('comment.store'), this.comment)
                .then(response => {
                    this.comment.content = '';
                    console.log('Comentario enviado:', response.data);
                })
                .catch(error => {
                    console.error('Error al enviar el comentario:', error);
                });
        },
        pollRoute() {
            this.pollInterval = setInterval(() => {
                axios.get(route('comment.comments', { id: this.post.id }))
                    .then(response => {
                        console.log('Polling:', response.data);
                        this.comments2 = response.data["data"];
                    })
                    .catch(error => {
                        console.error('Error while polling:', error);
                    });
            }, 3000);
        },
        eliminarcomment(id) {
        Swal.fire({
            title: '¿Estás seguro de querer eliminar el comentario?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`/comment/delete/${id}`)
                    .then(response => {
                        Swal.fire(
                            'Eliminado',
                            'El comentario ha sido eliminado.',
                            'success'
                        );
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error',
                            'No se ha podido eliminar el comentario.',
                            'error'
                        );
                    });
            }
        });
    },
    editcomment(id) {
        Swal.fire({
            title: 'Editar comentario',
            input: 'textarea',
            maxlength: 200,
            inputValue: this.comments2.find(comment => comment.id === id).content,
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Editar',
            showLoaderOnConfirm: true,
            preConfirm: (content) => {
                axios.put(`/comment/update/${id}`, { content: content, user_id: this.$page.props.auth.user.id, post_id: this.post.id})
                    .then(response => {
                        Swal.fire(
                            'Editado',
                            'El comentario ha sido editado.',
                            'success'
                        );
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error',
                            'No se ha podido editar el comentario.',
                            'error'
                        );
                        console.error(error);
                    });
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    },formaterDate(date){
        return new Date(date).toLocaleString();
    },
    eliminarpost(id) {
        Swal.fire({
            title: '¿Estás seguro de querer eliminar el post?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`/post/delete/${id}`)
                    .then(response => {
                        Swal.fire(
                            'Eliminado',
                            'El post ha sido eliminado.',
                            'success'
                        );
                        router.push('/mispublicaciones');
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error',
                            'No se ha podido eliminar el post.',
                            'error'
                        );
                    });
            }
        });
    },editpost(id) {
        Swal.fire({
            title: 'Editar post',
            html:  `
    <input id="titulo" value="${this.post.title}" class="swal2-input">
    <textarea id="contenido" class="swal2-textarea">${this.post.content}</textarea>
  ` ,
            inputValue: this.post.content,
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Editar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
             var a = document.getElementById('titulo').value
              var b = document.getElementById('contenido').value 
              console.log(a,b)
                axios.put(`/post/update/${id}`, { content: b, title: a})
                    .then(response => {
                        Swal.fire(
                            'Editado',
                            'El post ha sido editado.',
                            'success'
                        );
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error',
                            'No se ha podido editar el post.',
                            'error'
                        );
                        console.error(error);
                    });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }); 
    },


    },
    mounted() {
        this.pollRoute();
    },
    beforeUnmount() {
    clearInterval(this.pollInterval);
    },

}
</script>