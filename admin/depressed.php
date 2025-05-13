<?php 
  session_start();
  include '../config/config.php';
  class data extends Connection{ 
    public function managedata(){ 
?>
<!DOCTYPE html>
<html>
<head><?php include 'head.php'; ?></head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <?php include 'profile.php'; ?>
    <?php include 'sidebar.php'; ?>
    <div class="content-wrapper" style="height: 100vh;background-color: #f9f9f9;overflow-y: auto;">
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered">
                  <thead>
                    <th>List</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Score</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Date Created</th>
                    <th>Action</th>
                  </thead>
                  <tbody>
                    <?php 
                    // Order by priority first (High priority first), then by date
                    $sql = "SELECT * FROM depressed ORDER BY CASE WHEN priority = 'High' THEN 1 ELSE 2 END, date_created DESC";
                    $stmt = $this->conn()->query($sql);
                    $id = 1;
                    while ($row = $stmt->fetch()) { ?>
                      <tr>
                        <td><?php echo $id; ?></td>
                        <td><?php echo $row['fullname'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><?php echo $row['phone_number'] ?></td>
                        <td><?php echo $row['age'] ?></td>
                        <td><?php echo $row['gender'] ?></td>
                        <td><?php echo $row['score'] ?></td>
                        <td>
                          <span class="label <?php echo $row['priority'] == 'High' ? 'label-danger' : 'label-warning' ?>">
                            <?php echo $row['priority'] ?>
                          </span>
                        </td>
                        <td>
                          <span class="label <?php 
                            if($row['status'] == 'Pending') echo 'label-warning';
                            else if($row['status'] == 'In Progress') echo 'label-info';
                            else if($row['status'] == 'Completed') echo 'label-success';
                          ?>">
                            <?php echo $row['status'] ?>
                          </span>
                        </td>
                        <td><?php echo date('F j, Y', strtotime($row['date_created'])) ?></td>
                        <td>
                          <button class="btn btn-info btn-sm update-status" data-id="<?php echo $row['id'] ?>" data-status="<?php echo $row['status'] ?>">
                            Update Status
                          </button>
                        </td>
                      </tr>
                    <?php $id++; } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  <?php include 'footer.php'; ?>
  <?php include 'modal/updateStatusModal.php'; ?>
  <script>
  $(function(){
    // Update Status
    $(document).on('click', '.update-status', function(e){
      e.preventDefault();
      $('#updateStatus').modal('show');
      var id = $(this).data('id');
      var status = $(this).data('status');
      $('#case_id').val(id);
      $('#status').val(status);
    });
  });
  </script>
</body>
</html>
<?php } } $data = new data(); $data->managedata(); ?>