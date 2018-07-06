import Vue from "vue";
import {IUserRepository} from "./Repository/Contract";
import {RepositoryFactory} from "./Repository/Implementation";
import {store} from "./store";
import {User} from "./Repository/Models";

import {Header as PublicHeader} from "./Public/Header";
import {Body as PublicBody} from "./Public/Body";

const userRepository: IUserRepository = RepositoryFactory.create('user');

userRepository.read((response) => {
    new Vue({
        el: "#vue_app",
        template: `<div class="app">
                       <PublicHeader></PublicHeader>
                       <PublicBody></PublicBody>
                   </div>`,
        components: {
            PublicHeader,
            PublicBody
        },
        beforeCreate() {
            store.addUser(new User(response.resource.data));
        }
    });
});