<template>
  <div class="input-group col-sm-9">
    <label class="col-form-label">İlk Tarih:</label>
    <input type="date" class="form-control col-sm-2" v-model="tarihler.ilkTarih" required>
    <label class="col-form-label">Son Tarih:</label>
    <input type="date" class="form-control col-sm-2" v-model="tarihler.sonTarih" required>
    <button class="btn btn-success" @click="getir"><font-awesome-icon icon="arrow-down"/>Getir</button>
    <div style="margin-left :15px">
      <span class="badge badge-info">{{umumiYekun.gelirlerYekunu}}</span>
      <span class="badge badge-danger">-</span>
      <span class="badge badge-info">{{umumiYekun.harcamalarYekunu}}</span>
      <span class="badge badge-danger">-</span>
      <span class="badge badge-info">{{umumiYekun.MevcudatYekunu}}</span>
      <span class="badge badge-danger">=</span>
      <span class="badge badge-info">{{umumiYekun.Netice}}</span>
    </div>
  </div>
</template>

<script>
export default {
  name: "TarihAraligi",
  props: {
    tarihler: {},
    umumiYekun: null
  },
  methods: {
    getir: function() {
      this.$emit("TarihAraligiDegisti", this.tarihler);
    }
  }
};
</script>