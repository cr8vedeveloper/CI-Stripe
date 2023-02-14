<?= $this->extend('layout/default') ?>

<?= $this->section('page_title') ?>
    <title>ねね丸シート - 分析</title>
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

    .jsgrid-grid-header, .jsgrid-grid-body {
        overflow-y: auto;
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

    .first-column {
        background-color: #f9f9f9 !important;
        border-color: #e9e9e9 !important;
        font-weight: 700 !important;
    }

    .jsgrid-row:not(.jsgrid-selected-row) > .cell-max {
        background-color: #ffdfdf;
    }

    .jsgrid-alt-row:not(.jsgrid-selected-row) > .cell-max {
        background-color: #ffdcdc;
    }

    .jsgrid-row:not(.jsgrid-selected-row) > .cell-min {
        background-color: #f0f8ff;
    }

    .jsgrid-alt-row:not(.jsgrid-selected-row) > .cell-min {
        background-color: #edf4ff;
    }

    .card-columns {
        column-gap: 0.25rem;
    }

    .card-columns .card {
        margin-bottom: 0.25rem;
    }

    .bootstrap-select > .dropdown-toggle {
        background-color: #FFF;
        color: #000;
        border: 1px solid #ced4da;
    }

    .dropdown-item {
        font-size: 0.825rem;
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

    <div class="card mb-1">
        <div class="card-body" style="padding-bottom:0.5rem">
            <h5 class="card-title">総計</h5>
            <div class="card-text">
                <div class="row">
                    <div class="col-3">
                        <table class="table table-sm" style="font-size:90%; margin-left:1rem">
                            <tr>
                                <td scope="row" style="border:0">回数</th>
                                <td class="text-right" style="border:0"><?= $total ?></td>
                            </tr>
                            <tr>
                                <td scope="row">収支</th>
                                <td class="text-right"><?= $profitTotal ?></td>
                            </tr>
                            <tr>
                                <td scope="row">勝数</th>
                                <td class="text-right"><?= $winTotal ?></td>
                            </tr>
                            <tr>
                                <td scope="row">負数</th>
                                <td class="text-right"><?= $loseTotal ?></td>
                            </tr>
                            <tr>
                                <td scope="row">勝率</th>
                                <td class="text-right"><?= $average ?></td>
                            </tr>
                            <tr>
                                <td scope="row">PF</th>
                                <td class="text-right"><?= $pf ?></td>
                            </tr>
                            <tr>
                                <td scope="row">勝け平均pips</th>
                                <td class="text-right"><?= $averageWinPips ?></td>
                            </tr>
                            <tr>
                                <td scope="row">負け平均pips</th>
                                <td class="text-right"><?= $averageLosePips ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-9">
                        <div id="profit-chart" style="width:100%; height:100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-columns">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">時間別</h5>
                <div id="jsGrid-hour" class="card-text"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">曜日別</h5>
                <div id="jsGrid-week" class="card-text"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">手法別</h5>
                <div id="jsGrid-method" class="card-text"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">方向別</h5>
                <div id="jsGrid-direction" class="card-text"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">通貨別</h5>
                <div id="jsGrid-currency" class="card-text"></div>
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

    var INF = Infinity;

    var averageField = function(config) {
        jsGrid.TextField.call(this, config);
    };
    averageField.prototype = new jsGrid.TextField({
        sorter: function(s1, s2) {
            if (s1 == s2) return 0;
            if (s2 == -1) return -1;
            return parseFloat(s1) - parseFloat(s2);
        },
    });
    jsGrid.fields.averageField = averageField;

    $("#jsGrid-hour").jsGrid({
        width: "100%",
        height: "auto",

        editing: false,
        sorting: true,
        paging : false,
        confirmDeleting: false,

        data: <?= json_encode($hoursData) ?>,

        fields: [
            { name: "hour", title: "時間", type: "number", align: "center", width: "2rem", css:"first-column" },
            { name: "count", title: "回数", type: "number", align: "right", width: "2rem",
                cellRenderer: function(value, item) {
                    if (value == <?= $hoursMaxCount ?>) return $("<td>").addClass("cell-max").html(value);
                    if (value == <?= $hoursMinCount ?>) return $("<td>").addClass("cell-min").html(value);
                    return $("<td>").html(value);
                }
            },
            { name: "average", title: "勝率", type: "averageField", align: "right", width: "2rem",
                cellRenderer: function(value, item) {
                    if (value == -1) return $("<td>").html("--");
                    if (value == <?= $hoursMaxAverage ?>) return $("<td>").addClass("cell-max").html(value + "%");
                    if (value == <?= $hoursMinAverage ?>) return $("<td>").addClass("cell-min").html(value + "%");
                    return $("<td>").html(value + "%");
                }
            },
            { name: "profit", title: "損益", type: "number", align: "right", width: "2rem",
                cellRenderer: function(value, item) {
                    if (value == <?= $hoursMaxProfit ?>) return $("<td>").addClass("cell-max").html(value.toLocaleString());
                    if (value == <?= $hoursMinProfit ?>) return $("<td>").addClass("cell-min").html(value.toLocaleString());
                    return $("<td>").html(value.toLocaleString());
                }
            },
        ],
    });

    $("#jsGrid-week").jsGrid({
        width: "100%",
        height: "auto",

        editing: false,
        sorting: true,
        paging : false,
        confirmDeleting: false,

        data: <?= json_encode($weeksData) ?>,

        fields: [
            { name: "week", title: "曜日", type: "select", items: [
                    { Id: 0, Name: "月" },
                    { Id: 1, Name: "火" },
                    { Id: 2, Name: "水" },
                    { Id: 3, Name: "木" },
                    { Id: 4, Name: "金" },
                    { Id: 5, Name: "土" },
                    { Id: 6, Name: "日" },
                ],
                valueField: "Id", textField: "Name", align: "center", width: "2rem", css:"first-column" },
            { name: "count", title: "回数", type: "number", align: "right", width: "2rem",
                cellRenderer: function(value, item) {
                    if (value == <?= $weeksMaxCount ?>) return $("<td>").addClass("cell-max").html(value);
                    if (value == <?= $weeksMinCount ?>) return $("<td>").addClass("cell-min").html(value);
                    return $("<td>").html(value);
                }
            },
            { name: "average", title: "勝率", type: "averageField", align: "right", width: "2rem",
                cellRenderer: function(value, item) {
                    if (value == -1) return $("<td>").html("--");
                    if (value == <?= $weeksMaxAverage ?>) return $("<td>").addClass("cell-max").html(value + "%");
                    if (value == <?= $weeksMinAverage ?>) return $("<td>").addClass("cell-min").html(value + "%");
                    return $("<td>").html(value + "%");
                }
            },
            { name: "profit", title: "損益", type: "number", align: "right", width: "2rem",
                cellRenderer: function(value, item) {
                    if (value == <?= $weeksMaxProfit ?>) return $("<td>").addClass("cell-max").html(value.toLocaleString());
                    if (value == <?= $weeksMinProfit ?>) return $("<td>").addClass("cell-min").html(value.toLocaleString());
                    return $("<td>").html(value.toLocaleString());
                }
            },
        ],
    });

    $("#jsGrid-currency").jsGrid({
        width: "100%",
        height: "auto",

        editing: false,
        sorting: true,
        paging : false,
        confirmDeleting: false,

        data: <?= json_encode($currenciesData) ?>,

        fields: [
            { name: "currency", title: "通貨", type: "text", align: "center", width: "3rem", css:"first-column" },
            { name: "count", title: "回数", type: "number", align: "right", width: "2rem",
                cellRenderer: function(value, item) {
                    if (value == <?= $currenciesMaxCount ?>) return $("<td>").addClass("cell-max").html(value);
                    if (value == <?= $currenciesMinCount ?>) return $("<td>").addClass("cell-min").html(value);
                    return $("<td>").html(value);
                }
            },
            { name: "average", title: "勝率", type: "averageField", align: "right", width: "2rem",
                cellRenderer: function(value, item) {
                    if (value == -1) return $("<td>").html("--");
                    if (value == <?= $currenciesMaxAverage ?>) return $("<td>").addClass("cell-max").html(value + "%");
                    if (value == <?= $currenciesMinAverage ?>) return $("<td>").addClass("cell-min").html(value + "%");
                    return $("<td>").html(value + "%");
                }
            },
            { name: "profit", title: "損益", type: "number", align: "right", width: "2rem",
                cellRenderer: function(value, item) {
                    if (value == <?= $currenciesMaxProfit ?>) return $("<td>").addClass("cell-max").html(value.toLocaleString());
                    if (value == <?= $currenciesMinProfit ?>) return $("<td>").addClass("cell-min").html(value.toLocaleString());
                    return $("<td>").html(value.toLocaleString());
                }
            },
        ],
    });

    $("#jsGrid-method").jsGrid({
        width: "100%",
        height: "auto",

        editing: false,
        sorting: true,
        paging : false,
        confirmDeleting: false,

        data: <?= json_encode($methodsData) ?>,

        fields: [
            { name: "method", title: "手法", type: "text", align: "center", width: "3rem", css:"first-column" },
            { name: "count", title: "回数", type: "number", align: "right", width: "2rem",
                cellRenderer: function(value, item) {
                    if (value == <?= $methodsMaxCount ?>) return $("<td>").addClass("cell-max").html(value);
                    if (value == <?= $methodsMinCount ?>) return $("<td>").addClass("cell-min").html(value);
                    return $("<td>").html(value);
                }
            },
            { name: "average", title: "勝率", type: "averageField", align: "right", width: "2rem",
                cellRenderer: function(value, item) {
                    if (value == -1) return $("<td>").html("--");
                    if (value == <?= $methodsMaxAverage ?>) return $("<td>").addClass("cell-max").html(value + "%");
                    if (value == <?= $methodsMinAverage ?>) return $("<td>").addClass("cell-min").html(value + "%");
                    return $("<td>").html(value + "%");
                }
            },
            { name: "profit", title: "損益", type: "number", align: "right", width: "2rem",
                cellRenderer: function(value, item) {
                    if (value == <?= $methodsMaxProfit ?>) return $("<td>").addClass("cell-max").html(value.toLocaleString());
                    if (value == <?= $methodsMinProfit ?>) return $("<td>").addClass("cell-min").html(value.toLocaleString());
                    return $("<td>").html(value.toLocaleString());
                }
            },
        ],
    });

    $("#jsGrid-direction").jsGrid({
        width: "100%",
        height: "auto",

        editing: false,
        sorting: true,
        paging : false,
        confirmDeleting: false,

        data: <?= json_encode($directionsData) ?>,

        fields: [
            { name: "direction", title: "方向", type: "text", align: "center", width: "2rem", css:"first-column" },
            { name: "count", title: "回数", type: "number", align: "right", width: "2rem" },
            { name: "average", title: "勝率", type: "averageField", align: "right", width: "2rem",
                cellRenderer: function(value, item) {
                    if (value == -1) return $("<td>").html("--");
                    return $("<td>").html(value + "%");
                }
            },
            { name: "profit", title: "損益", type: "number", align: "right", width: "2rem",
                cellRenderer: function(value, item) {
                    return $("<td>").html(value.toLocaleString());
                }
            },
        ],
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
    <script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart'], 'language': 'ja'});
    google.charts.setOnLoadCallback(drawProfitChart);

    var profitChart;
    var profitChartData;
    var profitChartOptions = {
        curveType: 'function',
        legend: {position: 'none'},
        animation: {
            startup: true,
            duration: 500,
        },
        chartArea: {
            top: 20,
            height: "75%",
            right: 40,
            width: "85%",
        },
        series: {
        },
        hAxis: {
            format: 'YY/MM/dd',
            minorGridlines: {count: 0}
        },
    };

    function drawProfitChart() {
        profitChartData = google.visualization.arrayToDataTable([[{type:'date', label:'日付'},{type:'number', label:'収支'},{type:'string',role:'tooltip'}]].concat(<?= $jsonProfits ?>));
        profitChart = new google.visualization.LineChart(document.getElementById('profit-chart'));
        profitChart.draw(profitChartData, profitChartOptions);
    }

    $(window).on("resize", function() {
        profitChart.draw(profitChartData, profitChartOptions);
    });
    </script>

<?= $this->endSection() ?>
