import Vue from "vue";
import {Header} from "./Header";

new Vue({
    el: "#vue_admin",
    template: `<div class="app">
                   <Header></Header>
               </div>`,
    components: {
        Header
    }
});