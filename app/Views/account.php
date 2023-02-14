<?= $this->extend('layout/default') ?>

<?= $this->section('page_title') ?>
    <title>ねね丸シート - 入出金</title>
<?= $this->endSection() ?>

<?= $this->section('addition_style') ?>
    <style>
        .nav-link:hover {
            background-color: #1E91D6;
        }

        .jsgrid {
            font-size: 80%;
        }

        .jsgrid-grid-body {
            max-height: 90vh;
        }

        .jsgrid-cell {
            padding: 0.2rem;
        }

        .jsgrid-cell .btn-sm {
            font-size: 0.7rem;
            padding: 0.1rem 0.2rem;
        }

        .jsgrid-edit-row input, .jsgrid-edit-row select {
            padding: 0;
        }

        .jsgrid-header-sort {
            cursor: default;
        }

        .jsgrid-header-sort:before {
            display: none;
        }

        .card {
            border: 1px solid rgba(0,0,0,.125) !important;
            border-radius: 0.25rem !important;
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">入出金履歴</h5>
            <div class="card-text">

                <div class="form-inline mt-3 mb-3">

                    <input name="entered_at" id="entered_at" type="datetime-local" class="form-control form-control-sm mr-1" style="width:13rem" value="<?= date('Y-m-d\TH:i:s') ?>">
                    <input name="amount" id="amount" type="number" step="1000" min="0" class="form-control form-control-sm mr-3" style="width:9rem" autocomplete="off" placeholder="金額">
                    
                    <div class="form-check mr-2">
                        <input class="form-check-input" type="radio" name="type" id="type-in" value="1" checked>
                        <label class="form-check-label" for="type-in">入金</label>
                    </div>

                    <div class="form-check mr-2">
                        <input class="form-check-input" type="radio" name="type" id="type-out" value="2">
                        <label class="form-check-label" for="type-out">出金</label>
                    </div>

                    <div class="form-check mr-3">
                        <input class="form-check-input" type="radio" name="type" id="bonus" value="3">
                        <label class="form-check-label" for="bonus">ボーナス</label>
                    </div>

                    <button id="button-insert" class="btn btn-sm btn-primary ml-2 mr-3" style="width:5rem" onclick="insertAccount()">登録</button>

                </div>

                <div id="jsGrid"></div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
    <div id="deleteModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div>削除してもよろしいでしょうか？</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteAccount()">削除</button>
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


    var datetimeField = function(config) {
        jsGrid.TextField.call(this, config);
    };
    datetimeField.prototype = new jsGrid.TextField({
        editTemplate: function(value) {
            return this._editPicker = $("<input type=\"datetime-local\" step=\"1\">").val(value.replace(/ /, "T"));
        },
        editValue: function(value) {
            return this._editPicker.val().replace(/T/, " ");
        },
    });
    jsGrid.fields.datetimeField = datetimeField;

    var selectedItem;

    $("#jsGrid").jsGrid({
        width: "100%",
        height: "auto",

        editing: true,
        sorting: false,
        paging : false,
        confirmDeleting: false,

        data: <?= json_encode($accounts) ?>,

        fields: [
            { name: "id", visible: false },
            { name: "entered_at", title: "日時", type: "datetimeField", align: "center", width: "8rem" },
            { name: "in", title: "入金", type: "number", align: "right", width: "8rem" },
            { name: "out", title: "出金", type: "number", align: "right", width: "8rem" },
            { name: "bonus", title: "ボーナス", type: "number", align: "right", width: "8rem" },
            {
                headerTemplate: function() {
                    return "";
                },
                itemTemplate: function(_, item) {
                    return $("<button>").attr("type", "button").addClass("btn btn-outline-secondary btn-sm").text("削除")
                            .on("click", function () {
                                selectedItem = item;
                                $("#deleteModal").modal("show");
                            });
                },
                align: "center",
                width: "4rem",
                sorting: false,
            },
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
            updateAccount(args.item);
        },
        invalidNotify: function(args) {
        }
    });
    $("#jsGrid").jsGrid("sort", {field: "entered_at", order: "desc"});


    function insertAccount()
    {
        var invalid = false;

        if ($("#amount").val() == "")
        {
            invalid = true;
            $("#amount").addClass("is-invalid");
        }
        else
        {
            $("amount").removeClass("is-invalid");
        }

        if ($("#entered_at").val() == "")
        {
            invalid = true;
            $("#entered_at").addClass("is-invalid");
        }
        else
        {
            $("#entered_at").removeClass("is-invalid");
        }

        if (invalid == false)
        {
            $("#button-insert").html("登録中...").prop("disabled", true);
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>/api/insertAccount",
                data: {
                    entered_at: $("#entered_at").val(),
                    amount: $("#amount").val(),
                    type: $('input[name="type"]:checked').val(),
                },
                dataType: "json",
            })
            .done(function (data) {
                $("#jsGrid").jsGrid("insertItem", data);
                $("#jsGrid").jsGrid("sort", {field: "entered_at", order: "desc"});

                $("#amount").val("");

                updateTotalBalance();
            })
            .always(function() {
                $("#button-insert").html("登録").prop("disabled", false);
            });
        }
    }

    function updateAccount(data)
    {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/api/updateAccount",
            data: data,
        })
        .done(function () {
            $("#jsGrid").jsGrid("sort", {field: "entered_at", order: "desc"});

            updateTotalBalance();
        });
    }

    function deleteAccount()
    {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/api/deleteAccount",
            data: {
                id: selectedItem['id'],
            },
        })
        .done(function () {
            $("#jsGrid").jsGrid("deleteItem", selectedItem);
            $("#jsGrid").jsGrid("sort", {field: "entered_at", order: "desc"});
            $("#deleteModal").modal("hide");

            updateTotalBalance();
        });
    }

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
