<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
              <div class="row justify-content-center">
            <div class="col-5">Chat Room</div>
            <div class="col-5">
              <select class="form-control" v-model="chatUser_id" >
                <option disabled value>Select User to chat</option>
                <option
                  v-for="option in chatUsers.data"
                  :key="option.id"
                  v-bind:value="option.id"
                >{{ option.name }}--{{option.type}}</option>
              </select>
            </div>
            </div>
          </div>

          <div class="card-body">I'm a Chat Room component.</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      chatUsers: {},
      chatUser_id: ""
    };
  },
  mounted() {
    console.log("Component mounted.");
  },
  created() {
    axios.get("api/message").then(({ data }) => (this.chatUsers = data));
    //axios.post("api/message");
  }
};
</script>
