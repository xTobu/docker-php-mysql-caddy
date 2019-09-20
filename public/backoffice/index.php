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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.5.5/bluebird.js"></script>

    <!-- import Vue before Element -->
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-i18n/dist/vue-i18n.js"></script>

    <!-- import Element -->
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>
    <script src="https://unpkg.com/element-ui/lib/umd/locale/en.js"></script>
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
                    <el-col :span="1.5">
                        <el-avatar shape="square"> GVM </el-avatar>
                    </el-col>
                    <el-col :span="10" style="">
                        <el-button type="danger" icon="fas fa-sign-out-alt" circle @click.prevent="logout"></el-button>
                        <el-button type="success" icon="el-icon-download" circle @click.prevent="download"></el-button>
                    </el-col>
                    <el-col :span="12">
                        <el-input
                            placeholder="全文檢索"
                            v-model="strSearch"
                            prefix-icon="el-icon-search"
                            >
                        </el-input>
                    </el-col>
                </el-row>

            </el-header>
            <el-main>
                <el-card class="box-card">
                    <el-table
                        empty-text="無資料"
                        :data="computedTableData.slice((pageCurrent - 1 ) * pageSize, pageCurrent * pageSize)"
                        style="width: 100%">
                        <el-table-column
                            sortable
                            prop="created_at"
                            label="報名時間"
                            width="200">
                        </el-table-column>
                        <el-table-column
                            prop="event"
                            label="活動名稱"
                            width="120">
                        </el-table-column>
                        <el-table-column
                            sortable
                            prop="session"
                            label="場次"
                            width="100">
                        </el-table-column>
                        <el-table-column
                            prop="job"
                            label="職稱"
                            width="120">
                        </el-table-column>
                        <el-table-column
                            prop="dept"
                            label="所屬單位"
                            width="120">
                        </el-table-column>
                        <el-table-column
                            prop="rocid"
                            label="身分證字號"
                            width="120">
                        </el-table-column>
                        <el-table-column
                            prop="name"
                            label="姓名"
                            width="100">
                        </el-table-column>
                        <el-table-column
                            prop="phone"
                            label="電話"
                            width="120">
                        </el-table-column>
                        <el-table-column
                            prop="email"
                            label="信箱">
                        </el-table-column>
                    </el-table>
                    <el-pagination
                        :current-page.sync="pageCurrent"
                        background
                        layout="sizes, prev, pager, next"
                        @size-change="handleSizeChange"
                        :page-size="pageSize"
                        :page-sizes="[10, 30, 100, 300]"
                        :total="computedTableData.length">
                    </el-pagination>
                </el-card>
            </el-main>
        </el-container>

    </div>
</body>
<script src="./js/index.js"></script>
</html>