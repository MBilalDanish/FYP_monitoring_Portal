

</style>
<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card card-widget widget-user mt-5">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div
            class="widget-user-header text-white"
            style="background-image:url('./img/profile/cover.jpg');  "
          >
            <h3 class="widget-user-username">Elizabeth Pierce</h3>
            <h5 class="widget-user-desc">Teacher</h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar" />
            <!-- <img class="img-circle" src="/ndks/sjs.i" alt="User Avatar" />-->
          </div>
          <div class="card-footer" style="background-color: #201436; color:white !important;">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">
                    Your account is approved
                    <i class="fas fa-check-circle"></i>
                  </h5>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">13,000</h5>
                  <span class="description-text">FOLLOWERS</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4">
                <div class="description-block">
                  <h5 class="description-header">35</h5>
                  <span class="description-text">PRODUCTS</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
        </div>
        <!--Profile Setting-->
        <div class="card nav-tabs-custom">
          <div class="card-header">
            <ul class="nav nav-tabs card-header">
              <li>
                <a
                  class="btn btn-primary"
                  href="#activity"
                  data-toggle="tab"
                  aria-expanded="false"
                >Activity</a>
              </li>
              <li class="active">
                <a
                  class="mx-2 btn btn-primary"
                  href="#settings"
                  data-toggle="tab"
                  aria-expanded="true"
                >Edit your Profile</a>
              </li>
            </ul>
          </div>
          <div class="tab-content">
            <div class="tab-pane" id="activity"></div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="timeline">
              <!-- The timeline -->
            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane active" id="settings">
              <form class="form-horizontal">
                <!-- Input Start-->
                <div class="form-group">
                  <label for="inputid" class="col-sm-2 control-label">id</label>

                  <div class="col-sm-12">
                    <input
                      v-model="form.id"
                      type="text"
                      class="form-control"
                      id="inputid"
                      placeholder="ID"
                      :class="{'is-invalid':form.errors.has('id')}"
                    />
                    <has-error :form="form" field="id"></has-error>
                  </div>
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Name</label>

                  <div class="col-sm-12">
                    <input
                      v-model="form.name"
                      type="text"
                      class="form-control"
                      id="inputName"
                      placeholder="Name"
                      :class="{'is-invalid':form.errors.has('name')}"
                    />
                    <has-error :form="form" field="name"></has-error>
                  </div>
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group">
                  <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                  <div class="col-sm-12">
                    <input
                      v-model="form.email"
                      type="email"
                      class="form-control"
                      id="inputEmail"
                      placeholder="Email"
                      :class="{'is-invalid':form.errors.has('email')}"
                    />
                    <has-error :form="form" field="email"></has-error>
                  </div>
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group">
                  <label for="inputdesignation" class="col-sm-2 control-label">Designation</label>

                  <div class="col-sm-12">
                    <input
                      v-model="form.designation"
                      class="form-control"
                      id="inputdesignation"
                      placeholder="Designation"
                    />
                  </div>
                </div>
                <!-- Input End-->
             
                <!-- Input Start-->
                <div class="form-group">
                  <label for="inputsupervisor" class="col-sm-2 control-label">Contact No</label>

                  <div class="col-sm-12">
                    <input
                      v-model="form.contact"
                      type="text"
                      class="form-control"
                      id="inputphone"
                      placeholder="Contact No"
                      :class="{'is-invalid':form.errors.has('phone')}"
                    />
                    <has-error :form="form" field="phone"></has-error>
                  </div>
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group">
                  <label for="inputProfilePhoto" class="col-sm-2 control-label">Profile Photo</label>

                  <div class="col-sm-12">
                    <input
                      @change="updatePhoto"
                      type="file"
                      class="form-control"
                      id="inputProfilePhoto"
                    />
                  </div>
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group">
                  <label
                    for="inputPassword"
                    class="col-sm-12 control-label"
                  >Password (Leave Empty if not changing)</label>

                  <div class="col-sm-12">
                    <input
                      v-model="form.password"
                      type="password"
                      class="form-control"
                      id="inputPassword"
                      placeholder="Password"
                      :class="{'is-invalid':form.errors.has('password')}"
                    />
                    <has-error :form="form" field="password"></has-error>
                  </div>
                </div>
                <!-- Input End-->
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-12">
                    <button @click.prevent="updateInfo" type="submit" class="btn btn-success">Update</button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: new Form({
        id: "",
        isapproved: "",
        name: "",
        email: "",
        password: "",
        designation: "",
        contact: "",
        photo: ""
      })
    };
  },
  methods: {
    semesterShow() {
      if (this.form.program != mcs) return true;
      return false;
    },
    getProfilePhoto() {
        if(this.form.photo!=null){
 let pPhoto =
        this.form.photo.length > 100
          ? this.form.photo
          : "img/profile/" + this.form.photo;
      return pPhoto;
        }
     
    },
    updateInfo() {
      this.$Progress.start();
      this.form
        .put("api/teacherprofile/")
        .then(() => {
          this.$Progress.finish();
          toast.fire({
            icon: "success",
            title: "Profile Updated Sucessfully"
          });
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    updatePhoto(e) {
      //console.log("uploading");
      let file = e.target.files[0];
      // console.log(file);
      var reader = new FileReader();
      if (file["size"] < 2097152) {
        reader.onloadend = file => {
          this.form.photo = reader.result;
        };

        reader.readAsDataURL(file);
      } else {
        swal.fire({
          icon: "error",
          title: "Ooopps",
          text: "You are uploading a file larger than 2mb"
        });
      }
    }
  },
  mounted() {
    console.log("Component mounted.");
  },
  created() {
    axios.get("api/teacherprofile").then(({ data }) => this.form.fill(data[0]));
  }
};
</script>
