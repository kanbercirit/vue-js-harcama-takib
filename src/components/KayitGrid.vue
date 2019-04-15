<template>
  <div>
    <appKayit :nevler="nevler" :kayd="sarf"></appKayit>
    <appGrid :kayitlar="sarfiyat"></appGrid>
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
    sarfiyat: null,
    sarf: {}
  },
  data: function() {
    return {};
  },
  methods: {},
  created() {}
};
</script>