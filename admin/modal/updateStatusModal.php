<!-- Update Status -->
<div class="modal fade" id="updateStatus">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Update Case Status</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="../controller/depressedController.php">
                <input type="hidden" name="id" id="case_id">
                <div class="form-group">
                    <label for="status" class="col-sm-3 control-label">Status</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="status" id="status" required>
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="update_status"><i class="fa fa-check"></i> Update</button>
              </form>
            </div>
        </div>
    </div>
</div>
