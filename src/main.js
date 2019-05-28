import Vue from "vue";
import App from "./App.vue";
import "bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";
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

//export const uygulama =
new Vue({
  render: h => h(App)
}).$mount("#app");
