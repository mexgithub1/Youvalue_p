<?php
include '../config/config.php';

if (isset($_POST['takequiz'])) {
    $score = 0;
    
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

    if (isset($_POST['choice']) && isset($_POST['answer'])) {
        foreach ($_POST['choice'] as $questionId => $userAnswer) {
            $correctAnswer = $_POST['answer'][$questionId];

            if ($userAnswer == $correctAnswer) {
                $score += 10;
            }
        }
    }

    echo "<script type='text/javascript'>alert('Successfully Take Questionnaire');</script>";

    if ($score >= 0 && $score <= 39) {
        header("Location: ../register.php?score=$score");
    }else if ($score >= 40 && $score <= 90) {
        header("Location: ../register.php?score=$score");
    }else {
        header("Location: ../depressed.php?score=$score");
    }
    
    exit();
}
?>
