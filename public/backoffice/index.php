<?php
session_start();
if (!empty($_SESSION["su"])) {
    $su = $_SESSION["su"];
} else {
    header("Location: /backoffice/login.php");
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
    <link href="./style/index.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="app" style="display: none;" v-show="true">
        <?php echo $su; ?>
        <a href="/api/postLogout.php" class="logout-button">Logout</a>
    </div>
</body>
<script src="./js/index.js"></script>
</html>