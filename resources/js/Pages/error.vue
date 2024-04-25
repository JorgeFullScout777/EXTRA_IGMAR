<template>
    <h1 style="text-align: center;">{{ Data.Codigo }}</h1>
    <h1 style="text-align: center;">{{ Data.Error }}</h1>
</template>
<script>
export default {
    mounted() {
        this.redirect();
    },
    props: {
        Data:Array
    },
    methods: {
        redirect() {
            setTimeout(() => {
                window.location.href = '/';
            }, 3000);
        }
    }
}
</script>