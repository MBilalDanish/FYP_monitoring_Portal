<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title" style="float:left">Pending Requests</h3>
            <!--
            <button class="btn btn-success" style="float:right" @click="newModal">
              Approve All
              <i class="fa fa-user-plus fa-fw"></i>
            </button>-->
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
                  <th>Approve/Deny</th>
                </tr>

                
                  <tr v-for="user in users.data" :key="user.id">
                    <template v-if="user.isapproved==0">
                      <td>{{user.id }}</td>
                      <td>{{user.name |capitalize}}</td>
                      <td>{{user.email}}</td>
                      <td>{{user.type |capitalize}}</td>

                      <td>
                        <a href="#" @click="updateUser(user.id)">
                          <i class="fas fa-check"></i>
                        </a>
                        /
                        <a href="#" @click="deleteUser(user.id)">
                          <i class="fas fa-times red"></i>
                        </a>
                      </td>
                    </template>
                  </tr>
              
              
                     <tr  v-if="showOrNot">
                    <td colspan="5" align="center"> ---------</td>
                  </tr>
                  <tr  v-if="showOrNot">
                    <td colspan="5" align="center" class="text-danger"> No more Pending Requests available</td>
                  </tr>
                 
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
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
      users: {},
      form: new Form({
        id: "",
        isapproved: 1
      })
    };
  },
  methods: {
    showOrNot() {
      let counter = 0;
      for (var user in this.users.data) {
        if (user.isapproved == false) {
          counter++;
        }
      }
      if (counter == 0) {
        return true;
      } else {
        return false;
      }
    },
    updateUser(id) {
      this.$Progress.start();
      this.form
        .put("api/user/" + id)
        .then(() => {
          Fire.$emit("reloadUsers");
          this.$Progress.finish();
          toast.fire({
            icon: "success",
            title: "User Approved Sucessfully"
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
    deleteUser(id) {
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
                Fire.$emit("reloadUsers");
                this.$Progress.finish();
              })
              .catch(() => {
                swal.fire("Failed!", "There is something wrong.", "warning");
                this.$Progress.fail();
              });
          }
        });
    },
    loadUsers() {
      this.$Progress.start();
      this.form.get("api/user").then(({ data }) => (this.users = data));
      this.$Progress.finish();
    }
  },
  created() {
    this.loadUsers();
    Fire.$on("reloadUsers", () => this.loadUsers());
  },
  mounted() {}
};
</script>
