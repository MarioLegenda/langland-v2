<!-- src/components/Hello.vue -->

<template>
    <div class="mile">

    </div>
</template>

<script lang="ts">
    import Vue from "vue";
    import {IUserRepository} from "./Repository/Contract";
    import {RepositoryFactory} from "./Repository/Implementation";

    const userRepository: IUserRepository = RepositoryFactory.create('user');

    export default Vue.extend({

    });
</script>

<style>
</style>