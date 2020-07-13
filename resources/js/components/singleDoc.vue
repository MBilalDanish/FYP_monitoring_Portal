
<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-11">
        <div class="card">
          <div class="card-header">
            <div style="float:left;">
              <div class="btn-group" role="group" aria-label="Basic example">
                <button class="btn btn-success" :disabled="isLoading" @click="viewDoc">View Document</button>
                <button class="btn btn-primary" :disabled="isLoading" @click="getMarks">Assign Marks</button>
                <button
                  class="btn btn-warning"
                  :disabled="isLoading"
                  @click="getFeedback"
                >Give Feedback</button>
                <button
                  class="btn btn-danger"
                  :disabled="isLoading"
                  @click="getPercent"
                >Compare with Documents</button>
                
                <button
                  class="btn btn-info"
                  :disabled="isLoading"
                  @click="download"
                >Download</button>
              </div>
            </div>

            <div style="float:right;" class="text-bold">Page Loaded:{{currentPage}} / {{pageCount}}</div>
          </div>

          <div class="card-body">
            <div class="loader" style="margin-right:-500;" v-if="isLoading"></div>
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
                        <div class="progress rounded-0">
                          <div
                            v-show="checkPercentage1(result.percentage)"
                            class="progress-bar progress-bar-striped progress-bar-animated level1"
                            :style="{'width':result.percentage+'%'}"
                          ></div>
                          <div
                            v-show="checkPercentage2(result.percentage)"
                            class="progress-bar progress-bar-striped progress-bar-animated level2"
                            :style="{'width':result.percentage+'%'}"
                          ></div>
                          <div
                            v-show="checkPercentage3(result.percentage)"
                            class="progress-bar progress-bar-striped progress-bar-animated level3"
                            :style="{'width':result.percentage+'%'}"
                          ></div>
                          <div
                            v-show="checkPercentage4(result.percentage)"
                            class="progress-bar progress-bar-striped progress-bar-animated level4"
                            :style="{'width':result.percentage+'%'}"
                          ></div>
                        </div>
                      </td>
                      <td>
                        <span class="badge red">{{result.percentage}}%</span>
                      </td>
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
      pageCount: 0,
      isLoading: false
    };
  },
  components: {
    pdf: pdf
  },
  methods: {
    download() {
              axios({
                    url: this.path,
                    method: 'GET',
                    responseType: 'blob',
                }).then((response) => {
                     var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                     var fileLink = document.createElement('a');

                     fileLink.href = fileURL;
                     fileLink.setAttribute('download', 'file.pdf');
                     document.body.appendChild(fileLink);

                     fileLink.click();
                });
          },
    checkPercentage1(per) {
      if (per > 0 && per <= 27) return true;
      return false;
    },
    checkPercentage2(per) {
      if (per > 27 && per <= 50) return true;
      return false;
    },
    checkPercentage3(per) {
      if (per > 50 && per <= 75) return true;
      return false;
    },
    checkPercentage4(per) {
      if (per > 75) return true;
      return false;
    },
    getPercent() {
      this.isLoading = true;
      const data = new FormData();
      data.append("d_id", this.d_id);
      axios
        .post("api/docCom", data)
        .then(({ data }) => (this.results = data))
        .catch(() => {})
        .finally(() => {
          this.isLoading = false;
          this.showModal();
        });
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
