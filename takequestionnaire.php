<?php
    include 'config/config.php';
    class data extends Connection { 
        public function managedata() { 
            $datetake = date('Y-m-d');

            $sql = "SELECT * FROM users WHERE datetake = ?";
            $stmt = $this->conn()->prepare($sql);
            $stmt->execute([$datetake]);

            if ($stmt->rowCount() > 0) {
            } else {
                $sql = "UPDATE users SET datetake = ?, totaltake = ? WHERE datetake IS NULL OR datetake != ?";
                $stmt = $this->conn()->prepare($sql);
                $stmt->execute([$datetake, 0, $datetake]);

            }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>YouValue</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
 <style>
    .form-group {
      position: relative;
    }
    .toggle-password {
      position: absolute;
      right: 15px;
      top: 12px;
      cursor: pointer;
    }
  </style>
<body class="hold-transition login-page" style="background-color: #fff;">
    <div class="login-box-body" style="padding: 20px 30px;height: 100vh;">
    	<h2 style="color:#000;font-weight: bold;margin-top: unset;">Questions</h2>

        <?php if(isset($_GET['score'])): ?>
            <div class="row">
                <div class="col-md-4">
                    <?php
                    $score = intval($_GET['score']);
                    
                    // Define therapy content based on assessment
                    if ($score >= 1 && $score <= 49) {
                        $videos = ['3 tips to overcome emotional anxiety.mp4', '3 keys to a happy life.mp4', '5 foods that ll make you happy.mp4'];
                        $audios = ['3 Ways to Cope with Depression.mp3', '5 CBT Exercises For Anxiety.mp3', '10,000 Reasons - Matt Redman.mp3'];
                        $message = "Your assessment shows you're doing well! Here are some resources to help maintain your mental well-being.";
                    } else if ($score >= 50 && $score <= 69) {
                        $videos = ['3 tips to overcoming anxiety symptoms once and for all.mp4', 'A prayer against anxiety.mp4', 'Anxiety and the solution.mp4'];
                        $audios = ['5 CBT Exercises For Anxiety.mp3', '4 Ways to Cope With Depression.mp3', '5 ONE-MINUTE Habits to Beat DEPRESSION.mp3'];
                        $message = "It seems like you might be experiencing some anxiety. We're here to support you—here are some helpful resources.";
                    } else {
                        $videos = ['A Message to Someone With Suicidal Thoughts.mp4', 'Am I Depressed.mp4', 'a prayer for those who struggle with depression pray praying christian bible depression sad.mp4'];
                        $audios = ['3 Ways to Cope with Depression.mp3', '4 Ways to Cope With Depression.mp3', '5 ONE-MINUTE Habits to Beat DEPRESSION.mp3'];
                        $message = "It seems like you might be going through a tough time. We're here for you—please share your details with us so we can reach out and support you.";
                    }
                    
                    // Select random video and audio
                    $random_video = $videos[array_rand($videos)];
                    $random_audio = $audios[array_rand($audios)];
                    ?>
                    
                    <div class="therapy-content" style="margin-bottom: 20px;">
                        <h4 style="color: #000; font-weight: bold;">Recommended Video</h4>
                        <video width="100%" controls>
                            <source src="audiovideo/<?php echo htmlspecialchars($random_video); ?>" type="video/mp4">
                            Your browser does not support the video element.
                        </video>
                    </div>
                    
                    <div class="therapy-content">
                        <h4 style="color: #000; font-weight: bold;">Recommended Audio</h4>
                        <audio controls style="width: 100%;">
                            <source src="audiovideo/<?php echo htmlspecialchars($random_audio); ?>" type="audio/mp3">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div style="width: 100%;text-align: center;color: green;font-size: 20px;">
                        Your Assessment Score: <?php echo $score; ?>
                        <p style="margin-top: 15px;"><?php echo $message; ?></p>
                    </div>
                </div>
            </div>
            <br>
        <?php endif; ?>
      <div class="box-body">
 

            <form method="POST" action="controller/takequestionnaireController.php" id="quizForm" onsubmit="return validateForm()">
                <?php
				$sql = "SELECT * FROM questionnaires ORDER BY RAND() LIMIT 10";
                $stmt = $this->conn()->query($sql);
                while ($row = $stmt->fetch()) {
                    $id = $row['id']; 
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

                    <input type="hidden" name="answer[<?php echo $id; ?>]" value="<?php echo $row['answers']; ?>">
                </div>          
                <?php } ?>
                <div class="text-right">
                    <button type="submit" name="takequiz" class="btn btn-primary btn-lg">Submit</button>
                </div>
            </form>

            <h3>Assessment Results:</h3>
      </div>
    </div>

<script src="dist/js/jquery.js"></script>
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