<template>
  <div>
    {{nevAlanIsmi}}
    <form id="harcama-kayit-formu" @submit.prevent="harcamayiKaydet(this)">
      <div class="input-group mb-3">
        <input type="hidden" name="index" v-model="kayit.indexNo">
        <input type="date" v-model="kayit.Tarih" placeholder="Tarih" class="form-control" required>
        <select placeholder="Harcama Nevi Giriniz" class="form-control" :value="{nevAlanIsmi}">
          <option
            v-for="nev in nevler"
            v-bind:value="nev.OKytNo"
            v-bind:key="nev.OKytNo"
          >{{ nev.NevIsmi }}</option>
        </select>
        <input
          type="Number"
          v-model="kayit.Mikdar"
          step="0.01"
          placeholder="Mikdar"
          class="form-control"
          min="1"
          required
        >
        <input
          id="HarcamaIzah"
          v-model="kayit.Izah"
          name="Izah"
          type="text"
          placeholder="İzah"
          class="form-control"
        >
        <input id="HarcamaOKytNo" v-model="kayit.OKytNo" name="OKytNo" type="hidden">
        <div class="input-group-prepend">
          <button
            class="btn btn-success"
            v-if="kayitDurumu === 'Yeni Kayıt'"
            id="btnKaydet"
            name="btnKaydet"
            type="submit"
          >Kaydı Ekle</button>
          <button
            class="btn btn-success"
            v-if="kayitDurumu === 'Düzenleme'"
            id="btnKaydet"
            name="btnKaydet"
            type="submit"
          >Kaydı Güncelle</button>
          <button
            class="btn btn-danger"
            id="btnGuncellemeyiIptalEt"
            name="btnGuncellemeyiIptalEt"
            @click="harcamaDuzeltmeyiIptalEt()"
            type="button"
            v-if="kayitDurumu === 'Düzenleme'"
          >İptal</button>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
export default {
  name: "Kayd",
  props: {
    nevler: null,
    kayit: null,
    nevAlanIsmi: null
  },
  methods: {
    harcamaDuzeltmeyiIptalEt: function() {
      this.$emit("KayitDegisti", {});
    },
    harcamayiKaydet: function(pForm) {
      this.$emit("KayitDegisti", this.kayit);
      this.$emit("Kaydet", this.kayitDurumu);
      //if (this.kayitDurumu === "Yeni Kayıt") {
    }
  },
  data() {
    return {};
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
<style scope>
</style>
