import Vue from "vue";
import App from "./App.vue";
import {IUserRepository} from "./Repository/Contract";
import {RepositoryFactory} from "./Repository/Implementation";
import {store} from "./store";

const userRepository: IUserRepository = RepositoryFactory.create('user');

new Vue({
    el: "#vue_app",
    template: `<App></App>`,
    data: {
        shared: store.state
    },
    components: {
        App
    },
    created() {
        userRepository.asyncRead().then((user) => {
            store.addUser(user);
        });
    }
});