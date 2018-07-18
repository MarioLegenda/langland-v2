import Vue from "vue";
import VueRouter from 'vue-router'

import {IUserRepository} from "../DataSource/Contract";
import {RepositoryFactory} from "../DataSource/Implementation";
import {store} from "./store";
import {User} from "../DataSource/Models";

import {Header as PublicHeader} from "../admin/js/Header";
import {LandingPage} from "./Public/LandingPage";
import {routes} from "./Public/routes";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const userRepository: IUserRepository = RepositoryFactory.create('user');

userRepository.read((response) => {
    new Vue({
        el: "#vue_app",
        router: router,
        template: `
                    <div class="app">
                       <PublicHeader></PublicHeader>
                       
                       <div id="main_body_content" class="main-body-content">
                           <transition name="fade">
                               <router-view></router-view>
                           </transition>
                       </div>
                   </div>`,
        components: {
            PublicHeader,
            LandingPage
        },
        beforeCreate() {
            store.addUser(new User(response.resource.data));
        }
    });
});