<template>
  <div class="container">
    <div v-if="!$gate.isNotVerified()">
    <div class="row justify-content-center" v-if="$gate.isStudent()">
      <div class="col-md-12">
        <div class="card rounded-0">
          <div class="card-header">
            <h3 class="card-title" style="float:left">Documents</h3>

            <button class="btn btn-success" style="float:right" @click="newModal">
              Add New
              <i class="fa fa-user-plus fa-fw"></i>
            </button>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive no-padding">
            <table class="table table-hover table-striped">
              <tbody>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Document Type</th>
                  <th>Marks</th>
                  <th>Feedback</th>
                  <th>Modify</th>
                </tr>
                <tr v-for="document in documents.data" :key="document.id">
                  <td>{{document.id }}</td>
                  <td>{{document.title |capitalize}}</td>
                  <td>{{document.description }}</td>
                  <td>{{document.document_type}}</td>
                  <td v-if="document.marks!=1">{{document.marks }}</td>
                  <td class="text-danger font-italic font-weight-bold" v-else>Not awarded yet</td>
                  <td v-if="document.feedback!='sample'">{{document.feedback }}</td>
                  <td class="text-danger font-italic font-weight-bold" v-else>Not available</td>
                  <td>
                    <a href="#" @click="editModal(document)">
                      <i class="fa fa-edit"></i>
                    </a>
                    /
                    <a href="#" @click="deletedocument(document.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </div>
    <div v-if="!$gate.isStudent()">
      <NotFound></NotFound>
    </div>
    
    <!-- Modal -->
    <div
      class="modal fade rounded-0"
      id="addNew"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered rounded-0">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="editmode" class="modal-title" id="addNewLabel">Update Document</h5>
            <h5 v-show="!editmode" class="modal-title" id="addNewLabel">Add New Document</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form
            @submit.prevent="editmode ? update():create()"
            files="true"
            enctype="multipart/form-data"
          >
            <div class="modal-body">
              <!--input -->
              <div class="form-group">
                <input
                  v-model="form.title"
                  type="text"
                  placeholder="Project Title"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('title') }"
                />
                <has-error :form="form" field="title"></has-error>
              </div>

              <!--input -->
              <div class="form-group">
                <select
                  name="document_type"
                  id="document_type"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('document_type') }"
                  v-model="form.document_type"
                >
                  <option disabled value>Select Document type</option>
                  <option value="srs">SRS</option>
                  <option value="sdd">SDD</option>
                  <option value="final">Final Documentation</option>
                </select>
                <has-error :form="form" field="document_type"></has-error>
              </div>
              <!--input -->
              <!--input -->
              <div class="form-group">
                <input
                  v-model="form.description"
                  type="description"
                  placeholder="Description"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('description') }"
                />
                <has-error :form="form" field="description"></has-error>
              </div>

              <!--input -->
              <!-- Input Start-->
              <div class="form-group">
                <div class="col-sm-12">
                  <input
                    @change="uploadFile"
                    type="file"
                    class="form-control"
                    id="inputFile"
                    :class="{'is-invalid':form.errors.has('file')}"
                  />
                  <has-error :form="form" field="file"></has-error>
                </div>
              </div>
              <!-- Input End-->
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--Modal Ended-->
    </div>
      <div v-if="$gate.isNotVerified()">
      <div class="card">
        <div class="card-header">Email Verification</div>
        <div class="card-body">
          <p>Before proceeding, please check your email for a verification link.If you did not receive the email</p>
          <a href="#" @click="sendEmailLink">click here to request another</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
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
      sendEmailLink() {
      axios
        .get("api/sendEmailLink")
        .then(() => {
          
           swal.fire("Email Confirmation Link is sent to your Email.", "Verify your account and Refresh the page", "success");
        })
        .catch(() => {
          console.log("Some Problem");
        });
    },
    update() {
      this.$Progress.start();
      const udata = new FormData();
      udata.append("file", this.form.file);
      udata.append("document_type", this.form.document_type);
      udata.append("description", this.form.description);
      udata.append("title", this.form.title);
      udata.append("id", this.form.id);
      udata.append("isupdate", "1");
      axios
        .post("api/document", udata)
        .then(response => {
          // handle success
          this.$Progress.finish();
          $("#addNew").modal("hide");
          toast.fire({
            icon: "success",
            title: "New document Created Successfully"
          });
          Fire.$emit("reloaddocuments");

          console.log(response);
        })
        .catch(error => {
          // handle error
          //console.log(error.response.data.errors);
          this.$Progress.fail();
          toast.fire({
            icon: "warning",
            title: "Something went Wrong"
          });
        });
    },
    create() {
      this.$Progress.start();
      const data = new FormData();
      data.append("file", this.form.file);
      data.append("document_type", this.form.document_type);
      data.append("description", this.form.description);
      data.append("title", this.form.title);
      data.append("isupdate", "0");

      axios
        .post("api/document", data)
        .then(response => {
          // handle success
          this.$Progress.finish();
          $("#addNew").modal("hide");
          toast.fire({
            icon: "success",
            title: "New document Created Successfully"
          });
          Fire.$emit("reloaddocuments");

          console.log(response);
        })
        .catch(error => {
          // handle error
          //console.log(error.response.data.errors);
          this.$Progress.fail();
          toast.fire({
            icon: "warning",
            title: "Something went Wrong"
          });
        });
    },
    uploadFile(file) {
      if (file == "") return false;
      this.form.file = file.target.files[0];
      // console.log(this.form.file);
      //console.log(e);
      //this.form.file = e.target.files[0];
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    editModal(user) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(user);
    },
    deletedocument(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        })

        .then(result => {
          if (result.value) {
            this.$Progress.start();
            //send an AJAX requext to Server
            this.form
              .delete("api/document/" + id)
              .then(() => {
                swal.fire("Deleted!", "Your file has been deleted.", "success");
                Fire.$emit("reloaddocuments");
                this.$Progress.finish();
              })
              .catch(() => {
                swal.fire("Failed!", "There is something wrong.", "warning");
                this.$Progress.fail();
              });
          }
        });
    },

    loaddocuments() {
      this.$Progress.start();
      this.form.get("api/document").then(({ data }) => (this.documents = data));
      this.$Progress.finish();
    }
  },
  created() {
    if (!this.$gate.isNotVerified()) {
    this.loaddocuments();
    Fire.$on("reloaddocuments", () => this.loaddocuments());
    }
  },
  mounted() {}
};
</script>
