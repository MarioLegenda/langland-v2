import Vue from "vue";
import App from "./App.vue";

let v = new Vue({
    el: "#vue_app",
    template: `
    <div>
        Name: <input v-model="name" type="text">
        <App></App>
    </div>
    `,
    data: { name: "World" },
    components: {
        App
    }
});