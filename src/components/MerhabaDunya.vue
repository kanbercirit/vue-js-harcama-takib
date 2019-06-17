<template>
  <div class="merhaba">
    <button class="btn btn-success">Tıkla</button>
    <div class="alert alert-primary" role="alert">{{ mesaj }}</div>
    <div class="alert alert-danger" role="alert">{{isim}}</div>
  </div>
</template>

<script>
export default {
  name: "Merhaba",
  props: {
    isim: String,
    likes: Number,
    isPublished: Boolean,
    commentIds: Array,
    author: Object,
    callback: Function,
    contactsPromise: Promise // or any other constructor
  },
  data() {
    return {
      mesaj: "Merhaba Dünya!"
    };
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
