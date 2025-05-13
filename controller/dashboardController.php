<?php
  
    include '../config/config.php';
    session_start();
  
    class controller extends Connection{
  
    public function managecontroller(){ 

        $users_id = $_SESSION['id'];

        if (isset($_POST['takequiz'])) {
            $score = 0;

            $code = rand(0000000000,9999999999);

            // Check if all questions are answered
            $totalQuestions = count($_POST['answer']);
            $answeredQuestions = isset($_POST['choice']) ? count($_POST['choice']) : 0;
            
            if ($answeredQuestions < $totalQuestions) {
                echo "<script type='text/javascript'>
                    alert('Please answer all questions before submitting the assessment test.');
                    window.history.back();
                </script>";
                exit();
            }

            if (isset($_POST['choice'])) {
                foreach ($_POST['choice'] as $questionId => $selectedAnswer) {
                    // Prepare the SQL statement
                    $sql = "INSERT INTO take_students (code,users_id,questionnaires_id, answers) VALUES (?, ?, ?, ?)";
                    $stmt = $this->conn()->prepare($sql);
                    $stmt->execute([$code, $users_id, $questionId, $selectedAnswer]);
                }
            }

            if (!empty($_POST['choice']) && !empty($_POST['answer'])) {
                foreach ($_POST['choice'] as $questionId => $userAnswer) {
                    if (isset($_POST['answer'][$questionId])) {
                        $correctAnswer = $_POST['answer'][$questionId];
                        if ($userAnswer == $correctAnswer) {
                            $score += 10; // Increment score
                        }
                    }
                }
            }

            $sql = "INSERT INTO scores (code,users_id,score) VALUES ( ?, ?, ?)";
            $stmt = $this->conn()->prepare($sql);
            $stmt->execute([$code, $users_id, $score]);

            // Determine category based on score
            $category = '';
            if($score >= 70) {
                $category = 'depression';
            } else if($score >= 50) {
                $category = 'anxiety';
            } else {
                $category = 'normal';
            }

            // Update user's assessment history
            $sql = "INSERT INTO user_assessment_history (users_id, last_category, assessment_date) VALUES (?, ?, CURDATE())";
            $stmt = $this->conn()->prepare($sql);
            $stmt->execute([$users_id, $category]);

            $datetake = date('Y-m-d');

            $sql = "SELECT * FROM users WHERE id = '".$users_id."' AND datetake = '".$datetake."'";
            $stmt = $this->conn()->query($sql);
            if ($stmt->rowcount() > 0) {

                $row = $stmt->fetch();

                $totaltake = $row['totaltake'] + 1;

                $sql = "UPDATE users SET totaltake = ? WHERE id = ?";
                $stmt = $this->conn()->prepare($sql);
                $stmt->execute([$totaltake,$users_id]);

            }

            echo "<script type='text/javascript'>alert('Successfully Took the Test');</script>";
            echo "<script>window.location.href='../admin/dashboard.php';</script>";
        }
         
    }

  }
  
  $controllerrun = new controller();
  $controllerrun->managecontroller();

?>



