<template>
  <div>
    <appKayit
      :nevler="nevler"
      :kayit="kayit"
      :nevAlanIsmi="nevAlanIsmi"
      @KayitDegisti="KayitDegisti"
      @Kaydet="Kaydet"
    ></appKayit>
    <appGrid
      @GridKaydiSil="KaydiSil"
      @KayitDegisti="KayitDegisti"
      :kayit="kayit"
      :kayitlar="kayitlar"
    ></appGrid>
  </div>
</template>

<script>
import Grid from "./Grid";
import Kayit from "./Kayit";

export default {
  components: {
    appGrid: Grid,
    appKayit: Kayit
  },
  props: {
    name: String,
    nevler: null,
    kayitlar: null,
    kayit: null,
    nevAlanIsmi: null
  },
  data: function() {
    return {};
  },
  methods: {
    KayitDegisti: function(pKayit) {
      this.$emit("KayitGridKayitDegisti", pKayit);
    },
    KaydiSil: function(pIntA) {
      this.$emit("KayitGridKaydiSil", pIntA);
    },
    Kaydet: function(pKayitDurumu) {
      this.$emit("Kaydet", pKayitDurumu);
    }
  },
  created() {}
};
</script>