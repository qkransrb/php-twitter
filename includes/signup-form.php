<?php
    if (isset($_POST["signup"]) && !empty($_POST["signup"])) {
        $screenName = $_POST["screenName"];
        $email      = $_POST["email"];
        $password   = $_POST["password"];
        $error      = "";

        if (!empty($screenName) and !empty($email) and !empty($password)) {
            $screenName = $getFromU->checkInput($screenName);
            $email      = $getFromU->checkInput($email);
            $password   = $getFromU->checkInput($password);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format";
            } else if (strlen($screenName) > 20) {
                $error = "Name must be between in 4-20 characters";
            } else if (strlen($password) < 4) {
                $error = "Password is too shrot";
            } else {
                if ($getFromU->checkEmail($email) == true) {
                    $error = "Email is already in use";
                } else {
                    $user_id = $getFromU->create("users", array("screen_name" => $screenName, "email" => $email, "password" => md5($password)));
                    $_SESSION["user_id"] = $user_id;

                    header("Location: includes/signup.php?step=1");
                }
            }
        } else {
            $error = "All fields are required";
        }
    }
?>

<form method="post">
    <div class="signup-div"> 
        <h3>Sign up </h3>
        <ul>
            <li>
                <input type="text" name="screenName" placeholder="Full Name"/>
            </li>
            <li>
                <input type="email" name="email" placeholder="Email"/>
            </li>
            <li>
                <input type="password" name="password" placeholder="Password"/>
            </li>
            <li>
                <input type="submit" name="signup" Value="Signup for Twitter">
            </li>
        
            <?php 
                if (isset($error)) {
                    echo '
                        <li class="error-li">
                            <div class="span-fp-error">'. $error .'</div>
                        </li> 
                    ';
                }
            ?>
        </ul>
       
    </div>
</form>