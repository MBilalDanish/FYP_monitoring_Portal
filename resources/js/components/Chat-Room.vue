<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <div class="row justify-content-center">
              <div class="col-5">Chat Room</div>
              <div class="col-5">
                <select class="form-control" v-model="chatUser_id" @change="getMessages()">
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

          <div class="card-body">
            <div v-show="showChat">
              <div v-for="msg in messages.data" :key="msg.id">
                <div class="row" v-if="msg.from==chatUser_id">
                  <div class="col-6">
                    <p class="rounded bg-primary p-2">{{msg.user_message}}</p>
                  </div>
                  <div class="col-6"></div>
                </div>
                <div class="row" v-else>
                  <div class="col-6"></div>
                  <div class="col-6">
                    <p class="rounded bg-success p-2">{{msg.user_message}}</p>
                  </div>
                </div>
              </div>
              <div class="border border-success p-1">
                <form @submit.prevent="sendMessage">
                  <div class="input-group">
                    <input
                      type="text"
                      class="form-control"
                      v-model="message"
                      placeholder="Type Message here"
                    />
                    <input type="submit" class="btn btn-success" name="submit" value="Send" />
                  </div>
                </form>
              </div>
            </div>
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
      showChat: false,
      chatUsers: {},
      messages: {},
      chatUser_id: "",
      message: "",
    };
  },
  methods: {
    getMessages() {
      axios
        .get("api/getMessages/" + this.chatUser_id)
        .then(({ data }) => (this.messages = data));
      this.showChat = true;
    },
    sendMessage() {
      if (this.message != "") {
        const mdata = new FormData();
        mdata.append("chatUser_id", this.chatUser_id);
        mdata.append("message", this.message);
        axios.post("api/message", mdata).then((response) => {
          Fire.$emit("reloadmessages");
          this.message = "";
        });
      }
    },
  },
  mounted() {
    console.log("Component mounted.");
  },
  created() {
    axios.get("api/message").then(({ data }) => (this.chatUsers = data));
    Fire.$on("reloadmessages", () => this.getMessages());

    setInterval(()=>this.getMessages(), 2000);
  },
};
</script>
