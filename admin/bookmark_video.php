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
                <?php if($_SESSION['type'] == 0): ?>
                    <div class="box-body">
                        <div class="row">
                            <?php 
                            $sql = "SELECT * FROM bookmark_video INNER JOIN video ON bookmark_video.video_id=video.id WHERE bookmark_video.users_id = '".$_SESSION['id']."'";
                            $stmt = $this->conn()->query($sql);
                            if($stmt->rowcount() > 0):
                                while ($row = $stmt->fetch()) { 
                                    $file = $row['file'];
                                    $file_ext = pathinfo($file, PATHINFO_EXTENSION);
                                    $file_path = "../audiovideo/" . $file;
                                ?>
                                    <div class="col-lg-2" style="text-align: center;">
                                        <div class="card" style="border: 2px solid rgba(0, 0, 0, 0.1);padding: 20px;">
                                            <div>
                                                <?php if (in_array($file_ext, ['mp4', 'webm', 'ogg'])) { ?>
                                                    <!-- Video Player -->
                                                    <video width="200" controls>
                                                        <source src="<?php echo $file_path; ?>" type="video/<?php echo $file_ext; ?>">
                                                        Your browser does not support the video element.
                                                    </video>
                                                <?php } else { ?>
                                                    <?php echo $file; ?>
                                                <?php } ?>
                                            </div>
                                            <div style="display: flex;place-items: center;justify-content: space-between;">
                                                <h4 style="text-align: center;"><?php echo $row['title']; ?></h4>
                                                <h4>
                                                    <i class="fas fa-bookmark bookmark" data-id="<?php echo $row['video_id'] ?>"></i>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php else: ?>
                                <h2 style="color: green;font-weight: bold;text-align: center;">No Bookmark</h2>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  <?php include 'footer.php'; ?>
  <script>
    $(document).ready(function() {
        $(".bookmark").click(function() {
            $(this).toggleClass("far fas");

            let videoId = $(this).data("id");
            $.ajax({
                url: '../controller/videoController.php',
                type: 'POST',
                data: { setbookmark: 'setbookmark', id: videoId },
                success: function(response) {
                    setTimeout(function() {
                        location.reload(); // Reload after 2 seconds
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        });
    });

  </script>
</body>
</html>
<?php } } $data = new data(); $data->managedata(); ?>