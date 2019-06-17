<template>
  <div class="container">
    <div class="row" style="margin-top:10px;">
      <app-login
        :girisYapmis="girisYapmis"
        :mesaj="loginMesaj"
        :girisBilgileri="girisBilgileri"
        @GirisYap="GirisYap"
      ></app-login>
    </div>
    <div class="row">
      <app-user-panel
        :girisYapmis="girisYapmis"
        :kullaniciIsmi="kullaniciIsmi"
        @KullaniciyiCikart="KullaniciyiCikart"
      ></app-user-panel>
    </div>
    <div class="row" v-show="girisYapmis">
      <appTarihAraligi
        @TarihAraligiDegisti="VerileriGetir"
        :umumiYekun="umumiYekun"
        :tarihler="tarihler"
      ></appTarihAraligi>
      <div id="tabs" style="margin-top:10px;">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#sarfiyat">Harcamalar</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#akarat">Gelirler</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#varidat">Varlıklar</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#odemeplani">Ödeme Planı</a>
          </li>
        </ul>
        <div class="tab-content border border-top-0" style="margin-top:0px;">
          <div class="tab-pane container active" id="sarfiyat">
            <appKayitGrid
              :name="'harcamalar'"
              :kayitlar="sarfiyat"
              :nevler="sarfNevleri"
              :kayit="sarf"
              @KayitGridKaydiSil="HarcamaKaydiSil"
              @KayitGridKayitDegisti="HarcamaKaydiDegisti"
              @Kaydet="HarcamayiKaydet"
            ></appKayitGrid>
          </div>
          <div class="tab-pane container fade" id="akarat">
            <appKayitGrid
              :name="'gelirler'"
              :kayitlar="gelirler"
              :nevler="gelirNevleri"
              :kayit="gelir"
              @KayitGridKaydiSil="GelirKaydiSil"
              @KayitGridKayitDegisti="GelirKaydiDegisti"
              @Kaydet="GeliriKaydet"
            ></appKayitGrid>
          </div>
          <div class="tab-pane container fade" id="varidat">
            <appKayitGrid
              :name="'mevcudat'"
              :kayitlar="mevcudat"
              :nevler="mevcudatNevleri"
              :kayit="mevcud"
              @KayitGridKaydiSil="MevcutKaydiSil"
              @KayitGridKayitDegisti="MevcutKaydiDegisti"
              @Kaydet="MevcuduKaydet"
            ></appKayitGrid>
          </div>
          <div class="tab-pane container fade" id="odemeplani">...</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Ensar } from "./assets/js/Ensar.js";
import { eventBus } from "./main.js";
import KayitGrid from "./components/KayitGrid";
import TarihAraligi from "./components/TarihAraligi";
import Login from "./components/login/Login";
import UserPanel from "./components/login/UserPanel";

import Vue from "vue";
import axios from "axios";
import moment from "moment";

Vue.prototype.moment = moment;
Vue.prototype.$http = axios;
axios.interceptors.request.use(
  config => {
    let token = localStorage.token;
    if (token) {
      config.headers["Authorization"] = `Bearer ${token}`;
    }
    return config;
  },
  error => {
    return Promise.reject("Hata: " + error);
  }
);

export default {
  name: "AnaUygulama",
  components: {
    appKayitGrid: KayitGrid,
    appTarihAraligi: TarihAraligi,
    appLogin: Login,
    appUserPanel: UserPanel
  },
  data: function() {
    return {
      loginMesaj: "",
      token: localStorage.getItem("token"),
      girisBilgileri: { email: "ali.koca@gmail.com", sifre: "Arjun@123" },
      kullaniciIsmi: null,
      tarihler: { ilkTarih: new Date(), sonTarih: new Date() },
      sarfNevleri: Array,
      gelirNevleri: Array,
      mevcudatNevleri: Array,

      sarfiyat: [],
      gelirler: [],
      mevcudat: [],

      gelir: {},
      //sarf: { Tarih: "2019-04-23", RbtNevler: 3, Mikdar: "1.02" },
      sarf: {},
      mevcud: {},
      umumiYekun: {}
    };
  },
  methods: {
    /*
    moment: function(date) {
      moment.locale();
      return moment(date);
    },
    date: function(date) {
      return moment(date).format("DD.MM.YYYY");
    },
    dateTime: function(date) {
      return moment(date).format("DD.MM.YYYY hh:mm:ss");
    },*/
    GirisYap: function(pGirisBilgileri) {
      //alert("GirisYap");
      const baseURI = eventBus.restApiKok + "/login";
      this.$http.post(baseURI, pGirisBilgileri).then(result => {
        if (result.data.Netice === "Tamam") {
          this.token = result.data.Token;
          this.TarihAyarla();
          this.VerileriGetir();
          this.loginMesaj = "";
        } else {
          if (result.data.Netice === "Hata!") {
            this.loginMesaj = result.data.Mesaj;
          }
        }
      });
    },
    KullaniciyiCikart() {
      this.DegiskenleriBosalt();
    },
    DegiskenleriBosalt: function() {
      this.loginMesaj = "";
      localStorage.removeItem("token");
      this.token = "";
      this.kullaniciIsmi = null;
      this.TarihAyarla();
      this.sarfNevleri = Array;
      this.gelirNevleri = Array;
      this.mevcudatNevleri = Array;
      this.sarfiyat = [];
      this.gelirler = [];
      this.mevcudat = [];
      this.gelir = { Tarih: this.gelir.Tarih };
      this.sarf = { Tarih: this.sarf.Tarih };
      //console.log("Sarf: " + this.sarf);
      this.mevcud = { Tarih: this.mevcud.Tarih };
      this.umumiYekun = {};
    },
    TarihleriGetir: function() {
      return (
        Ensar.yilAyGunTarih(this.tarihler.ilkTarih) +
        "/" +
        Ensar.yilAyGunTarih(this.tarihler.sonTarih)
      );
    },
    KullaniciGetir: function() {
      //kullaniciIsmi
      const baseURI = eventBus.restApi + "/user";
      this.$http.get(baseURI).then(result => {
        this.kullaniciIsmi = result.data.Veriler;
        this.kullaniciIsmi =
          this.kullaniciIsmi[0]["isim"] +
          " " +
          this.kullaniciIsmi[0]["soyisim"];
      });
    },
    KayitlarDegisti: function() {
       this.UmumiYekunGetir();
    },
    HarcamayiKaydet: function(pKayitDurumu) {
      if (pKayitDurumu === "Yeni Kayıt") {
        const baseURI = eventBus.restApi + "/harcama";
        this.$http.post(baseURI, this.sarf).then(result => {
          this.sarfiyat.splice(0, 0, result.data.Veriler);
          this.sarf = { Tarih: this.sarf.Tarih };
        });
      }
      if (pKayitDurumu === "Düzenleme") {
        const baseURI = eventBus.restApi + "/harcama";
        this.$http.put(baseURI, this.sarf).then(result => {
          this.sarfiyat.splice(this.sarf.indexNo, 1, result.data.Veriler);
          this.sarf = { Tarih: this.sarf.Tarih };
        });
      }
      this.KayitlarDegisti();
    },
    HarcamaKaydiDegisti: function(pKayit) {
      this.sarf = pKayit;
    },
    HarcamaKaydiSil: function(pIntA) {
      const baseURI =
        eventBus.restApi + "/harcama/" + this.sarfiyat[pIntA].OKytNo;
      this.$http.delete(baseURI).then(result => {
        if (result.data.Veriler.SilinenKayitAdedi > 0) {
          this.$delete(this.sarfiyat, pIntA);
        }
      });
    },
    GeliriKaydet: function(pKayitDurumu) {
      if (pKayitDurumu === "Yeni Kayıt") {
        const baseURI = eventBus.restApi + "/gelir";
        this.$http.post(baseURI, this.gelir).then(result => {
          this.gelirler.splice(0, 0, result.data.Veriler);
          this.gelir = { Tarih: this.gelir.Tarih };
        });
      }
      if (pKayitDurumu === "Düzenleme") {
        const baseURI = eventBus.restApi + "/gelir";
        this.$http.put(baseURI, this.gelir).then(result => {
          this.gelirler.splice(this.gelir.indexNo, 1, result.data.Veriler);
          this.gelir = { Tarih: this.gelir.Tarih };
        });
      }
    },
    GelirKaydiDegisti: function(pKayit) {
      this.gelir = pKayit;
    },
    GelirKaydiSil: function(pIntA) {
      const baseURI =
        eventBus.restApi + "/gelir/" + this.gelirler[pIntA].OKytNo;
      this.$http.delete(baseURI).then(result => {
        if (result.data.Veriler.SilinenKayitAdedi > 0) {
          this.$delete(this.gelirler, pIntA);
        }
      });
    },
    MevcuduKaydet: function(pKayitDurumu) {
      if (pKayitDurumu === "Yeni Kayıt") {
        const baseURI = eventBus.restApi + "/mevcudat";
        this.$http.post(baseURI, this.mevcud).then(result => {
          this.mevcudat.splice(0, 0, result.data.Veriler);
          this.mevcud = { Tarih: this.mevcud.Tarih };
        });
      }
      if (pKayitDurumu === "Düzenleme") {
        const baseURI = eventBus.restApi + "/mevcudat";
        this.$http.put(baseURI, this.mevcud).then(result => {
          this.mevcudat.splice(this.mevcud.indexNo, 1, result.data.Veriler);
          this.mevcud = { Tarih: this.mevcud.Tarih };
        });
      }
    },
    MevcutKaydiDegisti: function(pKayit) {
      this.mevcud = pKayit;
    },
    MevcutKaydiSil: function(pIntA) {
      const baseURI =
        eventBus.restApi + "/mevcudat/" + this.mevcudat[pIntA].OKytNo;
      this.$http.delete(baseURI).then(result => {
        if (result.data.Veriler.SilinenKayitAdedi > 0) {
          this.$delete(this.mevcudat, pIntA);
        }
      });
    },
    GelirleriGetir: function() {
      const baseURI = eventBus.restApi + "/gelirler/" + this.TarihleriGetir();
      this.$http.get(baseURI).then(result => {
        this.gelirler = result.data.Veriler;
      });
    },
    SarfiyatGetir: function() {
      const baseURI = eventBus.restApi + "/harcamalar/" + this.TarihleriGetir();
      this.$http.get(baseURI).then(result => {
        this.sarfiyat = result.data.Veriler;
      });
    },
    MevcudatGetir: function() {
      const baseURI = eventBus.restApi + "/mevcudat/" + this.TarihleriGetir();
      this.$http.get(baseURI).then(result => {
        this.mevcudat = result.data.Veriler;
      });
    },
    GelirNevleriGetir: function() {
      const baseURI = eventBus.restApi + "/gelirnevleri";
      this.$http.get(baseURI).then(result => {
        this.gelirNevleri = result.data[0];
      });
    },
    SarfNevleriGetir: function() {
      const baseURI = eventBus.restApi + "/harcamanevleri";
      this.$http.get(baseURI).then(result => {
        this.sarfNevleri = result.data[0];
      });
    },
    MevcudatNevleriGetir: function() {
      const baseURI = eventBus.restApi + "/mevcudatnevleri";
      this.$http.get(baseURI).then(result => {
        this.mevcudatNevleri = result.data[0];
      });
    },
    UmumiYekunGetir: function() {
      const baseURI = eventBus.restApi + "/umumiYekun/" + this.TarihleriGetir();
      this.$http.get(baseURI).then(result => {
        this.umumiYekun = result.data.Veriler[0];
      });
    },
    VerileriGetir: function() {
      this.SarfNevleriGetir();
      this.GelirNevleriGetir();
      this.MevcudatNevleriGetir();
      this.SarfiyatGetir();
      this.GelirleriGetir();
      this.MevcudatGetir();
      this.UmumiYekunGetir();
      this.KullaniciGetir();
    },
    TarihAyarla: function() {
      let tarih = new Date();
      this.tarihler = Ensar.donemGetir(tarih);
    }
  },
  created() {},
  filters: {
    moment: function(date) {
      return moment(date).format("L");
    }
  },
  mounted() {
    if (localStorage.getItem("token")) {
      this.token = localStorage.getItem("token");
    }
    if (this.token == null) {
      this.token = "";
    }
    if (this.token != "") {
      this.TarihAyarla();
      this.VerileriGetir();
    }
    //console.log("this.token: " + this.token);
  },
  computed: {
    girisYapmis: function() {
      let netice = false;
      if (this.token != "") {
        netice = true;
      }
      return netice;
    }
  },
  watch: {
    token(newtoken) {
      localStorage.setItem("token", newtoken);
    }
  }
};
</script>

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
