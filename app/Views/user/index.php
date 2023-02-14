<?= $this->extend('layout/default') ?>

<?= $this->section('page_title') ?>
    <title>ねね丸シート - Self Information</title>
<?= $this->endSection() ?>

<?= $this->section('addition_style') ?>
    <style>
        .nav-link:hover {
            background-color: #1E91D6;
        }
        .jsgrid {
            font-size: 80%;
        }

        .jsgrid-cell {
            padding: 0.2rem;
        }

        .jsgrid-cell .btn-sm {
            font-size: 0.7rem;
            padding: 0.1rem 0.2rem;
        }

        .jsgrid-header-cell .btn-sm {
            font-size: 0.7rem;
            padding: 0.1rem 0.2rem;
        }

        .jsgrid-edit-row input, .jsgrid-edit-row select {
            padding: 0;
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card">
        <div class="card-body">
            <form id="account-form" action="/">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="fullname">フルネーム</label>
                            <input autocomplete='off' type="text" class="form-control" id="fullname" name="fullname" value="<?= $fullname ?>">
                            <small id="fullname-valid" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="email">メールアドレス</label>
                            <input autocomplete='off' type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
                            <small id="email-valid" class="form-text text-muted"></small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" style="display: flex;align-items: center;justify-content: center;}">
                        <div class="card" style="display: flex;align-items: center;justify-content: center;}">
                            <div id="mode_price" class="card-body" style="width: 100%;text-align: center; padding: 1rem; font-size: 2rem;">
                                <h1><?= $plan ?> Mode</h1>
                                <h4><?= $expire_date ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12" id="msg">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12" style="text-align: center">
                        <button 
                            type="button" 
                            class="btn btn-primary" 
                            data-toggle="modal" 
                            data-target="#inputpassword-modal" 
                            data-backdrop="static" 
                        >アカウントを更新する</button>
                        <button 
                            type="button" 
                            class="btn btn-warning" 
                            data-toggle="modal" 
                            data-target="#changePassword-modal" 
                            data-backdrop="static" 
                        >パスワードを変更する</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title" style="text-align: center">設定</h5>
            <div class="card-text">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="mr-2" for="balance">初期残高</label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group mb-3">
                                <input autocomplete='off' id="balance" name="balance" type="number" min="0" step="1000" class="form-control form-control-sm text-right" style="width:6rem" value="0">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="balance-addon" style="font-size: 0.875rem;padding: 0.25rem;">円</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="mr-2" for="balance-from">初期残高登録日</label>
                        </div>
                        <div class="col-md-8 mb-3">
                            <input autocomplete='off' id="balance-from" name="balance-from" type="date" class="form-control form-control-sm text-right" style="width:100%rem">
                        </div>
                        <div class="col-md-4">
                            <label class="mr-2" for="goal">月間目標収益</label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group mb-3">
                                <input id="goal" name="goal" type="number" min="0" step="1000" class="form-control form-control-sm text-right" style="width:6rem" value="0">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="goal-addon" style="font-size: 0.875rem;padding: 0.25rem;">円</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="mr-2" for="average-period">勝率計算期間</label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group input-group-sm mr-1">
                                <input name="average-from" id="average-from" type="date" class="form-control form-control-sm" style="width:9rem">
                                <div class="input-group-prepend input-group-append">
                                    <span class="input-group-text">～</span>
                                </div>
                                <input name="average-to" id="average-to" type="date" class="form-control form-control-sm" style="width:9rem">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-4">
                                <div>手法一覧</div>
                                <div id="jsGrid"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 text-right">
                            <button class="btn btn-sm btn-secondary" onclick="uploadCSV()">CSVアップロード</button>
                            <input type="file" class="invisible" id="input-file" style="display: none">
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-sm btn-primary" style="width:6rem" onclick="saveConfig()">保存</button>
                        </div>
                    </div>
                </div>
                <!--
                <div class="form-inline mb-4">
                    <label class="mr-2" for="affiliate">紹介URL</label>
                    <input id="affiliate" name="affiliate" type="text" class="form-control form-control-sm mr-1" style="width:24rem" value="<?= $affiliateUrl ?>">
                </div>
                -->
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>

    <div id="changePassword-modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="passwordupdate-form" action="/">
            <div class="modal-content">
                <div class="modal-header">
                    <div>パスワードを入力してください</div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="old_password">以前のパスワード</label>
                        <input autocomplete='off' type="password" class="form-control" id="old_password" name="old_password">
                        <small id="old_password-valid" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="new_password">新しいパスワード</label>
                        <input autocomplete='off' type="password" class="form-control" id="new_password" name="new_password">
                        <small id="new_password-valid" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirm">新しいパスワードの確認</label>
                        <input autocomplete='off' type="password" class="form-control" id="new_password_confirm" name="new_password_confirm">
                        <small id="new_password_confirm-valid" class="form-text text-muted"></small>
                    </div>
                    <div id="msg"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">閉じる</button>
                    <button type="submit" class="btn btn-sm btn-success">更新</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    
    <div id="inputpassword-modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="password-form" action="/">
            <div class="modal-content">
                <div class="modal-header">
                    <div>パスワードを入力してください</div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="password">パスワード</label>
                        <input autocomplete='off' type="password" class="form-control" id="password" name="password">
                        <small id="password-valid" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">閉じる</button>
                    <button type="submit" class="btn btn-sm btn-success">アカウントを更新する</button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <div id="insertModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body form-inline">
                    <label class="mr-2" for="insert-name">手法名</label>
                    <input id="insert-name" type="text" class="form-control form-control-sm" style="width:8rem">
                    <label class="ml-4 mr-2" for="insert-order">並び順</label>
                    <input id="insert-order" type="number" min="0" class="form-control form-control-sm text-right" style="width:6rem">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-sm btn-primary" onclick="insertMethod()">追加</button>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-danger">
                        削除すると元には戻せません。<br>
                        本当に削除してもよろしいでしょうか？
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteMethod()">削除</button>
                </div>
            </div>
        </div>
    </div>

    <div id="messageModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="message"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section("addition_script") ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js" integrity="sha512-blBYtuTn9yEyWYuKLh8Faml5tT/5YPG0ir9XEABu5YCj7VGr2nb21WPFT9pnP4fcC3y0sSxJR1JqFTfTALGuPQ==" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <script>
        $(document).ready(function() {
            var accountform = $("#account-form");
            var passwordform = $("#password-form");
            var passwordmodal = $("#inputpassword-modal");
            var passwordupdateform = $("#passwordupdate-form");
            var passwordupdatemodal = $("#changepassword-modal");

            passwordform.submit(function(event) {
                event.preventDefault();
                var fullname = accountform.find("input[name='fullname']").val();
                var email = accountform.find("input[name='email']").val();

                var verified = true
                if (fullname == "") {
                    accountform.find("#fullname-valid").html("フルネームを挿入してください");
                    verified = verified && false;
                } else {
                    accountform.find("#fullname-valid").html("");
                }
                if (!isEmailValid(email)) {
                    accountform.find("#email-valid").html("無効なメール");
                    verified = verified && false;
                } else {
                    accountform.find("#email-valid").html("");
                }
                if (verified) {
                    var password = passwordform.find("input[name='password']").val();
                    if (password == "" || password.length < 4) {
                        passwordform.find("#password-valid").html("無効なパスワード");
                    } else {
                        passwordform.find("#password-valid").html("");
                        var data = {
                            fullname: fullname,
                            email: email,
                            password: password,
                        }
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url() ?>/user/api/updateAccount",
                            data: data,
                            dataType: "json",
                            success: function(result){  
                                if (result.code == "200") {
                                    passwordmodal.modal("hide");
                                    accountform.find("#msg").html("\
                                        <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\
                                            <h4 class=\"alert-heading\">\
                                            正常に更新されました\
                                            </h4>\
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\
                                                <span aria-hidden=\"true\">&times;</span>\
                                            </button>\
                                        </div>\
                                    ");
                                } else if (result.code == "401") {
                                    passwordform.find("#password-valid").html(result.msg);
                                } else if (result.code == "500") {
                                    passwordform.find("#password-valid").html(result.msg);
                                }
                            },
                            error: function(xhr) {
                                alert("Connection problem, please check your connection and if there is no problem, please connect to developer");
                                console.log(xhr)
                            }
                        });
                    }
                } else {
                    passwordmodal.modal("hide");
                }
            });

            passwordupdateform.submit(function(event) {
                event.preventDefault();
                var old_password = passwordupdateform.find("input[name='old_password']").val();
                var new_password = passwordupdateform.find("input[name='new_password']").val();
                var new_password_confirm = passwordupdateform.find("input[name='new_password_confirm']").val();

                var verified = true;
                if (old_password == "" || old_password.length < 4) {
                    passwordupdateform.find("#old_password-valid").html("無効なパスワード");
                    verified = verified && false;
                } else {
                    passwordupdateform.find("#old_password-valid").html("");
                }
                if (new_password == "" || new_password.length < 4) {
                    passwordupdateform.find("#new_password-valid").html("無効なパスワード");
                    verified = verified && false;
                } else {
                    passwordupdateform.find("#new_password-valid").html("");
                }
                if (new_password_confirm == "" || new_password_confirm.length < 4) {
                    passwordupdateform.find("#new_password_confirm-valid").html("無効なパスワード");
                    verified = verified && false;
                } else if (new_password_confirm != new_password) {
                    passwordupdateform.find("#new_password_confirm-valid").html("パスワードが一致していません");
                    verified = verified && false;
                } else {
                    passwordupdateform.find("#new_password_confirm-valid").html("");
                }
                if (verified) {
                    var data = {
                        old_password: old_password,
                        new_password: new_password,
                    }
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url() ?>/user/api/updatePassword",
                        data: data,
                        dataType: "json",
                        success: function(result){  
                            if (result.code == "200") {
                                console.log(passwordupdateform.find("#msg"))
                                passwordupdateform.find("#msg").html("\
                                    <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\
                                        <h4 class=\"alert-heading\">\
                                            正常に更新されました\
                                        </h4>\
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\
                                            <span aria-hidden=\"true\">&times;</span>\
                                        </button>\
                                    </div>\
                                ");
                                passwordupdateform.find("input[name='old_password']").val("");
                                passwordupdateform.find("input[name='new_password']").val("");
                                passwordupdateform.find("input[name='new_password_confirm']").val("");
                            } else if (result.code == "401") {
                                passwordupdatemodal.find("#msg").html(result.msg);
                            } else if (result.code == "500") {
                                passwordupdatemodal.find("#msg").html(result.msg);
                            } else {
                                console.log(result)
                            }
                        },
                        error: function(xhr) {
                            alert("Connection problem, please check your connection and if there is no problem, please connect to developer");
                            console.log(xhr)
                        }
                    });
                } else {
                    alert("Unknown error")
                }
            });
        })
    </script>

    <script>
        function formReset() {
            var formDefault = <?= json_encode(isset($formDefault) ? $formDefault : []) ?>;
            for (let _ in formDefault) {
                if (Array.isArray(formDefault[_])) {
                    let s = document.getElementsByName(_ + "[]").item(0);
                    if (s != null) for (let o of s.getElementsByTagName("option")) for (let i of formDefault[_]) if (o.value == i) o.selected = true;
                }
                else {
                    if (document.getElementsByName(_).item(0) != null) document.getElementsByName(_).item(0).value = formDefault[_];
                }
            }
        }
        formReset();

        var selectedItem;

        $("#jsGrid").jsGrid({
            width: "100%",
            height: "auto",

            editing: true,
            sorting: true,
            paging : true,
            confirmDeleting: false,

            data: <?= json_encode($methods) ?>,

            fields: [
                { name: "id", visible: false },
                { name: "name", title: "手法名", type: "text", width: 200, validate: "required" },
                { name: "order", title: "並び順", type: "number", width: 100, validate: "required" },
                {
                    headerTemplate: function() {
                        return $("<button>").attr("type", "button").addClass("btn btn-outline-secondary btn-sm").text("追加")
                                .on("click", function () {
                                    $("#insert-name").removeClass("is-invalid").val("");
                                    $("#insert-order").removeClass("is-invalid").val("0");
                                    $("#insertModal").modal("show");
                                });
                    },
                    itemTemplate: function(_, item) {
                        return $("<button>").attr("type", "button").addClass("btn btn-outline-secondary btn-sm").text("削除")
                                .on("click", function () {
                                    selectedItem = item;
                                    $("#deleteModal").modal("show");
                                });
                    },
                    align: "center",
                    width: 50,
                    sorting: false,
                }
            ],

            rowClick: function(args) {
                try {
                    $("#jsGrid").jsGrid("updateItem");
                } catch {}
            },
            rowDoubleClick: function(args) {
                $("#jsGrid").jsGrid("editItem", args.item);
                $(".jsgrid-edit-row input").on("keypress", function (e) {
                    if(e.which == 13) $("#jsGrid").jsGrid("updateItem");
                });
            },
            onItemUpdated: function(args) {
                updateMethod(args.item);
            },
            invalidNotify: function(args) {
            }
        });
        $("#jsGrid").jsGrid("sort", {field: "order", order: "asc"});


        function insertMethod()
        {
            var invalid = false;

            if ($("#insert-name").val() == "")
            {
                invalid = true;
                $("#insert-name").addClass("is-invalid");
            }
            else
            {
                $("#insert-name").removeClass("is-invalid");
            }

            if (!$("#insert-order").val().match(/^\d+$/))
            {
                invalid = true;
                $("#insert-order").addClass("is-invalid");
            }
            else
            {
                $("#insert-order").removeClass("is-invalid");
            }

            if (invalid == false)
            {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>/user/api/insertMethod",
                    data: {
                        name: $("#insert-name").val(),
                        order: $("#insert-order").val(),
                    },
                    dataType: "json",
                })
                .done(function(data) {
                    $("#jsGrid").jsGrid("insertItem", data);
                    if ($("#jsGrid").jsGrid("getSorting")['field'] !== undefined)
                        $("#jsGrid").jsGrid("sort", $("#jsGrid").jsGrid("getSorting"));
                    $("#insertModal").modal("hide");
                });
            }
        }

        function updateMethod(data)
        {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>/user/api/updateMethod",
                data: data,
            })
            .done(function() {
                if ($("#jsGrid").jsGrid("getSorting")['field'] !== undefined)
                    $("#jsGrid").jsGrid("sort", $("#jsGrid").jsGrid("getSorting"));
            });
        }

        function deleteMethod()
        {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>/user/api/deleteMethod",
                data: {
                    id: selectedItem['id'],
                },
            })
            .done(function() {
                var sorting = $("#jsGrid").jsGrid("getSorting");
                $("#jsGrid").jsGrid("deleteItem", selectedItem);
                if (sorting !== undefined)
                    $("#jsGrid").jsGrid("sort", sorting);
                $("#deleteModal").modal("hide");
            });
        }

        // BUG
        function saveConfig()
        {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>/user/api/saveConfig",
                data: {
                    "balance"       : $("#balance").val(),
                    "balance-from" : $("#balance-from").val(),
                    "average-from"  : $("#average-from").val(),
                    "average-to"    : $("#average-to").val(),
                    "goal"          : $("#goal").val(),
                },
            })
            .done(function(data) {
                $("#message").html("保存しました。");
                $("#messageModal").modal("show");
                updateTotalBalance();
            });
        }

        function uploadCSV() {
            $("#input-file").click();
        }

        $("#input-file").on("change", function() {
            let fileReader = new FileReader();
            let file = $("#input-file")[0].files[0];
            fileReader.readAsDataURL(file);
            fileReader.onload = function() {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>/user/api/uploadCSV",
                    data: {
                        data: fileReader.result.substr(fileReader.result.indexOf(',') + 1),
                    },
                    dataType: "json",
                })
                .done(function (data) {
                    if (data.result == "success")
                    {
                        $("#message").html("CSVを取引履歴に反映しました。");
                        $("#messageModal").modal("show");
                    }
                    else
                    {
                        $("#message").html("失敗しました。<br>管理者までお問い合わせください。");
                        $("#messageModal").modal("show");
                    }
                });
            };
        });


        function updateTotalBalance() {
            $.ajax({
                type: "GET",
                url: "<?= base_url() ?>/user/api/getTotalBalance",
                dataType: "json",
            })
            .done(function (data) {
                $("#total-balance").html(data["balance"].toLocaleString());
                $("#total-profit").html(data["profit"].toLocaleString());
                $("#total-average").html(data["average"]);
            });
        }
        updateTotalBalance();
    </script>
    
<?= $this->endSection() ?>