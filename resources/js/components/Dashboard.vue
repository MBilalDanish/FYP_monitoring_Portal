<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Dashboard Component
            <button @click="showModal" class="btn btn-success">Show Modal</button>
          </div>

          <div class="card-body">
            <!-- Modal -->
            <div
              class="modal fade"
              id="plagirism"
              tabindex="-1"
              role="dialog"
              aria-labelledby="plagirismLabel"
              aria-hidden="true"
            >
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="plagirismLabel">Comparison Results</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <!-- Table -->
                  <div class="box">
                    <div class="box-header">
                      <h3 class="box-title">Condensed Full Width Table</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                      <table class="table table-condensed">
                        <tbody>
                          <tr>
                            <th style="width: 10px">#</th>
                            <th>Task</th>
                            <th>Progress</th>
                            <th style="width: 40px">Label</th>
                          </tr>
                          <tr>
                            <td>1.</td>
                            <td>Update software</td>
                            <td>
                              <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                              </div>
                            </td>
                            <td>
                              <span class="badge bg-red">55%</span>
                            </td>
                          </tr>
                          <tr>
                            <td>2.</td>
                            <td>Clean database</td>
                            <td>
                              <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-yellow" style="width: 70%"></div>
                              </div>
                            </td>
                            <td>
                              <span class="badge bg-yellow">70%</span>
                            </td>
                          </tr>
                          <tr>
                            <td>3.</td>
                            <td>Cron job running</td>
                            <td>
                              <div class="progress progress-xs progress-striped active">
                                <div class="progress-bar progress-bar-primary" style="width: 30%"></div>
                              </div>
                            </td>
                            <td>
                              <span class="badge bg-light-blue">30%</span>
                            </td>
                          </tr>
                          <tr>
                            <td>4.</td>
                            <td>Fix and squish bugs</td>
                            <td>
                              <div class="progress progress-xs progress-striped active">
                                <div class="progress-bar progress-bar-success" style="width: 90%"></div>
                              </div>
                            </td>
                            <td>
                              <span class="badge bg-green">90%</span>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!--End Table-->
                </div>
              </div>
            </div>
            <!--Modal Ended-->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    showModal() {
      $("#plagirism").modal("show");
    }
  },
  mounted() {},
  created() {}
};
</script>
