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
        .therapy-content {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .therapy-content h4 {
            margin-bottom: 15px;
        }
        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
        }
        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        @media (max-width: 768px) {
            .login-box {
                margin: 10px;
            }
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box" style="max-width: 800px;">
        <div class="login-box-body">
            <div style="text-align: center; margin-bottom: 20px;">
                <img src="images/logo.png" width="100px">
            </div>

            <?php if (isset($_GET['score'])) { 
                $score = intval($_GET['score']);
                
                // Define therapy content based on assessment
                if ($score >= 1 && $score <= 49) {
                    $videos = ['3 tips to overcome emotional anxiety.mp4', '3 keys to a happy life.mp4', '5 foods that ll make you happy.mp4'];
                    $audios = ['3 Ways to Cope with Depression.mp3', '5 CBT Exercises For Anxiety.mp3', '10,000 Reasons - Matt Redman.mp3'];
                    $message = "responses fall within the typical range—everything looks good! If you'd like to save your results and explore more features, consider creating a YouValue account to continue your wellness journey";
                } else if ($score >= 50 && $score <= 69) {
                    $videos = ['3 tips to overcoming anxiety symptoms once and for all.mp4', 'A prayer against anxiety.mp4', 'Anxiety and the solution.mp4'];
                    $audios = ['5 CBT Exercises For Anxiety.mp3', '4 Ways to Cope With Depression.mp3', '5 ONE-MINUTE Habits to Beat DEPRESSION.mp3'];
                    $message = "responses suggest that you may be dealing with anxiety, and you're not alone in this. Creating a YouValue account can help you track your progress, access support, and take meaningful steps toward feeling better.";
                } else {
                    $videos = ['A Message to Someone With Suicidal Thoughts.mp4', 'Am I Depressed.mp4', 'a prayer for those who struggle with depression pray praying christian bible depression sad.mp4'];
                    $audios = ['3 Ways to Cope with Depression.mp3', '4 Ways to Cope With Depression.mp3', '5 ONE-MINUTE Habits to Beat DEPRESSION.mp3'];
                    $message = "responses suggest that you may be experiencing depression. We're here to support you. Creating a YouValue account will connect you with resources and support to help you through this time.";
                }
                
                // Select random video and audio
                $random_video = $videos[array_rand($videos)];
                $random_audio = $audios[array_rand($audios)];
            ?>
                <div style="text-align: center;color: green;font-size: 18px;margin-bottom: 20px;">
                    <strong>Assessment Score: <?php echo $score; ?></strong>
                    <p style="margin-top: 10px;">Your <?php echo $message; ?></p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="therapy-content">
                            <h4 style="color: #000; font-weight: bold;">Recommended Video</h4>
                            <div class="video-container">
                                <video controls>
                                    <source src="audiovideo/<?php echo htmlspecialchars($random_video); ?>" type="video/mp4">
                                    Your browser does not support the video element.
                                </video>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="therapy-content">
                            <h4 style="color: #000; font-weight: bold;">Recommended Audio</h4>
                            <audio style="width: 100%;" controls>
                                <source src="audiovideo/<?php echo htmlspecialchars($random_audio); ?>" type="audio/mp3">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div style="display: flex;justify-content: space-evenly;padding: 0px 50px;margin-top: 20px;">
                <h3 class="text-center" style="width: 100%;padding: 5px;">
                    <a href="login.php" class="text-decoration-none" style="color: #000;">Login</a>
                </h3>
                <h3 class="text-center" style="border-bottom: 3px solid #ebc09a;width: 100%;padding: 5px;">
                    <a href="register.php" class="text-decoration-none" style="color: #000;">Signup</a>
                </h3>
            </div>

            <p class="login-box-msg">Create an account?</p>

            <form action="controller/registerController.php" method="POST">
                <div class="form-group has-feedback form-control" style="height: 45px;">
                    <input type="text" name="firstname" placeholder="First Name" style="width: 100%;height: 100%;border: unset;box-shadow: none;outline-style: none;" required>
                </div>
                <div class="form-group has-feedback form-control" style="height: 45px;">
                    <input type="text" name="lastname" placeholder="Last Name" style="width: 100%;height: 100%;border: unset;box-shadow: none;outline-style: none;" required>
                </div>
                <div class="form-group has-feedback form-control" style="height: 45px;">
                    <input type="text" name="middlename" placeholder="Middle Name" style="width: 100%;height: 100%;border: unset;box-shadow: none;outline-style: none;" required>
                </div>
                <div class="form-group has-feedback form-control" style="height: 45px;">
                    <input type="email" name="email" placeholder="Email" style="width: 100%;height: 100%;border: unset;box-shadow: none;outline-style: none;" required>
                    <span class="fa fa-at form-control-feedback" style="margin-top: 6px;"></span>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group has-feedback form-control" style="height: 45px;margin-bottom: 10px;">
                            <input type="password" name="password" id="password" placeholder="******" style="width: 100%;height: 100%;border: unset;box-shadow: none;outline-style: none;" required>
                            <i class="fa fa-eye-slash toggle-password" style="position: absolute; right: 15px; top: 10px; cursor: pointer;margin-top: 6px;"></i>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group has-feedback form-control" style="height: 45px;">
                            <input type="password" name="confirmpassword" placeholder="******" style="width: 100%;height: 100%;border: unset;box-shadow: none;outline-style: none;" required>
                            <i class="fa fa-eye-slash toggle-password2" style="position: absolute; right: 15px; top: 10px; cursor: pointer;margin-top: 6px;"></i>
                        </div>
                    </div>
                </div>          
                <div class="form-group has-feedback form-control" style="height: 45px;">
                    <input type="text" name="phone_number" placeholder="Phone Number" style="width: 100%;height: 100%;border: unset;box-shadow: none;outline-style: none;" required>
                </div>
                <div class="form-group has-feedback form-control" style="height: 45px;">
                    <input type="number" name="age" placeholder="Age" style="width: 100%;height: 100%;border: unset;box-shadow: none;outline-style: none;" required>
                </div>
                <div class="form-group has-feedback form-control" style="height: 45px;">
                    <select name="gender" style="width: 100%;height: 100%;border: unset;box-shadow: none;outline-style: none;" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-block btn-flat submit" style="background: #ebc09a; color: #fff; border: unset;height: 45px;font-size: 23px;" name="register">Signup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="dist/js/jquery.js"></script>
    <script>
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye-slash fa-eye");
            var input = $(this).prev("input");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $(".toggle-password2").click(function() {
            $(this).toggleClass("fa-eye-slash fa-eye");
            var input = $(this).prev("input");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
</body>
</html>
