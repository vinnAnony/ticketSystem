<template>
    <div class="container">
        <div class="row justify-content-center">
            <landing></landing>
        </div>
    </div>
</template>

<script>
import Landing from './Landing.vue'
import NotFound from './NotFound.vue'
    export default {
  components: { NotFound, Landing },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
