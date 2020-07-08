
<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-11">
        <div class="card">
          <div class="card-header">
            <div style="float:left;">
              <button class="btn btn-success" @click="viewDoc">View Document</button>
              <button class="btn btn-success" @click="getMarks">Assign Marks</button>
              <button class="btn btn-success" @click="getFeedback">Give Feedback</button>
            </div>
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

export default {
  data() {
    return {
      d_id: "",
      path: "",
      src: "",
      marks: "",
      feedback: "",
      numPages: 2,
      currentPage: 0,
      pageCount: 0
    };
  },
  components: {
    pdf: pdf
  },
  methods: {
    getFeedback() {
      swal
        .fire({
          input: "textarea",
          inputPlaceholder: "Type your message here...",
          inputAttributes: {
            "aria-label": "Type your message here"
          },
          showCancelButton: true
        })
        .then(result => {
          if (result.value) {
            this.feedback = result.value;
            this.setFeedback();
          }
        });
    },
    getMarks() {
      swal
        .fire({
          title: "Assign Marks",
          icon: "question",
          input: "range",
          inputAttributes: {
            min: 5,
            max: 100,
            step: 1
          },
          inputValue: 25
        })
        .then(result => {
          if (result.value) {
            this.marks = result.value;
            this.setMarks();
          }
        });
    },
    setFeedback() {
      const dataf = new FormData();
      dataf.append("d_id", this.d_id);
      dataf.append("feedback", this.feedback);
      axios.post("api/assignMarks", dataf).then(response => {
        toast.fire({
          icon: "success",
          title: "Feedback Saved"
        });
      });
    },
    setMarks() {
      const data = new FormData();
      data.append("d_id", this.d_id);
      data.append("marks", this.marks);
      axios.post("api/assignMarks", data).then(response => {
        toast.fire({
          icon: "success",
          title: "Marks Assigned Successfully"
        });
      });
    },
    viewDoc() {
      this.$Progress.start();
      this.src = pdf.createLoadingTask(this.path);
      this.src.promise.then(pdf => {
        this.numPages = pdf.numPages;
      });
      this.$Progress.finish();
    },
    loadDocumentDetails() {
      this.$Progress.start();
      axios
        .get("api/singleDocument/" + this.d_id)
        .then(({ data }) => (this.path = data.data));
      this.$Progress.finish();
    }
  },
  mounted() {
    if (document_id != "") {
      this.d_id = document_id;
      this.loadDocumentDetails();
    } else {
      this.$router.push("/documentsteacher");
    }
  }
};
</script>
