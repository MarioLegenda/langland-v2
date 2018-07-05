import Vue from "vue";
import App from "./App.vue";
import {IUserRepository} from "./Repository/Contract";
import {RepositoryFactory} from "./Repository/Implementation";
import {store} from "./store";
import {User} from "./Repository/Models";

const userRepository: IUserRepository = RepositoryFactory.create('user');

userRepository.read((response) => {
    new Vue({
        el: "#vue_app",
        template: `<App></App>`,
        components: {
            App
        },
        beforeCreate() {
            store.addUser(new User(response.resource.data));
        }
    });
});