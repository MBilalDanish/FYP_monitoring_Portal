<template>
  <div class="container">
    <div v-if="$gate.isNotVerified()">
      <div class="card rounded-0">
        <div class="card-header">Email Verification</div>
        <div class="card-body">
          <p>Before proceeding, please check your email for a verification link.If you did not receive the email</p>
          <a href="#" @click="sendEmailLink">click here to request another</a>
        </div>
      </div>
    </div>
    <div v-if="!$gate.isNotVerified()" class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Statistics</div>

          <div class="card-body">
            <!--Row Start-->
            <div class="row">
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                  <div class="inner">
                    <h3>{{stats.no_docs}}</h3>
                    <p>Documents</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-file-pdf"></i>
                  </div>
                  <p class="small-box-footer"></p>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{stats.no_students}}</h3>
                    <p>Students</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-user-graduate"></i>
                  </div>
                  <p class="small-box-footer"></p>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-darkyellow">
                  <div class="inner">
                    <h3>{{stats.no_admins}}</h3>
                    <p>Admins</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-users-cog"></i>
                  </div>
                  <p class="small-box-footer"></p>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>{{stats.no_externals}}</h3>
                    <p>External Examiner</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                  </div>
                  <p class="small-box-footer"></p>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-purple">
                  <div class="inner">
                    <h3>{{stats.no_supervisors}}</h3>
                    <p>Supervisors</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-eye"></i>
                  </div>
                  <p class="small-box-footer"></p>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>{{stats.no_requests}}</h3>
                    <p>Pending Request</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-user-clock"></i>
                  </div>
                  <p class="small-box-footer"></p>
                </div>
              </div>
              <!-- ./col -->
            </div>
            <!--Row Ended-->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      stats: {}
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
    }
  },
  mounted() {
    if (!this.$gate.isNotVerified()) {
      this.$Progress.start();
      axios.get("api/getStats").then(({ data }) => (this.stats = data.data));
      this.$Progress.finish();
    }
  }
};
</script>
