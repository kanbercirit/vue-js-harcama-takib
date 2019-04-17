<template>
  <div>
    <button @click="ekle">Ekle</button>
    <table class="table table-hover table-responsive table-sm">
      <thead>
        <tr>
          <th class="w-10-pct">Tarih</th>
          <th class="w-10-pct">Nev</th>
          <th class="w-15-pct">Mikdar</th>
          <th class="w-15-pct">İzah</th>
          <th class="w-25-pct text-align-center">İşlemler</th>
        </tr>
      </thead>
      <tbody id="harcama-tablo-govde">
        <tr v-for="(kayit, index) in kayitlar" :value="kayit.OKytNo" :key="index">
          <td>{{kayit.Tarih}}</td>
          <td>{{kayit.Nev}}</td>
          <td>{{kayit.Mikdar}}</td>
          <td>{{kayit.Izah}}</td>
          <td>
            <button
              class="btn btn-info m-r-10px update-product-button btn-sm"
              @click="DuzeltmeyeHazirla(index)"
            >
              <span class="fa fa-edit"></span>
              Düzelt
            </button>
            <button
              class="btn btn-danger delete-product-button btn-sm"
              @click="SilmeyeHazirla(index)"
            >
              <span class="fa fa-remove"></span> Sil
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
      var kilon = Ensar.clone(this.kayitlar[pIntA]);
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
      }
    },
    Sil: function(pIntA) {
      this.$emit("GridKaydiSil", pIntA);
    },
    ekle: function() {
      this.kayitlar.push({
        OKytNo: 8965550,
        Tarih: "2019-01-08",
        Nev: "Patates",
        RbtHarcamaNevleri: 5,
        Mikdar: 56,
        Izah: "Yok"
      });
    }
  }
};
</script>

<style scope>
</style>
