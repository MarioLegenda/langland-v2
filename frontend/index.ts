import Vue from "vue";
import {Header} from "./Header";
import {IUserRepository} from "./Repository/Contract";
import {RepositoryFactory} from "./Repository/Implementation";
import {store} from "./store";
import {User} from "./Repository/Models";

const userRepository: IUserRepository = RepositoryFactory.create('user');

userRepository.read((response) => {
    new Vue({
        el: "#vue_app",
        template: `<div class="app">
                       <Header></Header>
                   </div>`,
        components: {
            Header
        },
        beforeCreate() {
            store.addUser(new User(response.resource.data));
        }
    });
});