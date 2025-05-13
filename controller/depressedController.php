<?php
    include '../config/config.php';

    class controller extends Connection{

        public function managecontroller(){

            if (isset($_POST['submit'])) {
                $fullname = $_POST['fullname'];
                $email = $_POST['email'];
                $phone_number = $_POST['phone_number'];
                $age = $_POST['age'];
                $gender = $_POST['gender'];
                $priority = $_POST['priority'];
                $score = $_POST['score'];

                $sql = "INSERT INTO depressed (fullname, email, phone_number, age, gender, priority, score, status) VALUES (?,?,?,?,?,?,?,'Pending')";
                $stmt = $this->conn()->prepare($sql);
                $stmt->execute([$fullname, $email, $phone_number, $age, $gender, $priority, $score]);
           
                echo "<script type='text/javascript'>alert('Successfully Submit Form');</script>";
                echo "<script>window.location.href='../login.php';</script>";
            }

            if (isset($_POST['update_status'])) {
                $id = $_POST['id'];
                $status = $_POST['status'];

                $sql = "UPDATE depressed SET status = ? WHERE id = ?";
                $stmt = $this->conn()->prepare($sql);
                $stmt->execute([$status, $id]);
           
                echo "<script type='text/javascript'>alert('Status Updated Successfully');</script>";
                echo "<script>window.location.href='../admin/depressed.php';</script>";
            
            }

        }

    }

    $controllerrun = new controller();
    $controllerrun->managecontroller();

?>
