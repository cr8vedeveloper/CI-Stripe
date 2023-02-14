<?= $this->extend('layout/default') ?>

<?= $this->section('page_title') ?>
    <title>ねね丸シート - 設定</title>
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
            <h5 class="card-title">設定</h5>
            <div class="card-text">

                <div class="form-inline mb-4">
                    <label class="mr-2" for="balance">初期残高</label>
                    <input id="balance" name="balance" type="number" min="0" step="1000" class="form-control form-control-sm text-right mr-1" style="width:6rem" value="0">円
                </div>
                <div class="form-inline mb-4">
                    <label class="mr-2" for="balance-from">初期残高登録日</label>
                    <input id="balance-from" name="balance-from" type="date" class="form-control form-control-sm" style="width:9rem">
                </div>
                <div class="form-inline mb-4">
                    <label class="mr-2" for="goal">月間目標収益</label>
                    <input id="goal" name="goal" type="number" min="0" step="1000" class="form-control form-control-sm text-right mr-1" style="width:6rem" value="0">円
                </div>
                <div class="form-inline mb-4">
                    <label class="mr-2" for="average-period">勝率計算期間</label>
                    <div class="input-group input-group-sm mr-1">
                        <input name="average-from" id="average-from" type="date" class="form-control form-control-sm" style="width:9rem">
                        <div class="input-group-prepend input-group-append">
                            <span class="input-group-text">～</span>
                        </div>
                        <input name="average-to" id="average-to" type="date" class="form-control form-control-sm" style="width:9rem">
                    </div>
                </div>
                <div class="mb-4">
                    <div>手法一覧</div>
                    <div id="jsGrid"></div>
                </div>
                <div class="mb-4">
                    <button class="btn btn-sm btn-secondary" onclick="uploadCSV()">CSVアップロード</button>
                    <input type="file" class="invisible" id="input-file">
                </div>
                <!--
                <div class="form-inline mb-4">
                    <label class="mr-2" for="affiliate">紹介URL</label>
                    <input id="affiliate" name="affiliate" type="text" class="form-control form-control-sm mr-1" style="width:24rem" value="<?= $affiliateUrl ?>">
                </div>
                -->
                <div class="form-inline pt-2">
                    <button type="button" class="btn btn-primary" style="width:6rem" onclick="saveConfig()">保存</button>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
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

<?= $this->section('addition_script') ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js" integrity="sha512-blBYtuTn9yEyWYuKLh8Faml5tT/5YPG0ir9XEABu5YCj7VGr2nb21WPFT9pnP4fcC3y0sSxJR1JqFTfTALGuPQ==" crossorigin="anonymous"></script>

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
            width: "30rem",
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
                    url: "<?= base_url() ?>/api/insertMethod",
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
                url: "<?= base_url() ?>/api/updateMethod",
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
                url: "<?= base_url() ?>/api/deleteMethod",
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

        function saveConfig()
        {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>/api/saveConfig",
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
                    url: "<?= base_url() ?>/api/uploadCSV",
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