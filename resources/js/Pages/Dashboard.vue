<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Principal" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 " style="text-align: center;">Canales</h2>
            <a :href="route('channel.crear', { id: $page.props.auth.user.id })"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear</button></a>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <ul>
                        <li v-for="channel in channels2" :key="channel.id">
                            <a :href="route('post.posts', { id: channel.id })">{{ channel.name }}</a>
                            <p>{{ channel.description }}</p>
                            <p class="border-t border-gray-200 mt-4"></p>
                        </li>
                    </ul>
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
