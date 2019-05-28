<template>
  <div v-if="girisYapmis" class="header">
    Kullanıcı İsmi: {{kullaniciIsmi}}
    <a @click="KullaniciyiCikart">Çıkış Yap</a>
  </div>
</template>


<script>
export default {
  data() {
    return {
      isim: null
    };
  },
  props: {
    kullaniciIsmi: null,
    girisYapmis: null
  },
  methods: {
    SelamGonder: function() {
      this.$emit("SelamGonder", this.isim);
    },
    KullaniciyiCikart: function() {
      this.$emit("KullaniciyiCikart");
    }
  }
};
</script>

<style scoped>
.header a {
  cursor: pointer;
}
</style>
