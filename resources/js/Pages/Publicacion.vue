<template>
    <AuthenticatedLayout></AuthenticatedLayout>
    <div class="publicacion">
        <h1>{{ post.titulo }}</h1>
        <p>{{ post.contenido }}</p>
        <div class="autor">
            <span>Por: {{ post.autor }}</span>
            <span>Fecha: {{ post.fecha }}</span>
        </div>
    </div>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
export default {
    data() {
        return {
            post: {
                titulo: 'Título del post',
                contenido: 'Contenido del post',
                autor: 'Nombre del autor',
                fecha: 'Fecha del post'
            }
        };
    }
};
</script>

<style scoped>
.publicacion {
    /* Estilos para el contenedor de la publicación */
}

h1 {
    /* Estilos para el título del post */
}

p {
    /* Estilos para el contenido del post */
}

.autor {
    /* Estilos para la información del autor */
}
</style>