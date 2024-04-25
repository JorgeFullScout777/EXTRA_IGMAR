<template>
    <div class="modal fade" :id="modalID" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">{{Titulo}}</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <slot>
    
                
              </slot>
            </div>
            
          </div>
        </div>
      </div>
    </template>
    
    <script>
    export default{
        props:{
            Titulo:String,
            modalID:String,
        },
        methods:{
          emitCloseEvent(){
            this.$emit('close');
          } 
        }
    }
    </script>
    
    