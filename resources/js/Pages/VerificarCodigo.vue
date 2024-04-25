<template>
    <div class="verification-modal" style="align-items: center;">
        <h2>Verification Code</h2>
        <p>Please enter the verification code:</p>
        <input type="text" v-model="verificationCode" />
        <button @click="verifyCode()">Verify</button>
    </div>

</template>
<script>    
export default {
    props: {
        codigo: String,
    },
    methods: {
        redirect() {
        window.location.href = '/Dashboard';
        },
        verifyCode() {
            if (this.verificationCode === this.codigo) {
                this.redirect();
            } else {
                alert('Invalid code');
            }
        }
    }
    
}
</script>