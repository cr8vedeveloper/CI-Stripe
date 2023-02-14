<?= $this->extend('layout/default') ?>

<?= $this->section('page_title') ?>
    <title>ねね丸シート - 取引履歴</title>
<?= $this->endSection() ?>

<?= $this->section('addition_style') ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    
    <style>
        .nav-link:hover {
            background-color: #1E91D6;
        }

        .jsgrid {
            font-size: 80%;
        }

        #detailModal .jsgrid-grid-header, #detailModal .jsgrid-grid-body {
            overflow-y: auto;
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

        .jsgrid-row.row-win:not(.jsgrid-selected-row) > .jsgrid-cell {
            background-color: #ffdfdf;
        }

        .jsgrid-alt-row.row-win:not(.jsgrid-selected-row) > .jsgrid-cell {
            background-color: #ffdcdc;
        }

        .card {
            border: 1px solid rgba(0,0,0,.125) !important;
            border-radius: 0.25rem !important;
        }

        .bootstrap-select > .dropdown-toggle {
            background-color: #FFF;
            color: #000;
            border: 1px solid #ced4da;
        }

        .dropdown-item {
            font-size: 0.825rem;
        }

        #paste {
            outline: 0px solid transparent;

            border: 1px dashed rgba(0,0,0,.2);
            border-radius: .3rem;
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAAARCAMAAABth1fPAAAAflBMVEUAAABzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3NycnJzc3Nzc3Nzc3NycnJzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3NycnJzc3Nzc3Nzc3PcgiWWAAAAKXRSTlMAllbZuqZFefBw4znIwdKHP/bngR9ns2MyC+urmUosJROfXo7ezARRGURfYOMAAANeSURBVEjH5ZRZspswEEUvIGbEYDCDmcFT73+DQRLwTB6ppPKXyvlA1S5ZOuorwH9AFgN2it9hxfgFU6fG9o2/wv8sYu2AWLoxENM9H5sGG4aLjTFcuALIayhmjiPUrqOLT1Jr29NqX7pkOqs7GpD1XRlbr1eJMpJcDDX2ABw7C+e+j0nfT0EZNkzWdclB0AwBlyd82hqQ4FPQ9KBwNt/kzhnLTfNCdFZfHeCWGMaD83AP8pFjo6UpuS39Cy6sXhwiShKHJJ4SBJSgOJMQZzU46eVE9trj8SD40A6COzEzrtVZrZn4JLTBGHNuywOaIRLm80y6Hjm6bhNQZdminEmkoBOGSvC+XokgMmcsFHfVQPJzQ0KGYS9eOmAJnGZ5YMe8YuGkZseDeDaoKR5hYTrQbkBPDBZZlu1YlkvqDFuYun0WcRgFcqxIbl9TbClIszIMlOG5+Ro1fk+ofxPURcSuEqwpgM/ChEzH4xwLLo13uuv+SFSriI+CHm8hMcTKE1EMyKxITOup2uYV+CNu8TdBPt68MZCCLYUBnpPHA2gc/hPQibUDTCJTNshcrm9y9W3bCG3blid2PrKpKFoER28X9B2sGJsg21p0Wj+pA6rrQVCbHo9JRWykQWBS9NaTsqCJGhTiqpecqN/e4r5Prq5jLoQyW55/GGgBFsGBZiEojNrL/iKugra39fS8FoJa/auIB/CgQjY6rHmT06o7fqW0SrpNEBCCcmkpyNbFKlLZiCGlcpkmjEp6lhYElxYS7mLlvL5Zy1z/IOj2j7xP1R0EC3S2/JiGyFNIXuL2k78KeuN4FEzXOFx674LwolUwo1J9zQYq1x33RM9rY17mWgdBxSqYB9cW/iOkZ7suWaf4Enylhdv0u+AXT8PEJqhwCtlXM1RJGlA0l6IcKjyH3m+zk9psxDfMjsvyVehScEMJmgFeedCKz0PNAfWPL64JJhq+C/rmZfhJ8FbIBFU3LNqTTDltaLIODrUrTjIxz7vfvXERvHwgBMcgCl5ZJhQGTxr6ntHMaZpGbEbmvACWuyRZBUs9YqR1+BQsdJcmub18S0ay8cHQl937eV73P31mGn+nFoKN2JXfQrF6V6nrr9vzPKeuq6u4u9S9yw7ytfOBVryBg2AYsFTVcg3Txz/CDzY4Tn21xI3CAAAAAElFTkSuQmCC);
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    
    <div class="card mb-1">
        <div class="card-body">
            <h5 class="card-title">フィルター</h5>
            <form class="card-text" method="post" onsubmit="$('#button-submit').html('読込中...').prop('disabled',true);">

                <div class="form-inline mb-1">

                    <div class="input-group input-group-sm mr-1">
                        <input name="date-from" id="date-from" type="date" class="form-control form-control-sm" style="width:9rem">
                        <div class="input-group-prepend input-group-append">
                            <span class="input-group-text">～</span>
                        </div>
                        <input name="date-to" id="date-to" type="date" class="form-control form-control-sm" style="width:9rem">
                    </div>

                    <div class="btn-group btn-group-sm mr-2" role="group">
                        <button type="button" class="btn btn-sm btn-secondary" onclick="changeDates(0)">今週</button>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="changeDates(1)">今月</button>
                    </div>

                </div>

                <div class="form-inline mb-1">

                    <select name="weekday[]" id="weekday" class="form-control form-control-sm selectpicker mr-2" style="width:6rem" multiple title="曜日">
                        <option value="0">月
                        <option value="1">火
                        <option value="2">水
                        <option value="3">木
                        <option value="4">金
                        <option value="5">土
                        <option value="6">日
                    </select>

                    <div class="input-group input-group-sm mr-1">
                        <select name="time-from" id="time-from" class="form-control form-control-sm">
                            <option value="">
                            <option value="0">0時
                            <option value="1">1時
                            <option value="2">2時
                            <option value="3">3時
                            <option value="4">4時
                            <option value="5">5時
                            <option value="6">6時
                            <option value="7">7時
                            <option value="8">8時
                            <option value="9">9時
                            <option value="10">10時
                            <option value="11">11時
                            <option value="12">12時
                            <option value="13">13時
                            <option value="14">14時
                            <option value="15">15時
                            <option value="16">16時
                            <option value="17">17時
                            <option value="18">18時
                            <option value="19">19時
                            <option value="20">20時
                            <option value="21">21時
                            <option value="22">22時
                            <option value="23">23時
                        </select>
                        <div class="input-group-prepend input-group-append">
                            <span class="input-group-text">～</span>
                        </div>
                        <select name="time-to" id="time-to" class="form-control form-control-sm">
                            <option value="">
                            <option value="0">0時
                            <option value="1">1時
                            <option value="2">2時
                            <option value="3">3時
                            <option value="4">4時
                            <option value="5">5時
                            <option value="6">6時
                            <option value="7">7時
                            <option value="8">8時
                            <option value="9">9時
                            <option value="10">10時
                            <option value="11">11時
                            <option value="12">12時
                            <option value="13">13時
                            <option value="14">14時
                            <option value="15">15時
                            <option value="16">16時
                            <option value="17">17時
                            <option value="18">18時
                            <option value="19">19時
                            <option value="20">20時
                            <option value="21">21時
                            <option value="22">22時
                            <option value="23">23時
                        </select>
                    </div>

                    <div class="btn-group btn-group-sm mr-1" role="group">
                        <button type="button" class="btn btn-sm btn-secondary" onclick="changeHours(9,17)">東京</button>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="changeHours(16,2)">ロンドン</button>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="changeHours(21,6)">NY</button>
                    </div>

                </div>
                
                <div class="form-inline">

                    <select name="result[]" id="result" class="form-control form-control-sm selectpicker mr-1" multiple title="勝敗">
                        <option value="1">勝ち
                        <option value="2">負け
                        <option value="3">転売
                    </select>

                    <select name="currency[]" id="currency" class="form-control form-control-sm selectpicker mr-1" multiple title="通貨">
                        <?php foreach ($currencies as $r): ?>
                        <option value="<?= $r['id'] ?>"><?= $r['name'] ?>
                        <?php endforeach ?>
                    </select>

                    <select name="method[]" id="method" class="form-control form-control-sm selectpicker mr-1" multiple title="手法">
                        <?php foreach ($methods as $r): ?>
                        <option value="<?= $r['id'] ?>"><?= $r['name'] ?>
                        <?php endforeach ?>
                    </select>

                    <select name="mode[]" id="mode" class="form-control form-control-sm selectpicker mr-1" multiple title="取引種">
                        <option value="1">1時間
                        <option value="2">1日
                        <option value="3">30秒
                        <option value="4">1分
                        <option value="5">3分
                        <option value="6">5分
                        <option value="7">15分短
                        <option value="8">15分中
                        <option value="9">15分長
                    </select>

                    <select name="deal[]" id="deal" class="form-control form-control-sm selectpicker mr-1" multiple title="方向">
                        <option value="1">HIGH
                        <option value="2">LOW
                    </select>

                    <select name="evaluation[]" id="evaluation" class="form-control selectpicker form-control-sm mr-3" multiple title="評価">
                        <option value="3">良い
                        <option value="2">普通
                        <option value="1">悪い
                    </select>

                    <button id="button-submit" type="submit" class="btn btn-sm btn-primary mr-2">フィルター</button>
                    <button type="reset" class="btn btn-sm btn-secondary" onclick="$('.selectpicker').selectpicker('deselectAll');">クリア</button>

                </div>

            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title row">
                <div class="col d-flex align-items-center">取引履歴</div>
                <div class="col-auto"><button class="btn btn-sm btn-secondary" onclick="downloadCSV()">CSVダウンロード</button></div>
            </h5>
            <div id="jsGrid" class="card-text"></div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
    
    <div id="detailModal" class="modal px-3" tabindex="-1" role="dialog">
        <div class="modal-dialog mx-auto" role="document" style="width:100%; max-width:1200px">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="jsgrid">
                        <div class="jsgrid-grid-header jsgrid-header-scrollbar">
                            <table class="jsgrid-table">
                                <tr class="jsgrid-header-row">
                                    <th class="jsgrid-header-cell jsgrid-align-center" style="width:8rem">日時</th>
                                    <th class="jsgrid-header-cell jsgrid-align-center" style="width:3rem">曜日</th>
                                    <th class="jsgrid-header-cell jsgrid-align-center" style="width:3rem">勝敗</th>
                                    <th class="jsgrid-header-cell jsgrid-align-center" style="width:3rem">取引</th>
                                    <th class="jsgrid-header-cell jsgrid-align-center" style="width:4rem">通貨</th>
                                    <th class="jsgrid-header-cell jsgrid-align-center" style="width:4rem">手法</th>
                                    <th class="jsgrid-header-cell jsgrid-align-center" style="width:3rem">取引種</th>
                                    <th class="jsgrid-header-cell jsgrid-align-right" style="width:4rem">BET額</th>
                                    <th class="jsgrid-header-cell jsgrid-align-right" style="width:4rem">pip差</th>
                                    <th class="jsgrid-header-cell jsgrid-align-right" style="width:4rem">損益</th>
                                    <th class="jsgrid-header-cell jsgrid-align-center" style="width:3rem">評価</th>
                                </tr>
                            </table>
                        </div>
                        <div class="jsgrid-grid-body jsgrid-header-scrollbar">
                            <table class="jsgrid-table">
                                <tr class="jsgrid-row" id="detail">
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-8 text-center">
                            <div id="paste" contenteditable="true" style="min-width:300px; min-height:300px; color:transparent; caret-color:transparent;"></div>
                            <div id="image" style="display:flex; align-items:center; justify-content:center; min-width:300px; min-height:300px;">
                                <img style="max-width:100%; max-height:600px">
                            </div>
                            <button id="delete-image" class="btn btn-sm btn-secondary mt-2" onclick="deleteNoteImage()">画像を削除</button>
                        </div>
                        <div class="col-4">
                            <textarea id="note" class="form-control form-control-sm" style="width:100%; height:100%; min-width:300px; min-height:300px;" placeholder="メモ"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-sm btn-primary" onclick="saveNote()">保存</button>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div>削除してもよろしいでしょうか？</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteTrade()">削除</button>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('addition_script') ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js" integrity="sha512-blBYtuTn9yEyWYuKLh8Faml5tT/5YPG0ir9XEABu5YCj7VGr2nb21WPFT9pnP4fcC3y0sSxJR1JqFTfTALGuPQ==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
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
            sorting: true,
            paging : false,
            confirmDeleting: false,

            data: <?= json_encode($trades) ?>,

            fields: [
                { name: "id", visible: false },
                { name: "entered_at", title: "日時", type: "datetimeField", align: "center", width: "8rem", validate: "required" },
                { name: "weekday", title: "曜日", type: "select", items: [
                        { Id: "0", Name: "月" },
                        { Id: "1", Name: "火" },
                        { Id: "2", Name: "水" },
                        { Id: "3", Name: "木" },
                        { Id: "4", Name: "金" },
                        { Id: "5", Name: "土" },
                        { Id: "6", Name: "日" },
                    ],
                    valueField: "Id", textField: "Name", editing: false, align: "center", width: "3rem" },
                { name: "result", title: "勝敗", type: "select", items: [
                        { Id: "", Name: "" },
                        { Id: "1", Name: "勝ち" },
                        { Id: "2", Name: "負け" },
                        { Id: "3", Name: "転売" },
                    ],
                    valueField: "Id", textField: "Name", align: "center", width: "3rem" },
                { name: "direction", title: "方向", type: "select", items: [
                        { Id: "", Name: "" },
                        { Id: "1", Name: "HIGH" },
                        { Id: "2", Name: "LOW" },
                    ],
                    valueField: "Id", textField: "Name",  align: "center", width: "3rem" },
                { name: "currency", title: "通貨", type: "select", items: [
                        { Id: "", Name: "" },
                        <?php foreach ($currencies as $r): ?>
                        { Id: "<?= $r['id'] ?>", Name: "<?= $r['name'] ?>" },
                        <?php endforeach ?>
                    ],
                    valueField: "Id", textField: "Name", align: "center", width: "4rem" },
                { name: "method", title: "手法", type: "select", items: [
                        { Id: "", Name: "" },
                        <?php foreach ($methods as $r): ?>
                        { Id: "<?= $r['id'] ?>", Name: "<?= $r['name'] ?>" },
                        <?php endforeach ?>
                    ],
                    valueField: "Id", textField: "Name", align: "center", width: "4rem" },
                { name: "mode", title: "取引種", type: "select", items: [
                        { Id: "", Name: "" },
                        { Id: "1", Name: "1時間" },
                        { Id: "2", Name: "1日" },
                        { Id: "3", Name: "30秒" },
                        { Id: "4", Name: "1分" },
                        { Id: "5", Name: "3分" },
                        { Id: "6", Name: "5分" },
                        { Id: "7", Name: "15分短" },
                        { Id: "8", Name: "15分中" },
                        { Id: "9", Name: "15分長" },
                    ],
                    valueField: "Id", textField: "Name",  align: "center", width: "3rem" },
                { name: "bet", title: "BET額", type: "number", align: "right", width: "4rem" },
                { name: "pips", title: "pip差", type: "number", align: "right", width: "4rem" },
                { name: "profit", title: "損益", type: "number", align: "right", width: "4rem" },
                { name: "evaluation", title: "評価", type: "select", items: [
                        { Id: "", Name: "" },
                        { Id: "1", Name: "悪い" },
                        { Id: "2", Name: "普通" },
                        { Id: "3", Name: "良い" },
                    ],
                    valueField: "Id", textField: "Name", align: "center", width: "3rem" },
                {
                    headerTemplate: function() {
                        return "";
                    },
                    itemTemplate: function(_, item) {
                        return $("<span>").css("white-space", "nowrap").append(
                            $("<button>").attr("type", "button").addClass("btn btn-outline-secondary btn-sm mr-1").text("詳細")
                                .on("click", function () {
                                    selectedItem = item;
                                    loadNote();
                                }),
                            $("<button>").attr("type", "button").addClass("btn btn-outline-secondary btn-sm").text("削除")
                                .on("click", function () {
                                    selectedItem = item;
                                    $("#deleteModal").modal("show");
                                })
                        );
                    },
                    align: "center",
                    width: "4rem",
                    sorting: false,
                },
            ],

            rowClass: function(item) {
                if (item["result"] == "1") return "row-win";
            },

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
                updateTrade(args.item);
            },
            invalidNotify: function(args) {
            }
        });


        function updateTrade(data)
        {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>/api/updateTrade",
                data: data,
            })
            .done(function () {
                updateTotalBalance();
            });
        }

        function deleteTrade()
        {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>/api/deleteTrade",
                data: {
                    id: selectedItem["id"],
                },
            })
            .done(function () {
                $("#jsGrid").jsGrid("deleteItem", selectedItem);
                $("#deleteModal").modal("hide");
                updateTotalBalance();
            });
        }

        function loadNote()
        {
            imageData = "noUpdate";

            $("#detail").html($("#jsGrid").jsGrid("rowByItem", selectedItem).html());
            $("#detail > td:last").remove();
            
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>/api/loadNote",
                data: {
                    id: selectedItem["id"],
                },
                dataType: "json",
            })
            .done(function (data) {
                $("#note").val(data["note"]);
                if (data["image"] != "") {
                    $("#paste").hide();
                    $("#image, #delete-image").show();
                    $("#image > img").prop("src", data["image"]);
                }
                else {
                    $("#paste").show();
                    $("#image, #delete-image").hide();
                }
                $("#detailModal").modal("show");
            });
        }

        function saveNote()
        {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>/api/saveNote",
                data: {
                    id: selectedItem["id"],
                    note: $("#note").val(),
                    image: imageData,
                },
                dataType: "json",
            })
            .done(function () {
                $("#detailModal").modal("hide");
                $("#note").val("");
                $("#paste").show();
                $("#image, #delete-image").hide();
                imageData = "";
            });
        }

        function deleteNoteImage()
        {
            $("#paste").show();
            $("#image, #delete-image").hide();
            imageData = "";
        }

        var imageData = "";

        $("#paste").on("paste", function(e) {
            var items = (event.clipboardData || event.originalEvent.clipboardData).items;
            for (var i = 0; i < items.length; i++) {
                if (items[i].type.indexOf("image") === 0) {
                    blob = items[i].getAsFile();
                    if (blob !== null) {
                        var blobURL = URL.createObjectURL(blob);
                        $("#paste").hide();
                        $("#image, #delete-image").show();
                        $("#image > img").prop("src", blobURL);
                        var reader = new FileReader();
                        reader.onloadend = function() {
                            imageData = reader.result;
                        }
                        reader.readAsDataURL(blob); 
                    }
                }
            }
            return false;
        });

        $("#paste").on("drop", function(e) {
            e = e.originalEvent ? e.originalEvent : e;
            e.stopPropagation();
            e.preventDefault();

            if (e.dataTransfer.files[0].size > 1024 * 1024)
            {
                alert("画像サイズが大きすぎます");
                return false;
            }

            if (e.dataTransfer.files[0].type.indexOf('image/') != 0)
            {
                alert("画像ファイルではありません");
                return false;
            }

            var reader = new FileReader();
            reader.onloadend = function() {
                imageData = reader.result;
                $("#paste").hide();
                $("#image, #delete-image").show();
                $("#image > img").prop("src", reader.result);
            }
            reader.readAsDataURL(e.dataTransfer.files[0]);
        });


        function changeDates(mode) {
            if (mode == 0) {
                var date = new Date();
                date.setDate(date.getDate() - (date.getDay() == 0 ? 6 : date.getDay() - 1));
                $("#date-from").val(date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2));
                $("#date-to").val("");
            }
            if (mode == 1) {
                var date = new Date();
                date.setDate(1);
                $("#date-from").val(date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2));
                $("#date-to").val("");
            }
            return false;
        }

        function changeHours(from, to) {
            $("#time-from").val(from);
            $("#time-to").val(to);
            return false;
        }

        function downloadCSV() {
            var fields = $("#jsGrid").jsGrid("option", "fields");
            var data = $("#jsGrid").jsGrid("option", "data");
            console.log(fields);
            var CSV =
                "日時," +
                "曜日," +
                "勝敗," +
                "方向," +
                "通貨," +
                "手法," +
                "取引種," +
                "BET額," +
                "pip差," +
                "損益," +
                "評価\r\n"
            ;
            for (var r of data) {

                CSV +=
                    r["entered_at"] + "," +
                    (fields[2]["items"].find((v) => v.Id == r["weekday"])?.Name ?? '') + "," +
                    (fields[3]["items"].find((v) => v.Id == r["result"])?.Name ?? '') + "," +
                    (fields[4]["items"].find((v) => v.Id == r["direction"])?.Name ?? '') + "," +
                    (fields[5]["items"].find((v) => v.Id == r["currency"])?.Name ?? '') + "," +
                    "\"" + (fields[6]["items"].find((v) => v.Id == r["method"])?.Name.replace(/"/g, "\"") ?? '') + "\"," +
                    (fields[7]["items"].find((v) => v.Id == r["mode"])?.Name ?? '') + "," +
                    r["bet"] + "," +
                    r["pips"] + "," +
                    r["profit"] + "," +
                    (fields[11]["items"].find((v) => v.Id == r["mode"])?.Name ?? '') + "\r\n"
                ;
            }
            
            var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
            var link = document.createElement("a");
            link.href = URL.createObjectURL(new Blob([new Uint8Array([0xEF, 0xBB, 0xBF]), CSV], {type: "application/octet-stream"}));
            link.style = "visibility:hidden";
            link.download = "nenemaru_" + new Date().toLocaleString("UTC",{year:"numeric",month:"2-digit",day:"2-digit",hour:"2-digit",minute:"2-digit",second:"2-digit"}).replace(/[ \/\-:]/g, "_") + ".csv";
            document.body.appendChild(link);
            link.click();
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