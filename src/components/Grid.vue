<template>
  <div class="table-wrapper-scroll-y my-custom-scrollbar">
    <table class="table table-hover table-responsive table-sm">
      <thead>
        <tr>
          <th class="w-5-pct">S.No</th>
          <th class="w-10-pct">Tarih</th>
          <th class="w-10-pct">Nev</th>
          <th class="w-15-pct">Mikdar</th>
          <th class="w-15-pct">İzah</th>
          <th class="w-25-pct text-align-center">İşlemler</th>
        </tr>
      </thead>
      <tbody id="harcama-tablo-govde">
        <tr v-for="(kayit, index) in kayitlar" :value="kayit.OKytNo" :key="index">
          <td>{{kayitlar.length - index}}.</td>
          <td>{{kayit.Tarih}}</td>
          <td>{{kayit.Nev}}</td>
          <td>{{kayit.Mikdar}}</td>
          <td>{{kayit.Izah}}</td>
          <td>
            <button
              class="btn btn-info m-r-10px update-product-button btn-sm"
              @click="DuzeltmeyeHazirla(index)"
            >
              <font-awesome-icon icon="edit"/>Düzelt
            </button>
            <button
              class="btn btn-danger delete-product-button btn-sm"
              @click="SilmeyeHazirla(index)"
            >
              <font-awesome-icon icon="trash"/>Sil
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { Ensar } from "../assets/js/Ensar.js";
export default {
  name: "Grid",
  props: { kayitlar: null },
  data() {
    return {};
  },
  methods: {
    DuzeltmeyeHazirla: function(pIntA) {
      let kilon = Ensar.clone(this.kayitlar[pIntA]);
      kilon.indexNo = pIntA;
      this.$emit("KayitDegisti", kilon);
    },
    Duzelt: function(pIntA) {
      this.$emit("KaydiDuzelt", pIntA);
    },
    SilmeyeHazirla: function(pIntA) {
      let cevab = confirm("Kaydı silmek istediğinizden Emin Misiniz?");
      if (cevab == true) {
        this.Sil(pIntA);
        this.$emit("KayitDegisti", {});
      }
    },
    Sil: function(pIntA) {
      this.$emit("GridKaydiSil", pIntA);
    }
  }
};
</script>

<style scope>
</style>
