<template>
  <div class="container">
    <div v-if="!$gate.isNotVerified()">
    <div class="row justify-content-center"  v-if="$gate.isStudent()">
      <div class="col-md-8">
        <div class="card card-widget widget-user mt-5 rounded-0">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div
            class="widget-user-header text-white"
            style="background-image:url('./img/profile/cover.jpg'); "
          >
            <h3 class="widget-user-username">{{form.name}}</h3>
            <h5 class="widget-user-desc">{{form.semester}}/{{form.program}}</h5>
          </div>
          <div class="widget-user-image" style="margin-top:-50px !important;">
            <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar" />
          </div>
        </div>
        <!--Profile Setting-->
        <div class="card rounded-0 nav-tabs-custom">
          <div class="card-header rounded-0">
            <ul class="nav nav-tabs card-header rounded-0">
              <li class="active">
                <a
                  class="btn btn-danger"
                  href="#activity"
                  data-toggle="tab"
                  aria-expanded="true"
                >Close</a>
              </li>
              <li>
                <a
                  class="mx-2 btn btn-primary"
                  href="#settings"
                  data-toggle="tab"
                  aria-expanded="false"
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
                  <label for="inputid" class="col-md-2 control-label">id</label>

               
                    <input
                      v-model="form.id"
                      type="text"
                      class="form-control f-input col-md-8"
                      id="inputid"
                      placeholder="ID"
                      :class="{'is-invalid':form.errors.has('id')}"
                    />
                    <has-error :form="form" field="id"></has-error>
              
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group row px-3">
                  <label for="inputName" class="col-md-2 control-label">Name</label>

                
                    <input
                      v-model="form.name"
                      type="text"
                      class="form-control f-input col-md-8"
                      id="inputName"
                      placeholder="Name"
                      :class="{'is-invalid':form.errors.has('name')}"
                    />
                    <has-error :form="form" field="name"></has-error>
           
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group row px-3">
                  <label for="inputfathername" class="col-md-2 control-label">Father Name</label>

                    <input
                      v-model="form.fathername"
                      type="text"
                      class="form-control f-input col-md-8"
                      id="inputfathername"
                      placeholder="Father Name"
                      :class="{'is-invalid':form.errors.has('fathername')}"
                    />
                    <has-error :form="form" field="fathername"></has-error>
              
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group row px-3">
                  <label for="inputEmail" class="col-md-2 control-label">Email</label>

             
                    <input readonly
                      v-model="form.email"
                      type="email"
                      class="form-control f-input col-md-8"
                      id="inputEmail"
                      placeholder="Email"
                      :class="{'is-invalid':form.errors.has('email')}"
                    />
                    <has-error :form="form" field="email"></has-error>
        
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group row px-3">
                  <label for="inputrollNo" class="col-md-2 control-label">Roll No</label>

             
                    <input
                      v-model="form.rollno"
                      class="form-control f-input col-md-8"
                      id="inputrollNo"
                      placeholder="Roll No"
                    />
           
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group row px-3" >
                  <label for="inputProgram" class="col-sm-2 control-label">Program</label>
                 
                    <select
                      name="program"
                      id="inputProgram"
                      class="form-control f-input col-md-8"
                      :class="{ 'is-invalid': form.errors.has('program') }"
                      v-model="form.program"
                    >
                      <option value="mcs">MCS</option>
                      <option value="bscs">BS Computer Science</option>
                      <option value="bsit">BS Information Technology</option>
                      <option value="bsse">BS Software Engineering</option>
                      <option value="bsai">BS Aritficial Intelligence</option>
                      <option value="bsds">BS Data Structure</option>
                    </select>
                    <has-error :form="form" field="program"></has-error>
            
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group row px-3 ">
                  <label for="inputProgram" class="col-sm-2 control-label">Semester</label>
             
                    <select
                      name="semester"
                      id="inputSemester"
                      class="form-control f-input col-md-8"
                      :class="{ 'is-invalid': form.errors.has('semester') }"
                      v-model="form.semester"
                    >
                      <option value="1">1st</option>
                      <option value="2">2nd</option>
                      <option value="3">3rd</option>
                      <option value="4">4th</option>
                      <template v-show="semesterShow">
                        <option value="5">5th</option>
                        <option value="6">6th</option>
                        <option value="7">7th</option>
                        <option value="8">8th</option>
                      </template>
                    </select>
                    <has-error :form="form" field="semester"></has-error>
            
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group row px-3"  @click="showNotEdit">
                  <label for="inputsupervisor" class="col-sm-2 control-label">Project Supervisor</label>

          
                    <input
                      :disabled="true"
                      v-model="form.supervisor"
                      type="text"
                      class="form-control f-input col-md-8"
                      id="inputsupervisor"
                      placeholder="Project Supervisor"
                      v-if="form.supervisor!='' && form.supervisor!='supervisor'"
                     
                      
                    />
                    <input
                      :disabled="true"
                      type="text"
                      class="form-control f-input col-md-8"
                      id="inputsupervisor"
                      placeholder="Not assigned yet/Only Admin can Assign Supervisor"
                      v-else
                     
                    />
           
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group row px-3">
                  <label for="inputcgpa" class="col-md-2 control-label">CGPA</label>

            
                    <input
                      v-model="form.cgpa"
                      type="text"
                      class="form-control f-input col-md-8"
                      id="inputcgpa"
                      placeholder="CGPA"
                      :class="{'is-invalid':form.errors.has('cgpa')}"
                    />
                    <has-error :form="form" field="cgpa"></has-error>
            
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group row px-3">
                  <label for="inputProfilePhoto" class="col-md-2 control-label">Profile Photo</label>

        
                    <input
                      @change="updatePhoto"
                      type="file"
                      class="form-control f-input col-md-8"
                      id="inputProfilePhoto"
                      :class="{'is-invalid':form.errors.has('photo')}"
                    />
                    <has-error :form="form" field="photo"></has-error>
               
                </div>
                <!-- Input End-->
                <!-- Input Start-->
                <div class="form-group row px-3">
                  <label
                    for="inputPassword"
                    class="col-sm-2 control-label"
                  >Password </label>

                 
                    <input
                      v-model="form.password"
                      type="password"
                      class="form-control f-input col-md-8"
                      id="inputPassword"
                      placeholder="Leave Empty if not changing"
                      :class="{'is-invalid':form.errors.has('password')}"
                    />
                    <has-error :form="form" field="password"></has-error>
                 
                </div>
                <!-- Input End-->
                <div class="form-group row px-3">
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
    <div v-if="!$gate.isStudent()">
      <NotFound></NotFound>
    </div>
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
      form: new Form({
        id: "",
        isapproved: "",
        name: "",
        email: "",
        password: "",
        rollno: "",
        program: "",
        semester: "",
        fathername: "",
        supervisor: "",
        cgpa: "",
        type: "student",
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
    showNotEdit() {
      swal.fire({
        position: "top-end",
        icon: "error",
        title: "You can't edit this feild,Only Admin can assign supervisors.",
        showConfirmButton: false,
        timer: 1500
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
        .put("api/studentprofile/")
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
    axios.get("api/studentprofile").then(({ data }) => this.form.fill(data[0]));
    }
  }
};
</script>
