<template>
  <div>
    <div class="control">
      <div class="input-group mb-3">
        <input type="hidden" v-model="kayit.indexNo">
        <input v-model="kayit.OKytNo" type="hidden">
        <input
          id="tbTarih"
          name="tbTarih"
          tabindex="1"
          type="date"
          v-model="kayit.Tarih"
          placeholder="Tarih"
          class="form-control"
          v-on:keyup.enter="$event.target.nextElementSibling.focus()"
          required
        >
        <select
          tabindex="2"
          placeholder="Nevi Giriniz"
          class="form-control"
          v-model="kayit.RbtNevler"
          v-on:keyup.enter="$event.target.nextElementSibling.focus()"
          required
        >
          <option
            v-for="nev in nevler"
            v-bind:value="nev.OKytNo"
            v-bind:key="nev.OKytNo"
          >{{ nev.NevIsmi }}</option>
        </select>
        <input
          type="Number"
          tabindex="3"
          v-model="kayit.Mikdar"
          step="0.01"
          placeholder="Mikdar"
          class="form-control"
          min="0"
          v-on:keyup.enter="$event.target.nextElementSibling.focus()"
          required
        >
        <input
          tabindex="4"
          v-model="kayit.Izah"
          type="text"
          placeholder="İzah"
          class="form-control"
          v-on:keyup.enter="izahEnterAsTab()"
        >
        <div class="input-group-prepend">
          <button
            id="btnKaydiEkle"
            name="btnKaydiEkle"
            tabindex="5"
            class="btn btn-success"
            v-if="kayitDurumu === 'Yeni Kayıt'"
            @click="Kaydet()"
          >
            <font-awesome-icon icon="pen"/>Kaydı Ekle
          </button>
          <button
            id="btnKaydiDuzenle"
            name="btnKaydiDuzenle"
            tabindex="6"
            class="btn btn-success"
            v-if="kayitDurumu === 'Düzenleme'"
            @click="Kaydet()"
          >
            <font-awesome-icon icon="pen-alt"/>Kaydı Güncelle
          </button>
          <button
            tabindex="7"
            class="btn btn-danger"
            @click="DuzeltmeyiIptalEt()"
            type="button"
            v-if="kayitDurumu === 'Düzenleme'"
          >
            <font-awesome-icon icon="times"/>İptal
          </button>
        </div>
      </div>
    </div>
    <b-alert
      :show="sayac"
      dismissible
      variant="warning"
      @dismissed="sayac=0"
      @dismiss-count-down="sayacAzalt"
    >
      <p>{{mesaj}}({{sayac}})</p>
      <b-progress variant="warning" :max="sure" :value="sayac" height="4px"></b-progress>
    </b-alert>
  </div>
</template>

<script>
import { Ensar } from "../assets/js/Ensar.js";
export default {
  name: "Kayd",
  props: {
    nevler: null,
    kayit: null
  },
  data() {
    return {
      sayac: 0,
      sure: 3,
      mesaj: ""
    };
  },
  methods: {
    sayacAzalt(psayac) {
      this.sayac = psayac;
    },
    mesajGoster(pMesaj, pSure = 3) {
      this.mesaj = pMesaj;
      this.sure = pSure;
      this.sayac = this.sure;
    },
    izahEnterAsTab: function() {
      if (this.kayitDurumu === "Düzenleme") {
        document.getElementById("btnKaydiDuzenle").focus();
      } else {
        document.getElementById("btnKaydiEkle").focus();
      }
    },
    setFocus: function(element) {
      document.getElementById(element).focus();
    },
    DuzeltmeyiIptalEt: function() {
      this.$emit("KayitDegisti", {});
    },
    Kaydet: function() {
      if (
        Ensar.tarihMi(this.kayit.Tarih) &&
        this.kayit.RbtNevler &&
        this.kayit.Mikdar &&
        this.kayit.Mikdar > 0
      ) {
        this.setFocus("tbTarih");
        this.$emit("KayitDegisti", this.kayit);
        this.$emit("Kaydet", this.kayitDurumu);
        //console.log(this.kayit);
      } else {
        this.mesajGoster("Veriler eksik girilmiş...");
      }
    }
  },
  computed: {
    kaydiGetir: function() {
      return this.kayit;
    },
    kayitDurumu: function() {
      return typeof this.kayit.indexNo === "number"
        ? "Düzenleme"
        : "Yeni Kayıt";
    }
  }
};
</script>
<style>
</style>
