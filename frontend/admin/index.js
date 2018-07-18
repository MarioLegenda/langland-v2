import Vue from 'vue';
import VueRouter from 'vue-router'

import {routes} from "./js/routes";
import {Header} from "./js/Header";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

new Vue({
    el: '#vue_admin',
    router: router,
    template: `<div>
                   <Header></Header>
                   
                   <div class="container">
                       <div class="bs-docs-section">
                           <div class="row">
                               <router-view></router-view>
                           </div>
                       </div>
                   </div>
               </div>`,
    components: {
        Header
    }
});