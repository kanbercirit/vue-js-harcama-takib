<template>
  <div>
    <form id="harcama-kayit-formu" onsubmit="return harcamayiKaydet(this)">
      <div class="input-group mb-3">
        <input type="date" v-model="kayd.Tarih" placeholder="Tarih" class="form-control" required>
        <select placeholder="Harcama Nevi Giriniz" class="form-control">
          <option
            v-for="nev in nevler"
            v-bind:value="nev.OKytNo"
            v-bind:key="nev.OKytNo"
          >{{ nev.NevIsmi }}</option>
        </select>
        <input
          type="Number"
          v-model="kayd.Mikdar"
          step="0.01"
          placeholder="Mikdar"
          class="form-control"
          min="1"
          required
        >
        <input
          id="HarcamaIzah"
          v-model="kayd.Izah"
          name="Izah"
          type="text"
          placeholder="İzah"
          class="form-control"
        >
        <input id="HarcamaOKytNo" v-model="kayd.OKytNo" name="OKytNo" type="hidden">
        <input id="HarcamaIndexNo" v-model="kayd.IndexNo" name="IndexNo" type="hidden">
        <div class="input-group-prepend">
          <button class="btn btn-success" id="btnKaydet" name="btnKaydet" type="submit">Kaydı Ekle</button>
          <button
            class="btn btn-danger"
            id="btnGuncellemeyiIptalEt"
            name="btnGuncellemeyiIptalEt"
            onclick="harcamaDuzeltmeyiIptalEt()"
            type="button"
            style="display:none"
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
    kayd: {}
  },
  methods: {
    a: function() {}
  },
  data() {
    return {};
  }
};
</script>
<style scope>
</style>
