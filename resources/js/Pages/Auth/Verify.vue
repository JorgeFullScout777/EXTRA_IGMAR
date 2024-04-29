
<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
      <div class="w-full max-w-md">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="submit">
          <div class="mb-4">
            <h1 class="block text-gray-700 text-sm font-bold mb-2">Verify Your Code</h1>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="code" type="text" v-model="form.code" required autofocus>
            <p v-if="errors.verification_code" class="text-red-500 text-xs italic">{{ errors.verification_code }}</p>
          </div>
          <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
              Verify
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  export default {
      props: {
          errors: {}
      },
      data() {
          return {
              form: {
                code: '',
              },
          };
      },
      methods: {
          async submit() {
              try {
                
                 this.$inertia.post('http://127.0.0.1:8000/verificar', this.form);
              } catch (error) {
                  console.error(error);
              }
          },
      },
  };
  </script>