
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
              <button class="btn btn-success" @click="getPercent">Compare with Documents</button>
             
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
          <!-- Modal -->
          <div
            class="modal"
            id="plagirism"
            tabindex="-1"
            aria-labelledby="plagirismLabel"
            aria-hidden="true"
          >
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="plagirismLabel">Comparison Results</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <!-- Table -->
                <table class="table table-condensed">
                  <tbody>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Document</th>
                      <th>Student</th>
                      <th>Similarity</th>
                      <th style="width: 40px">Similarity Lavel</th>
                    </tr>
                    <tr v-for="result in results.data" :key="result.id">
                      
                      <td>{{result.id}}</td>
                      <td>{{result.fileName}}</td>
                       <td>{{result.name}}</td>
                      <td>
                        <div class="progress progress-xs">
                          <div
                            class="progress-bar progress-bar-danger bg-danger"
                            style="width: 55%"
                          ></div>
                        </div>
                      </td>
                      <td>
                        <span class="badge red">{{result.percentage}}</span>
                      </td>


                      <!--Sample-->
                      <td>{{result.id}}</td>
                      <td>{{result.fileName}}</td>
                       <td>{{result.name}}</td>
                      <td>
                        <div class="progress progress-xs">
                          <div
                            class="progress-bar progress-bar-danger bg-danger"
                            style="width: 55%"
                          ></div>
                        </div>
                      </td>
                      <td>
                        <span class="badge red">{{result.percentage}}</span>
                      </td>
                      <!--End Sample-->
                      <!--Sample-->
                      <td>{{result.id}}</td>
                      <td>{{result.fileName}}</td>
                       <td>{{result.name}}</td>
                      <td>
                        <div class="progress progress-xs">
                          <div
                            class="progress-bar progress-bar-danger bg-danger"
                            style="width: 55%"
                          ></div>
                        </div>
                      </td>
                      <td>
                        <span class="badge red">{{result.percentage}}</span>
                      </td>
                      <!--End Sample-->
                    </tr>
                  </tbody>
                </table>

                <!--End Table-->
              </div>
            </div>
          </div>
          <!--Modal Ended-->
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
      results: {},
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
    getPercent() {
      const data = new FormData();
      data.append("d_id", this.d_id);
      axios.post("api/docCom", data).then(({ data }) => (this.results = data));
      this.showModal();
    },
    showModal() {
      $("#plagirism").modal("show");
    },
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
