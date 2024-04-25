<template>
    <button type="button" :class="btncolor" data-bs-toggle="modal" :data-bs-target="'#'+Modalid">{{ ButtonTitle }}</button>
</template>
<script>
export default {
    props:{
        Modalid:String,
        btncolor:String,
        ButtonTitle:String

    }
}
</script>