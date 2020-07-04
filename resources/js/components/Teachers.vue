<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title" style="float:left">Teachers</h3>

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
                  <th>Email</th>
                  <th>Type</th>
                  <th>Photo</th>
                  <th>Modify</th>
                </tr>
                <tr v-for="teacher in teachers.data" :key="teacher.id">
                  <template v-if="teacher.type!='student' && teacher.isapproved==1">
                    
                  
                  <td>{{teacher.id }}</td>
                  <td>{{teacher.name |capitalize}}</td>
                  <td>{{teacher.email}}</td>
                  <td v-if="teacher.type=='external'" >External Examiner</td>
                  <td v-else>{{teacher.type |capitalize}}</td>
                  <td>
                    <img :src="getProfilePhoto(teacher.photo)"  class="pic"   alt="User Image" />
                  </td>
                  <td>
                    <a href="#" @click="editModal(teacher)">
                      <i class="fa fa-edit"></i>
                    </a>
                    /
                    <a href="#" @click="deleteTeacher(teacher.id)">
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
          <form @submit.prevent="editmode ? updateTeachers():createTeacher()" >
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
                <select
                  name="type"
                  id="type"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('type') }"
                  v-model="form.type"
                ><option disabled value="" >Select Teacher type</option>
                  <option value="supervisor" >Supervisor</option>
                  <option value="external">External Examiner</option>
                  <option value="admin">Admin</option>
                </select>
                <has-error :form="form" field="type"></has-error>
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
      teachers: {},
      form: new Form({
        id:"",
        name: "",
        email: "",
        type: "",
        password: ""
      })
    };
  },
  methods: {
    getProfilePhoto(picuture){
      return "img/profile/" + picuture;
    },
      updateTeachers() {
      this.$Progress.start();
      this.form
        .put("api/user/" + this.form.id)
        .then(() => {
          Fire.$emit("reloadTeachers");
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
    deleteTeacher(id) {
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
                Fire.$emit("reloadTeachers");
                this.$Progress.finish();
              })
              .catch(() => {
                swal.fire("Failed!", "There is something wrong.", "warning");
                this.$Progress.fail();
              });
          }
        });
    },
    createTeacher() {
      this.$Progress.start();
      this.form
        .post("api/user")
        .then(() => {
          this.$Progress.finish();
          $("#addNew").modal("hide");
          Fire.$emit("reloadTeachers");
          toast.fire({
            icon: "success",
            title: "New Teacher Created Successfully"
          });
        })
        .catch(() => {
          this.$Progress.fail();
        });
      this.form.reset();
    },
    loadTeachers() {
      this.$Progress.start();
      this.form.get("api/user").then(({ data }) => (this.teachers = data));
      this.$Progress.finish();
    }
  },
  created() {
    this.loadTeachers();
    Fire.$on("reloadTeachers", () => this.loadTeachers());
  },
  mounted() {}
};
</script>
