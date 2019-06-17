<template>
  <div v-if="girisYapmis" class="header">
    <div class="contanier">
      <span class="badge badge-info">Kullanıcı İsmi: {{kullaniciIsmi}}</span>
      <button @click="KullaniciyiCikart" class="btn btn-danger btn-sm">Çıkış Yap</button>
    </div>
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
.header {
  background: #eceaeab7;
  width: 877px;
  margin-bottom: 5px;
  -webkit-border-radius: 5px 5px 5px 5px;
  border-radius: 5px 5px 5px 5px;
  padding: 0px;
  -webkit-box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
  box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
  text-align: right;
}
.color-blue {
  color: #1d92af;
}
.color-segreen {
  color: #3f7577;
}
.color-orang {
  color: #ce7b11;
}
.padding-top > .col-md-6 {
  padding-bottom: 15px;
}
</style>
