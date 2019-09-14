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
    <title>Attendees</title>
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
    
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link href="./style/index.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="app" style="display: none;" v-show="true">
        <el-container>
            <el-header>
                <!-- <?php echo $su; ?> -->
                <el-row :gutter="20">
                    <el-col :span="2">
                        <el-avatar shape="square"> GVM </el-avatar>
                    </el-col>
                    <el-col :span="12">
                        <el-input
                            placeholder="全文檢索"
                            prefix-icon="el-icon-search"
                            >
                        </el-input>
                    </el-col>
                    <el-col :span="10" style="text-align: right;">
                        <el-button type="success" icon="el-icon-download" circle></el-button>
                        <el-button type="danger" icon="fas fa-sign-out-alt" circle @click.prevent="logout"></el-button>
                    </el-col>
                </el-row>

            </el-header>
            <el-main>
                <el-card class="box-card">
                    <el-table
                        :data="tableData"
                        style="width: 100%">
                        <el-table-column
                            sortable
                            prop="date"
                            label="日期"
                            width="180">
                        </el-table-column>
                        <el-table-column
                            prop="name"
                            label="姓名"
                            width="180">
                        </el-table-column>
                        <el-table-column
                            prop="address"
                            label="地址">
                        </el-table-column>
                    </el-table>
                    <el-pagination
                        :hide-on-single-page="true"
                        :current-page.sync="pageCurrent"
                        background
                        layout="prev, pager, next"
                        :page-size="pageSize"
                        :total="pageTotalCount">
                    </el-pagination>
                </el-card>
            </el-main>
        </el-container>

    </div>
</body>
<script src="./js/index.js"></script>
</html>