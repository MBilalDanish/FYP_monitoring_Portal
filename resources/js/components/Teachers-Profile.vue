
<template>
  <div class="container">
    <div v-if="!$gate.isNotVerified()">
    <div class="row justify-content-center"  v-if="$gate.isTeacher()">
      <div class="col-md-8">
        <div class="card card-widget widget-user mt-5 rounded-0">
          <div
            class="widget-user-header text-white"
            style="background-image:url('./img/profile/cover.jpg');  "
          >
            <h3 class="widget-user-username">{{form.name}}</h3>
            <h5 class="widget-user-desc">{{form.designation}}</h5>
          </div>
          <div class="widget-user-image" style="margin-top:-50px !important;">
            <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar" />
          </div>
        </div>
        <!--Profile Setting-->
        <div class="card nav-tabs-custom">
          <div class="card-header">
            <ul class="nav nav-tabs card-header">
              <li class="active">
                <a
                  class="btn rounded-0 btn-danger"
                  href="#activity"
                  data-toggle="tab"
                  aria-expanded="false"
                >Close</a>
              </li>
              <li>
                <a
                  class="mx-2 btn rounded-0 btn-primary"
                  href="#settings"
                  data-toggle="tab"
                  aria-expanded="true"
                >Edit your Profile</a>
              </li>
            </ul>
          </div>
          <div class="tab-content">
            <div class="tab-pane active" id="activity"></div>

            <!-- /.tab-pane -->

            <div class="tab-pane" id="settings">
              <form class="form-horizontal">
                <!-- Input Start-->
                <div class="form-group row px-3">
                  <label for="inputid" class="col-md-1  control-label"><i class="fas fa-id-badge fa-2x"></i></label>

                 
                    <input
                    readonly
                      v-model="form.id"
                      type="text"
                      class="form-control f-input col-md-10"
                      id="inputid"
                      placeholder="ID"
                      :class="{'is-invalid':form.errors.has('id')}"
                    />
                    <has-error :form="form" field="id"></has-error>
              
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group row px-3">
                  <label for="inputName" class="col-md-1  control-label"><i class="fas fa-user fa-2x"></i></label>

                  
                    <input
                      v-model="form.name"
                      type="text"
                      class="form-control f-input col-md-10"
                      id="inputName"
                      placeholder="Name"
                      :class="{'is-invalid':form.errors.has('name')}"
                    />
                    <has-error :form="form" field="name"></has-error>
             
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group row px-3">
                  <label for="inputEmail" class="col-md-1  control-label"><i class="fas fa-envelope fa-2x"></i></label>

                 
                    <input readonly
                      v-model="form.email"
                      type="email"
                      class="form-control f-input col-md-10"
                      id="inputEmail"
                      placeholder="Email"
                      :class="{'is-invalid':form.errors.has('email')}"
                    />
                    <has-error :form="form" field="email"></has-error>
                
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group row px-3">
                  <label for="inputdesignation" class="col-md-1  control-label"><i class="fas fa-chalkboard-teacher fa-2x"></i></label>

               
                    <input
                      v-model="form.designation"
                      class="form-control f-input col-md-10"
                      id="inputdesignation"
                      placeholder="Designation"
                    />
                
                </div>
                <!-- Input End-->

                <!-- Input Start-->
                <div class="form-group row px-3">
                  <label for="inputsupervisor" class="col-md-1  control-label"><i class="fas fa-phone fa-2x"></i></label>

                  
                    <input
                      v-model="form.contact"
                      type="text"
                      class="form-control f-input col-md-10"
                      id="inputphone"
                      placeholder="Contact No"
                      :class="{'is-invalid':form.errors.has('phone')}"
                    />
                    <has-error :form="form" field="phone"></has-error>
                 
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group row px-3">
                  <label for="inputProfilePhoto" class="col-md-1  control-label"><i class="fas fa-image fa-2x"></i></label>

                  
                    <input
                      @change="updatePhoto"
                      type="file"
                      class="form-control f-input col-md-10"
                      id="inputProfilePhoto"
                    />
                 
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group row px-3">
                  <label
                    for="inputPassword"
                    class="col-md-1 control-label"
                  ><i class="fas fa-lock fa-2x"></i></label>

                
                    <input
                      v-model="form.password"
                      type="password"
                      class="form-control f-input col-md-10"
                      id="inputPassword"
                      placeholder="Password"
                      :class="{'is-invalid':form.errors.has('password')}"
                    />
                    <has-error :form="form" field="password"></has-error>
                 
                </div>
                <!-- Input End-->
                <div class="form-group row px-3">
                  <div class=" col-md-9">
                    </div>
                    <button @click.prevent="updateInfo" type="submit" class="col-md-2 btn rounded-0 btn-success">Update</button>
                  
                </div>
              </form>
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
      </div>
    </div>
    <div  v-if="!$gate.isTeacher()">
      <NotFound></NotFound>
    </div>
  </div>
      <div v-if="$gate.isNotVerified()">
      <div class="card rounded-0">
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
    semesterShow() {
      if (this.form.program != mcs) return true;
      return false;
    },
    getProfilePhoto() {
      if (this.form.photo != null) {
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
    
  },
  created() {
    if (!this.$gate.isNotVerified()) {
    axios.get("api/teacherprofile").then(({ data }) => this.form.fill(data[0]));
    }
  }
};
</script>
