
<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-11">
        <div class="card">
          <div class="card-header">
            <div style="float:left;">View Document</div>
            <div style="float:right;">Page Loaded:{{currentPage}} / {{pageCount}}</div>
          </div>

          <div class="card-body">
            <div class="wrapper">
              <pdf
                v-for="i in numPages"
                :key="i"
                :src="src"
                :page="i"
                style="height: 100%"
                @num-pages="pageCount = $event"
                @page-loaded="currentPage = $event"
              ></pdf>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import pdf from "vue-pdf";
console.log(window.document_id);
var loadingTask = pdf.createLoadingTask('../storage/docs/Air Reservation updated_sdd_2020-07-04_06-17-51pm.pdf');
export default {
  data() {
    
    return {
      d_id: "",
      editmode: false,
      documents: {},
      path: "",
      src: loadingTask,
      numPages: 2,
      currentPage: 0,
      pageCount: 0
    };
  },
  components: {
    pdf: pdf
  },
  methods: {
        getPath(){
return this.path;
      },
    loadDocumentDetails() {
      this.$Progress.start();
      axios
        .get("api/singleDocument/" + this.d_id)
        .then(({ data }) => (this.path = data.data));
      // loadingTask=pdf.createLoadingTask(this.documents.data);

      this.$Progress.finish();
    }
  },
  mounted() {
    this.src.promise.then(pdf => {
      this.numPages = pdf.numPages;
    });
  },
  created() {
    if (document_id != "") {
      this.d_id = document_id;
      //this.form.id=document_id;
      this.loadDocumentDetails();
    } else {
      this.$router.push("/documentsteacher");
    }
  }
};
</script>
