<template>
  <div class="container">
    <div class="row justify-content-center"  v-if="$gate.isAdmin()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title" style="float:left">Students</h3>

            <button class="btn btn-success" style="float:right" @click="newModal">
              Add New
              <i class="fa fa-user-plus fa-fw"></i>
            </button>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive no-padding">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Roll No</th>
                  <th>Email</th>
                  <th>Semester/Program</th>
                  <th>Supervisor</th>

                  <th>Photo</th>
                  <th>Modify</th>
                </tr>
                <tr v-for="student in students.data" :key="student.id">
                  <template v-if="student.type=='student' && student.isapproved==1">
                    <td>{{student.id }}</td>
                    <td>{{student.name |capitalize}}</td>
                    <td>{{student.rollno |capitalize}}</td>
                    <td>{{student.email}}</td>
                    <td>{{student.semester}}-{{student.program |capitalize}}</td>
                    <td>{{student.supervisor}}</td>
                    <td>
                      <img :src="getProfilePhoto(student.pic)" class="pic" alt="User Image" />
                    </td>
                    <td>
                      <a href="#" @click="editModal(student)">
                        <i class="fa fa-edit"></i>
                      </a>
                      /
                      <a href="#" @click="deleteStudent(student.id)">
                        <i class="fa fa-trash red"></i>
                      </a>
                    </td>
                  </template>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </div>
<div v-if="!$gate.isAdmin()">
  <NotFound></NotFound>
</div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="addNew"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="editmode" class="modal-title" id="addNewLabel">Update User</h5>
            <h5 v-show="!editmode" class="modal-title" id="addNewLabel">Add New User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateStudents():createStudent()">
            <div class="modal-body">
              <!--input -->
              <div class="form-group">
                <input
                  v-model="form.name"
                  type="text"
                  placeholder="Name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                />
                <has-error :form="form" field="name"></has-error>
              </div>
              <!--input -->
              <div class="form-group">
                <select class="form-control" v-model="selected" @change="supervisorChanged">
                  <option disabled value="">Assign Supervisor</option>
                  <option
                    v-for="option in supervisors.data"
                    :key="option.id"
                    v-bind:value="option.id"
                  >{{ option.name }}</option>
                </select>
              </div>
              <!--input -->
              <div class="form-group">
                <input
                  v-model="form.email"
                  type="email"
                  placeholder="Email"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                />
                <has-error :form="form" field="email"></has-error>
              </div>

              <!--input -->
              <div class="form-group">
                <input
                  v-model="form.password"
                  type="password"
                  placeholder="Password"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                />
                <has-error :form="form" field="password"></has-error>
              </div>
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
</template>

<script>
export default {
  data() {
    return {
      editmode: false,
      students: {},
      supervisors: {},
      selected:"",
      form: new Form({
        id: "",
        name: "",
        email: "",
        type: "student",
        password: "",
        supervisor_id: ""
      })
    };
  },
  methods: {
    getProfilePhoto(picuture) {
      return "img/profile/" + picuture;
    },
    supervisorChanged(){
      this.form.supervisor_id=this.selected;
    },
    updateStudents() {
      this.$Progress.start();
      this.form
        .put("api/user/" + this.form.id)
        .then(() => {
          Fire.$emit("reloadStudents");
          this.$Progress.finish();
          $("#addNew").modal("hide");
          toast.fire({
            icon: "success",
            title: "User updated Sucessfully"
          });
        })
        .catch(() => {
          this.$Progress.fail();
          toast.fire({
            icon: "warning",
            title: "Something went Wrong"
          });
        });
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
    deleteStudent(id) {
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
              .delete("api/user/" + id)
              .then(() => {
                swal.fire("Deleted!", "Your file has been deleted.", "success");
                Fire.$emit("reloadStudents");
                this.$Progress.finish();
              })
              .catch(() => {
                swal.fire("Failed!", "There is something wrong.", "warning");
                this.$Progress.fail();
              });
          }
        });
    },
    createStudent() {
      this.$Progress.start();
      this.form
        .post("api/user")
        .then(() => {
          this.$Progress.finish();
          $("#addNew").modal("hide");
          Fire.$emit("reloadStudents");
          toast.fire({
            icon: "success",
            title: "New Student Created Successfully"
          });
        })
        .catch(() => {
          this.$Progress.fail();
        });
      this.form.reset();
    },
    loadStudents() {
      this.$Progress.start();
      this.form.get("api/student").then(({ data }) => (this.students = data));
      this.$Progress.finish();
      axios.get("api/supervisor").then(({ data }) => (this.supervisors = data));
    }
  },
  created() {
    this.loadStudents();
    Fire.$on("reloadStudents", () => this.loadStudents());
  },
  mounted() {}
};
</script>
