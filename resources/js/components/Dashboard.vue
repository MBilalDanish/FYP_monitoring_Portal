<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Dashboard Component</div>

          <div class="card-body">{{d_id}}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  d_id: "",
  mounted() {},
  created() {
    this.d_id = document_id;
  }
};
</script>
