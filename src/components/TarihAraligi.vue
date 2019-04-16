<template>
  <div class="input-group col-md-12">
    <label class="col-form-label">İlk Tarih:</label>
    <input type="date" class="form-control col-sm-2" v-model="tarihler.ilkTarih" required>
    <label class="col-form-label">Son Tarih:</label>
    <input type="date" class="form-control col-sm-2" v-model="tarihler.sonTarih" required>
    <button class="btn btn-success" @click="getir">Getir</button>
  </div>
</template>

<script>
export default {
  name: "TarihAraligi",
  props: {
    tarihler: {}
  },
  methods: {
    getir: function() {
      this.$emit("TarihAraligiDegisti", this.tarihler);
    }
  }
};
</script>