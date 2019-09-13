<?php
session_start();

// Logout
$_SESSION["su"] = "";
session_destroy();

// Set error message
if (isset($_SESSION["errorMessage"])) {
    $msgErr = $_SESSION["errorMessage"];
    unset($_SESSION["errorMessage"]);
}
?>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
      integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
      crossorigin="anonymous"
    />
    <!-- import Vue before Element -->
    <script src="https://unpkg.com/vue/dist/vue.js"></script>

    <!-- import Element -->
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>
    <link href="https://unpkg.com/element-ui/lib/theme-chalk/index.css" rel="stylesheet" >

    <link href="./style/login.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="app" style="display: none;" v-show="true">
        <div class="login">
            <el-card>
                <h2>BackOffice</h2>
                <el-form
                    name="login"
                    class="login-form"
                    ref="form"
                    action="/api/postLogin.php" 
                    method="post"
                >
                    <input type="hidden" name="formName" value="login"/>
                    <el-form-item prop="user">
                        <el-input
                            name="user"
                            v-model="user"
                            placeholder="Username"
                            prefix-icon="fas fa-user"
                        >
                        </el-input>
                    </el-form-item>
                    <el-form-item prop="pwd">
                        <el-input
                            name="pwd"
                            v-model="pwd"
                            placeholder="Password"
                            type="password"
                            prefix-icon="fas fa-lock"
                        >
                    </el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button
                            class="login-button"
                            type="primary"
                            native-type="submit"
                            block
                            >Login</el-button
                        >
                    </el-form-item>
                    <el-alert
                        v-show="<?php echo $msgErr ?: "false"; ?>"
                        title="<?php echo $msgErr; ?>"
                        type="error"
                        show-icon>
                    </el-alert>
                </el-form>
            </el-card>
        </div>
    </div>
</body>

<script src="./js/login.js"></script>
</html>
