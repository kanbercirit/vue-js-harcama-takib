<template>
  <div class="container">
    <div class="row" style="margin-top:10px;">
      <appTarihAraligi :tarihler="tarihler"></appTarihAraligi>
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
          <appKayitGrid :name="'sarfiyat'" :sarfiyat="sarfiyat" :nevler="sarfNevleri" :sarf="sarf"></appKayitGrid>
        </div>
        <div class="tab-pane container fade" id="akarat">
          <appKayitGrid
            :name="'gelirler'"
            :sarfiyat="gelirler"
            :nevler="gelirNevleri"
            :sarf="gelir"
          ></appKayitGrid>
        </div>
        <div class="tab-pane container fade" id="varidat">...</div>
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
Vue.prototype.$http = axios;

export default {
  name: "AnaUygulama",
  components: {
    appKayitGrid: KayitGrid,
    appTarihAraligi: TarihAraligi
  },
  data: function() {
    return {
      tarihler: { ilkTarih: null, sonTarih: null },
      sarfNevleri: Array,
      sarfiyat: [],
      gelirNevleri: Array,
      gelirler: [],
      gelir: {
        OKytNo: 8965550,
        Tarih: "2019-01-02",
        Nev: "Maaş",
        RbtHarcamaNevleri: 5,
        Mikdar: 1500,
        Izah: "Yok"
      },
      sarf: {
        OKytNo: 8965550,
        Tarih: "2019-01-08",
        Nev: "Patates",
        RbtHarcamaNevleri: 5,
        Mikdar: 56,
        Izah: "Yok"
      }
    };
  },
  methods: {
    TarihleriGetir: function() {
      return tarih + 
    },
    GelirleriGetir: function() {
      //               http://localhost:3000/ss/slim/gelirler/2019-01-15/2019-04-14
      const baseURI = eventBus.restApi + "/gelirler/2019-01-15/2019-04-14";
      this.$http.get(baseURI).then(result => {
        this.gelirler = result.data.Veriler;
      });
    },
    SarfiyatGetir: function() {
      //               http://localhost:3000/ss/slim/harcamalar/2019-01-15/2019-04-14
      const baseURI = eventBus.restApi + "/harcamalar/2019-01-15/2019-04-14";
      this.$http.get(baseURI).then(result => {
        this.sarfiyat = result.data.Veriler;
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
    VerileriGetir: function() {
      this.SarfiyatGetir();
      this.SarfNevleriGetir();
      this.GelirleriGetir();
      this.GelirNevleriGetir();
    }
  },
  created() {
    let tarih = new Date("2019-01-15");
    this.tarihler = Ensar.donemGetir(tarih);
    this.VerileriGetir();
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
