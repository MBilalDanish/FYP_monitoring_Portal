<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">View Document</div>

          <div v-show="d_id!=''" class="card-body">{{d_id}}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
      data() {
    return {
          d_id: "",
      editmode: false,
      documents: {},
      form: new Form({
        student_id: "",
        id: "",
        document_type: "",
        title: "",
        description: "",
        file: ""
      })
    };
  },

  methods: {
    loadDocumentDetails() {
      this.$Progress.start();
      this.form.get("api/singledocument")
        .then(({ data }) => (this.documents = data));
      this.$Progress.finish();
    }
  },
  mounted() {},
  created() {
    if (document_id != "") {
      this.d_id = document_id;
      this.form.id=document_id;
      this.loadDocumentDetails();
    } else {
      this.$router.push("/documentsteacher");
    }
  }
};
</script>
