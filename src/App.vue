<template>
  <div class="container">
    <div class="row" style="margin-top:10px;">
      <appTarihAraligi @TarihAraligiDegisti="VerileriGetir" :tarihler="tarihler"></appTarihAraligi>
      <div class="umumi-yekun" id="left" style="display:none">
        <span id="GelirlerYekunu" name="GelirlerYekunu" class="badge badge-info"></span>
        <span class="badge badge-danger">-</span>
        <span id="HarcamalarYekunu" name="HarcamalarYekunu" class="badge badge-info"></span>
        <span class="badge badge-danger">-</span>
        <span id="VaridatYekunu" name="VaridatYekunu" class="badge badge-info"></span>
        <span class="badge badge-danger">=</span>
        <span id="EksikFazla" name="EksikFazla" class="badge badge-info"></span>
      </div>
    </div>
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
</template>

<script>
import { Ensar } from "./assets/js/Ensar.js";
import { eventBus } from "./main.js";
import KayitGrid from "./components/KayitGrid";
import TarihAraligi from "./components/TarihAraligi";
import Vue from "vue";
import axios from "axios";
import moment from "moment";

Vue.prototype.moment = moment;
Vue.prototype.$http = axios;

export default {
  name: "AnaUygulama",
  components: {
    appKayitGrid: KayitGrid,
    appTarihAraligi: TarihAraligi
  },
  data: function() {
    return {
      tarihler: { ilkTarih: new Date(), sonTarih: new Date() },
      sarfNevleri: Array,
      gelirNevleri: Array,
      mevcudatNevleri: Array,

      sarfiyat: [],
      gelirler: [],
      mevcudat: [],

      gelir: {},
      sarf: {},
      mevcud: {}
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
    TarihleriGetir: function() {
      return (
        Ensar.yilAyGunTarih(this.tarihler.ilkTarih) +
        "/" +
        Ensar.yilAyGunTarih(this.tarihler.sonTarih)
      );
    },
    HarcamayiKaydet: function(pKayitDurumu) {
      console.log(pKayitDurumu + " -- Harcama");
      console.log(JSON.stringify(this.sarf));
    },
    HarcamaKaydiDegisti: function(pKayit) {
      this.sarf = pKayit;
    },
    HarcamaKaydiSil: function(pIntA) {
      const baseURI = eventBus.restApi + "/harcama"; // + this.sarfiyat[pIntA].OKytNo;
      this.$http
        .delete(baseURI, { data: { OKytNo: this.sarfiyat[pIntA].OKytNo } })
        .then(result => {
          //this.sarfiyat = result.data.Veriler;
          this.$delete(this.sarfiyat, pIntA);
        });
    },

    GeliriKaydet: function(pKayitDurumu) {
      console.log(pKayitDurumu + " -- Gelir");
      console.log(JSON.stringify(this.gelir));
    },
    GelirKaydiDegisti: function(pKayit) {
      this.gelir = pKayit;
    },
    GelirKaydiSil: function(pIntA) {
      this.$delete(this.mevcudat, pIntA);
    },
    MevcuduKaydet: function(pKayitDurumu) {
      console.log(pKayitDurumu + " -- Mevcud");
      console.log(JSON.stringify(this.mevcud));
    },
    MevcutKaydiDegisti: function(pKayit) {
      this.mevcud = pKayit;
    },
    MevcutKaydiSil: function(pIntA) {
      this.$delete(this.sarfiyat, pIntA);
    },
    GelirleriGetir: function() {
      //               http://localhost:3000/ss/slim/gelirler/2019-01-15/2019-04-14
      const baseURI = eventBus.restApi + "/gelirler/" + this.TarihleriGetir();
      this.$http.get(baseURI).then(result => {
        this.gelirler = result.data.Veriler;
      });
    },
    SarfiyatGetir: function() {
      //               http://localhost:3000/ss/slim/harcamalar/2019-01-15/2019-04-14
      const baseURI = eventBus.restApi + "/harcamalar/" + this.TarihleriGetir();
      this.$http.get(baseURI).then(result => {
        this.sarfiyat = result.data.Veriler;
      });
    },
    MevcudatGetir: function() {
      //               http://localhost:3000/ss/slim/harcamalar/2019-01-15/2019-04-14
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
    VerileriGetir: function() {
      this.SarfiyatGetir();
      this.SarfNevleriGetir();
      this.GelirleriGetir();
      this.GelirNevleriGetir();
      this.MevcudatNevleriGetir();
      this.MevcudatGetir();
    }
  },
  created() {
    let tarih = new Date("2019-02-15");
    this.tarihler = Ensar.donemGetir(tarih);
    this.VerileriGetir();
  },
  filters: {
    moment: function(date) {
      return moment(date).format("L");
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
</style>
