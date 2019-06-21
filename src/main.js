import "@babel/polyfill";
import "mutationobserver-shim";
import Vue from "vue";
import App from "./App.vue";
import { Ensar } from "./assets/js/Ensar.js";
import BootstrapVue from "bootstrap-vue";

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
  faEdit,
  faTrash,
  faDownload,
  faArrowDown,faSignOutAlt, faPlusSquare, faPen, faPenAlt, faWindowClose, faTimes
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faEdit, faTrash, faDownload, faArrowDown, faSignOutAlt, faPlusSquare, faPen, faPenAlt, faWindowClose, faTimes);

Vue.component("font-awesome-icon", FontAwesomeIcon);

Vue.use(BootstrapVue);

import "./assets/css/style.css";

Vue.config.productionTip = false;

export const eventBus = new Vue({
  name: "Sarfiyat",
  data() {
    return {
      restApi: "http://localhost:8081/api",
      restApiKok: "http://localhost:8081"
    };
  }
});

export const uygulama = new Vue({
  render: h => h(App)
}).$mount("#app");
