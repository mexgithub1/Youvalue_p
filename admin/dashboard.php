<?php 
error_reporting(0);
  session_start();
  include '../config/config.php';
  class data extends Connection{ 
    public function managedata(){ 

      if($_SESSION['type'] == 2):

        $sql = "SELECT COUNT(id) AS totalstudents FROM users WHERE type = 0";
        $stmt = $this->conn()->query($sql);
        $row = $stmt->fetch();
        $totalstudents = $row['totalstudents'];

        $sql = "SELECT COUNT(id) AS totalfaculty FROM users WHERE type = 1";
        $stmt = $this->conn()->query($sql);
        $row = $stmt->fetch();
        $totalfaculty = $row['totalfaculty'];

      endif;

      if($_SESSION['type'] == 0):
        // Get user's latest score and determine category
        $sqlScore = "SELECT score FROM scores WHERE users_id = ? ORDER BY date DESC LIMIT 1";
        $stmtScore = $this->conn()->prepare($sqlScore);
        $stmtScore->execute([$_SESSION['id']]);
        
        $category = 'Normal'; // Default category
        if($stmtScore->rowCount() > 0) {
            $score = $stmtScore->fetch()['score'];
            if($score >= 70) {
                $category = 'Depressed';
            } else if($score >= 50) {
                $category = 'Anxiety';
            }
        }

        // Get random media filtered by user's category
        $sqlreadables = "SELECT * FROM readables WHERE category = ? ORDER BY RAND() LIMIT 1";
        $stmtreadables = $this->conn()->prepare($sqlreadables);
        $stmtreadables->execute([$category]);
        $rowreadables = $stmtreadables->fetch();
        $readables_title = $rowreadables['title'];
        $readables_file = $rowreadables['file'];

        $sqlaudio = "SELECT * FROM audio WHERE category = ? ORDER BY RAND() LIMIT 1";
        $stmtaudio = $this->conn()->prepare($sqlaudio);
        $stmtaudio->execute([$category]);
        $rowaudio = $stmtaudio->fetch();
        $audio_title = $rowaudio['title'];
        $audio_file = $rowaudio['file'];
        $audio_file_ext = pathinfo($audio_file, PATHINFO_EXTENSION);
        $audio_file_path = "../audiovideo/" . $audio_file;

        $sqlvideo = "SELECT * FROM video WHERE category = ? ORDER BY RAND() LIMIT 1";
        $stmtvideo = $this->conn()->prepare($sqlvideo);
        $stmtvideo->execute([$category]);
        $rowvideo = $stmtvideo->fetch();
        $video_title = $rowvideo['title'];
        $video_file = $rowvideo['file'];
        $video_file_ext = pathinfo($video_file, PATHINFO_EXTENSION);
        $video_file_path = "../audiovideo/" . $video_file;
      endif;
?>
<!DOCTYPE html>
<html>
<head><?php include 'head.php'; ?></head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <?php include 'profile.php'; ?>
    <?php include 'sidebar.php'; ?>
    <div class="content-wrapper" style="height: 100vh;background-color: #f9f9f9;overflow-y: auto;">
      <section class="content-header">
        <h1>
          <?php echo ($_SESSION['type'] == 2) ? "Dashboard" : "Questionnaire"; ?>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active"><?php echo ($_SESSION['type'] == 2) ? "Dashboard" : "Questionnaire"; ?></li>
        </ol>
      </section>

      <?php if($_SESSION['type'] == 2): ?>
        <section class="content">
          <div class="row">
            <div class="col-lg-6 col-6">
              <div class="small-box" style="background-color: #ebc09a!important;color:#fff;">
                <div class="inner">
                    <h3><?php echo $totalstudents; ?></h3>
                    <p style="font-size: 18px;">Total Students</p>
                </div>
                <div class="icon" style="bottom: 50%;transform: translateY(25%);top: unset;">
                  <i class="fas fa-users" style="color:#fff;font-size: 30px;"></i>
                </div>
                <a href="students.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-6 col-6">
              <div class="small-box" style="background-color: #ebc09a!important;color:#fff;">
                <div class="inner">
                    <h3><?php echo $totalfaculty; ?></h3>
                    <p style="font-size: 18px;">Total Faculty</p>
                </div>
                <div class="icon" style="bottom: 50%;transform: translateY(25%);top: unset;">
                  <i class="fas fa-users" style="color:#fff;font-size: 30px;"></i>
                </div>
                <a href="faculty.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>            
          </div>
        </section>
      <?php endif; ?>



      <?php if($_SESSION['type'] == 0): ?>

        <?php $sql2 = "SELECT * FROM scores WHERE users_id = ? AND score >= ?";
        $stmt2 = $this->conn()->prepare($sql2);
        $stmt2->execute([$_SESSION['id'],70]);
        if($stmt2->rowcount() > 0): ?>
          <h2 style="color: red;font-weight: bold;text-align: center;">You can't take the test because you are depressed.</h2>
        <?php else: ?>

          <?php 
          $datetake = date('Y-m-d');
          // First check if we need to reset totaltake for a new day
          $sql = "SELECT datetake FROM users WHERE id = ?";
          $stmt = $this->conn()->prepare($sql);
          $stmt->execute([$_SESSION['id']]);
          $userData = $stmt->fetch();
          
          if ($userData['datetake'] != $datetake) {
              // It's a new day, reset the counter
              $sql = "UPDATE users SET datetake = ?, totaltake = 0 WHERE id = ?";
              $stmt = $this->conn()->prepare($sql);
              $stmt->execute([$datetake, $_SESSION['id']]);
          }
          
          // Now check if user can take the test
          $sql = "SELECT * FROM users WHERE id = ? AND totaltake < 2 AND datetake = ?";
          $stmt = $this->conn()->prepare($sql);
          $stmt->execute([$_SESSION['id'], $datetake]);
          if($stmt->rowcount() > 0): ?>
                <section class="content">
                  <div class="row">
                    <div class="col-lg-3">
                        <p><?php echo $readables_title ?></p>
                        <div>
                          <a href="../files/<?php echo $readables_file; ?>" target="_blank">Download</a>
                        </div>
                        <br>
                        <p><?php echo $audio_title ?></p>
                        <div>
                          <?php if (in_array($audio_file_ext, ['mp3', 'wav', 'ogg'])) { ?>
                            <audio controls>
                                <source src="<?php echo $audio_file_path; ?>" type="audio/<?php echo $audio_file_ext; ?>">
                                Your browser does not support the audio element.
                            </audio>
                          <?php } else { ?>
                              <?php echo $audio_file; ?>
                          <?php } ?>
                        </div>
                        <br>
                        <div>
                        <p><?php echo $video_title ?></p>
                            <?php if (in_array($video_file_ext, ['mp4', 'webm', 'ogg'])) { ?>
                              <!-- Video Player -->
                              <video width="200" controls>
                                  <source src="<?php echo $video_file_path; ?>" type="video/<?php echo $video_file_ext; ?>">
                                  Your browser does not support the video element.
                              </video>
                          <?php } else { ?>
                              <?php echo $video_file; ?>
                          <?php } ?>
                        </div>
                      </div>
                    <div class="col-lg-9">
                      <form method="POST" action="../controller/dashboardController.php" id="quizForm" onsubmit="return validateForm()">
                        <?php
                        // Get user's last assessment category
                        $sqlLastAssessment = "SELECT last_category FROM user_assessment_history 
                                            WHERE users_id = ? 
                                            ORDER BY assessment_date DESC LIMIT 1";
                        $stmtLastAssessment = $this->conn()->prepare($sqlLastAssessment);
                        $stmtLastAssessment->execute([$_SESSION['id']]);
                        $lastCategory = $stmtLastAssessment->fetch();
                        
                        // Determine which question table to use
                        if ($lastCategory) {
                            switch($lastCategory['last_category']) {
                                case 'normal':
                                    $tableName = "questionnaires_normal_2";
                                    break;
                                case 'anxiety':
                                    $tableName = "questionnaires_anxiety_2";
                                    break;
                                case 'depression':
                                    $tableName = "questionnaires_depression_2";
                                    break;
                                default:
                                    $tableName = "questionnaires";
                            }
                        } else {
                            // First time taking assessment
                            $tableName = "questionnaires";
                        }
                        
                        // Get questions from appropriate table
                        $sql = "SELECT *, $tableName.answers AS q_answers, $tableName.id AS questionnaires_ids 
                                FROM $tableName 
                                LEFT JOIN take_students ON $tableName.id = take_students.questionnaires_id 
                                    AND take_students.users_id = ? 
                                WHERE take_students.questionnaires_id IS NULL 
                                ORDER BY RAND() LIMIT 10";

                        $stmt = $this->conn()->prepare($sql);
                        $stmt->execute([$_SESSION['id']]);

                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch()) {
                                $id = $row['questionnaires_ids']; 
                        ?>
                          <div class="bg-light col-lg-6 p-3 m-3">
                              <h4 style="color:#000;font-weight: bold;"><?php echo $row['questions']; ?></h4>
                              
                              <div style="padding: 4px;">
                                  <input type="radio" name="choice[<?php echo $id; ?>]" value="<?php echo $row['choice1']; ?>"> <?php echo $row['choice1']; ?>
                              </div>
                              <div style="padding: 4px;">
                                  <input type="radio" name="choice[<?php echo $id; ?>]" value="<?php echo $row['choice2']; ?>"> <?php echo $row['choice2']; ?>
                              </div>
                              <div style="padding: 4px;">
                                  <input type="radio" name="choice[<?php echo $id; ?>]" value="<?php echo $row['choice3']; ?>"> <?php echo $row['choice3']; ?>
                              </div>
                              <div style="padding: 4px;">
                                  <input type="radio" name="choice[<?php echo $id; ?>]" value="<?php echo $row['choice4']; ?>"> <?php echo $row['choice4']; ?>
                              </div>

                              <input type="hidden" name="answer[<?php echo $id; ?>]" value="<?php echo $row['q_answers']; ?>">
                          </div>          
                          <?php } ?>
                          <div class="text-right">
                              <button type="submit" name="takequiz" class="btn btn-primary btn-lg">Submit</button>
                          </div>
                        <?php } else { ?>
                          <h2 style="color: green;font-weight: bold;text-align: center;">No Available Questionnaire</h2>
                        <?php } ?>
                      </form>
                    </div>
                  </div>
                </section>

            <?php else: ?>
              <h2 style="color: green;font-weight: bold;text-align: center;">Complete Take Test</h2>
            <?php endif; ?>

        <?php endif; ?>

      <?php endif; ?>
    </div>
  </div>
  <?php include 'footer.php'; ?>
  <script>
  function validateForm() {
      var questions = document.querySelectorAll('div.bg-light');
      var totalQuestions = questions.length;
      var answeredQuestions = 0;
      
      // Check each question group
      questions.forEach(function(questionDiv) {
          var radios = questionDiv.querySelectorAll('input[type="radio"]');
          var isAnswered = false;
          
          // Check if any radio button is selected for this question
          radios.forEach(function(radio) {
              if (radio.checked) {
                  isAnswered = true;
                  answeredQuestions++;
              }
          });
          
          if (!isAnswered) {
              // Add visual indication for unanswered question
              questionDiv.style.border = '2px solid red';
          } else {
              // Remove visual indication if question is answered
              questionDiv.style.border = 'none';
          }
      });
      
      if (answeredQuestions < totalQuestions) {
          alert('Please answer all questions before submitting the assessment test.');
          return false;
      }
      
      return true;
  }
  </script>
</body>
</html>
<?php } } $data = new data(); $data->managedata(); ?>