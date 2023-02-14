<?= $this->extend('layout/default') ?>

<?= $this->section('page_title') ?>
    <title>ねね丸シート - HOME</title>
<?= $this->endSection() ?>

<?= $this->section('addition_style') ?>
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

        .jsgrid-edit-row input, .jsgrid-edit-row select {
            padding: 0;
        }

        .jsgrid-header-sort {
            cursor: default;
        }

        .jsgrid-header-sort:before {
            display: none;
        }

        .jsgrid-row.row-win:not(.jsgrid-selected-row) > .jsgrid-cell {
            background-color: #ffdfdf;
        }

        .jsgrid-alt-row.row-win:not(.jsgrid-selected-row) > .jsgrid-cell {
            background-color: #ffdcdc;
        }

        #input > .jsgrid-cell {
            background-color: #ffffff;
        }

        .card-deck {
            column-gap: 0.25rem;
        }

        .card-deck, .card-deck .card {
            margin-right: 0;
            margin-left: 0;
        }

        .is-invalid {
            padding-right: 0.5rem !important;
            background-image: none !important;
        }

        #paste, #new-paste {
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
    <div class="card-deck mb-1">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">現時間帯の勝率</h5>
                <div class="card-text form-inline">
                    <span id="winning-hour">--</span>時台
                    <select name="winning-currency" id="winning-currency" class="form-control form-control-sm mx-1">
                        <option value="">全通貨
                        <?php foreach ($currencies as $r): ?>
                        <option value="<?= $r['id'] ?>"><?= $r['name'] ?>
                        <?php endforeach ?>
                    </select>
                    の
                    <select name="winning-method" id="winning-method" class="form-control form-control-sm mx-1">
                        <option value="">全手法
                        <?php foreach ($methods as $r): ?>
                        <option value="<?= $r['id'] ?>"><?= $r['name'] ?>
                        <?php endforeach ?>
                    </select>
                    勝率は&nbsp;
                    <span id="winning-average">--</span>%
                    です。
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">本日の結果</h5>
                <div class="card-text">
                    取引回数 <span id="today-count">--</span>回
                    収支 <span id="today-profit">--</span>円
                    勝率 <span id="today-average">--</span>%
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-1">
        <div class="card-body">
            <h5 class="card-title">取引入力</h5>
            <div class="card-text">

                <div class="form-inline mb-2">
                    <input id="easy" type="text" class="form-control form-control-sm text-center mr-2" style="width:5rem; caret-color:transparent" placeholder="簡単登録">
                    <button id="button-insert" class="btn btn-sm btn-primary mr-2" style="width:5rem" onclick="insertTrade()">登録</button>
                    <span id="alert" class="small text-warning"></span>
                </div>

                <div class="jsgrid">
                    <div class="jsgrid-grid-header jsgrid-header-scrollbar">
                        <table class="jsgrid-table">
                            <tr class="jsgrid-header-row">
                                <th class="jsgrid-header-cell jsgrid-align-center" style="width:8rem">日時</th>
                                <th class="jsgrid-header-cell jsgrid-align-center" style="width:3rem">曜日</th>
                                <th class="jsgrid-header-cell jsgrid-align-center" style="width:3rem">勝敗</th>
                                <th class="jsgrid-header-cell jsgrid-align-center" style="width:3rem">方向</th>
                                <th class="jsgrid-header-cell jsgrid-align-center" style="width:4rem">通貨</th>
                                <th class="jsgrid-header-cell jsgrid-align-center" style="width:4rem; background-color:#ffdfdf">手法</th>
                                <th class="jsgrid-header-cell jsgrid-align-center" style="width:3rem">取引種</th>
                                <th class="jsgrid-header-cell jsgrid-align-right" style="width:4rem">BET額</th>
                                <th class="jsgrid-header-cell jsgrid-align-right" style="width:4rem">pip差</th>
                                <th class="jsgrid-header-cell jsgrid-align-right" style="width:4rem">損益</th>
                                <th class="jsgrid-header-cell jsgrid-align-center" style="width:3rem; background-color:#ffdfdf">評価</th>
                                <th class="jsgrid-header-cell jsgrid-align-right" style="width:4rem"></th>
                            </tr>
                        </table>
                    </div>
                    <div class="jsgrid-grid-body">
                        <table class="jsgrid-table">
                            <tr class="jsgrid-edit-row" id="input">
                                <td class="jsgrid-cell jsgrid-align-center" style="width: 8rem;">
                                    <input name="entered_at" id="entered_at" type="datetime-local" step="1" class="form-control form-control-sm text-center" value="<?= date('Y-m-d\TH:i:s') ?>">
                                </td>
                                <td class="jsgrid-cell jsgrid-align-center" style="width:3rem">
                                    <span id="weekday"></span>
                                </td>
                                <td class="jsgrid-cell jsgrid-align-center" style="width:3rem">
                                    <select name="result" id="result" class="form-control form-control-sm">
                                        <option value>
                                        <option value="1">勝ち
                                        <option value="2">負け
                                        <option value="3">転売
                                    </select>
                                </td>
                                <td class="jsgrid-cell jsgrid-align-center" style="width:3rem">
                                    <select name="direction" id="direction" class="form-control form-control-sm">
                                        <option value>
                                        <option value="1">HIGH
                                        <option value="2">LOW
                                    </select>
                                </td>
                                <td class="jsgrid-cell jsgrid-align-center" style="width:4rem">
                                    <select name="currency" id="currency" class="form-control form-control-sm">
                                        <option value>
                                        <?php foreach ($currencies as $r): ?>
                                        <option value="<?= $r['id'] ?>"><?= $r['name'] ?>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td class="jsgrid-cell jsgrid-align-center" style="width:4rem; background-color:#ffdfdf">
                                    <select name="method" id="method" class="form-control form-control-sm">
                                        <option value>
                                        <?php foreach ($methods as $r): ?>
                                        <option value="<?= $r['id'] ?>"><?= $r['name'] ?>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td class="jsgrid-cell jsgrid-align-center" style="width:3rem">
                                    <select name="mode" id="mode" class="form-control form-control-sm">
                                        <option value>
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
                                </td>
                                <td class="jsgrid-cell jsgrid-align-right" style="width:4rem">
                                    <input name="bet" id="bet" type="number" step="1000" min="0" class="form-control form-control-sm">
                                </td>
                                <td class="jsgrid-cell jsgrid-align-right" style="width:4rem">
                                    <input name="pips" id="pips" type="number" min="0" class="form-control form-control-sm">
                                </td>
                                <td class="jsgrid-cell jsgrid-align-right" style="width:4rem">
                                    <input name="profit" id="profit" type="number" step="50" class="form-control form-control-sm">
                                </td>
                                <td class="jsgrid-cell jsgrid-align-center" style="width:3rem; background-color:#ffdfdf">
                                    <select name="evaluation" id="evaluation" class="form-control form-control-sm">
                                        <option>
                                        <option value="3">良い
                                        <option value="2">普通
                                        <option value="1">悪い
                                    </select>
                                </td>
                                <td class="jsgrid-cell jsgrid-align-center" style="width:4rem">
                                    <span style="white-space: nowrap;">
                                        <button type="button" class="btn btn-outline-secondary btn-sm mr-1" onclick="openNote()">詳細</button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm invisible">削除</button>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="card mb-1">
        <div class="card-body">
            <h5 class="card-title">最近の取引</h5>
            <div id="jsGrid" class="card-text"></div>
        </div>
    </div>

    <div class="card mb-1">
        <div class="card-body" style="padding-bottom:0.5rem">
            <h5 class="card-title form-inline">
                <select name="target-month" id="target-month" class="form-control form-control-sm mr-2">
                    <?php foreach (range(0, 5) as $r): ?>
                    <option value="<?= date('Y-m', strtotime('-'.$r.'month')) ?>"><?= date('Y年n月', strtotime('-'.$r.'month')) ?>
                    <?php endforeach ?>
                </select>
                の総計
            </h5>
            <div class="card-text">
                <div class="row">
                    <div class="col-3">
                        <table class="table table-sm" style="font-size:90%; margin-left:1rem">
                            <tr>
                                <td scope="row" style="border:0">回数</th>
                                <td class="text-right" style="border:0" id="monthlyTotal">--</td>
                            </tr>
                            <tr>
                                <td scope="row">収支</th>
                                <td class="text-right" id="monthlyProfit">--</td>
                            </tr>
                            <tr>
                                <td scope="row">勝数</th>
                                <td class="text-right" id="monthlyWin">--</td>
                            </tr>
                            <tr>
                                <td scope="row">負数</th>
                                <td class="text-right" id="monthlyLose">--</td>
                            </tr>
                            <tr>
                                <td scope="row">勝率</th>
                                <td class="text-right" id="monthlyAverage">--</td>
                            </tr>
                            <tr>
                                <td scope="row">PF</th>
                                <td class="text-right" id="monthlyPF">--</td>
                            </tr>
                            <tr>
                                <td scope="row">勝け平均pips</th>
                                <td class="text-right" id="monthlyWinPips">--</td>
                            </tr>
                            <tr>
                                <td scope="row">負け平均pips</th>
                                <td class="text-right" id="monthlyLosePips">--</td>
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
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
    <div id="newNoteModal" class="modal px-3" tabindex="-1" role="dialog">
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
                                    <th class="jsgrid-header-cell jsgrid-align-center" style="width:3rem">方向</th>
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
                        <div class="jsgrid-grid-body">
                            <table class="jsgrid-table">
                                <tr class="jsgrid-row" id="new-detail">
                                    <td class="jsgrid-cell jsgrid-align-center" style="width:8rem"></td>
                                    <td class="jsgrid-cell jsgrid-align-center" style="width:3rem"></td>
                                    <td class="jsgrid-cell jsgrid-align-center" style="width:3rem"></td>
                                    <td class="jsgrid-cell jsgrid-align-center" style="width:3rem"></td>
                                    <td class="jsgrid-cell jsgrid-align-center" style="width:4rem"></td>
                                    <td class="jsgrid-cell jsgrid-align-center" style="width:4rem"></td>
                                    <td class="jsgrid-cell jsgrid-align-center" style="width:3rem"></td>
                                    <td class="jsgrid-cell jsgrid-align-right" style="width:4rem"></td>
                                    <td class="jsgrid-cell jsgrid-align-right" style="width:4rem"></td>
                                    <td class="jsgrid-cell jsgrid-align-right" style="width:4rem"></td>
                                    <td class="jsgrid-cell jsgrid-align-center" style="width:3rem"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-8 text-center">
                            <div id="new-paste" contenteditable="true" style="min-width:300px; min-height:300px; color:transparent; caret-color:transparent;"></div>
                            <div id="new-image" style="display:flex; align-items:center; justify-content:center; min-width:300px; min-height:300px;">
                            <img style="max-width:100%; max-height:600px">
                            </div>
                            <button id="new-delete-image" class="btn btn-sm btn-secondary mt-2" onclick="deleteNewNoteImage()">画像を削除</button>
                        </div>
                        <div class="col-4">
                            <textarea id="new-note" class="form-control form-control-sm" style="width:100%; height:100%; min-width:300px; min-height:300px;" placeholder="メモ"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">保存</button>
                </div>
            </div>
        </div>
    </div>

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
                                    <th class="jsgrid-header-cell jsgrid-align-center" style="width:3rem">方向</th>
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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script>

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
                console.log("AA")
                updateTrade(args.item);
            },
            invalidNotify: function(args) {
            }
        });
        $("#jsGrid").jsGrid("sort", {field: "id", order: "desc"});


        function insertTrade()
        {
            var invalid = false;

            $("#mode").removeClass("is-invalid");
            $("#direction").removeClass("is-invalid");

            if ($("#entered_at").val() == "") {
                invalid = true;
                $("#alert").html("日時が入力されていません。");
                $("#entered_at").addClass("is-invalid");
            }
            else {
                $("#entered_at").removeClass("is-invalid");
            }

            if (invalid == false)
            {
                $("#alert").html("");

                $("#button-insert").html("登録中...").prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>/api/insertTrade",
                    data: {
                        entered_at: $("#entered_at").val(),
                        result: $("#result").val(),
                        currency: $("#currency").val(),
                        method: $("#method").val(),
                        mode: $("#mode").val(),
                        direction: $("#direction").val(),
                        pips: $("#pips").val(),
                        bet: $("#bet").val(),
                        profit: $("#profit").val(),
                        evaluation: $("#evaluation").val(),
                    },
                    dataType: "json",
                })
                .done(function(data) {
                    $("#jsGrid").jsGrid("insertItem", data);
                    if ($("#jsGrid").jsGrid("_itemsCount") > 5) {
                        $("#jsGrid").jsGrid("deleteItem", $("#jsGrid").jsGrid("option", "data")[4]);
                    }
                    $("#jsGrid").jsGrid("sort", {field: "id", order: "desc"});

                    $("#pips").val("");
                    $("#bet").val("");
                    $("#profit").val("");
                    $("#evaluation").val("");

                    $("#winning-currency").change();
                    updateTodayResult();
                    updateTotalBalance();

                    $.ajax({
                        type: "POST",
                        url: "<?= base_url() ?>/api/saveNote",
                        data: {
                            id: data["id"],
                            note: $("#new-note").val(),
                            image: newImageData,
                        },
                        dataType: "json",
                    })
                    .done(function() {
                        clearNewNote();
                    });
                })
                .always(function() {
                    $("#button-insert").html("登録").prop("disabled", false);
                });
            }
        }

        function updateTrade(data)
        {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>/api/updateTrade",
                data: data,
            })
            .done(function() {
                $("#jsGrid").jsGrid("sort", {field: "id", order: "desc"});
                updateTodayResult();
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
            .done(function() {
                $("#jsGrid").jsGrid("deleteItem", selectedItem);
                $("#jsGrid").jsGrid("sort", {field: "id", order: "desc"});
                $("#deleteModal").modal("hide");
                updateTodayResult();
                updateTotalBalance();
            });
        }

        function openNote()
        {
            $("#new-detail > td:eq(0)").html($("#entered_at").val().replace("T", " "));
            $("#new-detail > td:eq(1)").html($("#weekday").html());
            $("#new-detail > td:eq(2)").html($("#result > option:selected").html());
            $("#new-detail > td:eq(3)").html($("#direction > option:selected").html());
            $("#new-detail > td:eq(4)").html($("#currency > option:selected").html());
            $("#new-detail > td:eq(5)").html($("#method > option:selected").html());
            $("#new-detail > td:eq(6)").html($("#mode > option:selected").html());
            $("#new-detail > td:eq(7)").html($("#bet").val());
            $("#new-detail > td:eq(8)").html($("#pips").val());
            $("#new-detail > td:eq(9)").html($("#profit").val());
            $("#new-detail > td:eq(10)").html($("#evaluation > option:selected").html());
            
            $("#newNoteModal").modal("show");
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
            .done(function(data) {
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
            .done(function() {
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

        function clearNewNote()
        {
            $("#new-note").val("");
            $("#new-paste").show();
            $("#new-image, #new-delete-image").hide();
            newImageData = "";
        }
        clearNewNote();

        function deleteNewNoteImage()
        {
            $("#new-paste").show();
            $("#new-image, #new-delete-image").hide();
            newImageData = "";
        }

        var imageData = "";
        var newImageData = "";

        $("#paste, #new-paste").on("paste", function(e) {
            var items = (event.clipboardData || event.originalEvent.clipboardData).items;
            for (var i = 0; i < items.length; i++) {
                if (items[i].type.indexOf("image") === 0) {
                    blob = items[i].getAsFile();
                    if (blob !== null) {
                        var blobURL = URL.createObjectURL(blob);

                        if (e.currentTarget.id == "paste") {
                            $("#paste").hide();
                            $("#image, #delete-image").show();
                            $("#image > img").prop("src", blobURL);
                            var reader = new FileReader();
                            reader.onloadend = function() {
                                imageData = reader.result;
                            }
                            reader.readAsDataURL(blob); 
                        }
                        else {
                            $("#new-paste").hide();
                            $("#new-image, #new-delete-image").show();
                            $("#new-image > img").prop("src", blobURL);
                            var reader = new FileReader();
                            reader.onloadend = function() {
                                newImageData = reader.result;
                            }
                            reader.readAsDataURL(blob); 
                        }

                    }
                }
            }
            return false;
        });

        $("#paste, #new-paste").on("drop", function(e) {
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

                if (e.srcElement.id == "paste") {
                    imageData = reader.result;
                    $("#paste").hide();
                    $("#image, #delete-image").show();
                    $("#image > img").prop("src", reader.result);
                }
                else {
                    newImageData = reader.result;
                    $("#new-paste").hide();
                    $("#new-image, #new-delete-image").show();
                    $("#new-image > img").prop("src", reader.result);
                }

            }
            reader.readAsDataURL(e.dataTransfer.files[0]);
        });


        var lastHour;
        setInterval(function() {

            var date = new Date();
            if (lastHour != date.getHours())
            {
                lastHour = date.getHours();
                $("#winning-hour").html(date.getHours());
                $("#winning-currency").change();
            }

        },1000);

        $("#easy").on("click", function() {
            if (navigator.clipboard) {
                navigator.clipboard.readText().then((text) => {
                    easyInput(text);
                    $("#easy")[0].blur();
                });
            }
        });

        $("#easy").on("paste", function() {
            setTimeout(function() {
                easyInput($("#easy").val());
                $("#easy").val("");
            },1);
        });

        $("#easy").on("input", function() {
            setTimeout(function() {
                easyInput($("#easy").val());
                $("#easy").val("");
            },1);
        });

        function easyInput(str) {
            if (m = str.match(/^\s*([\w/]*)\s*([\d\.]*)\s*([\d\/]* )?([\d:]*)\s*([\d\/]* )?([\d:]*)\s*(\S*)\s*([\d\.]*)\s*¥([\d,]*)\s*¥([\d,]*)/)) {
                var currency = m[1];
                var entry_rate = parseInt(m[2].replace(".", ""));
                var finish_rate = parseInt(m[8].replace(".", ""));
                var entry_date = m[3];
                var entry_time = m[4];
                var finish_date = m[5];
                var finish_time = m[6];
                var mode = m[7];
                var bet = parseInt(m[9].replace(/,/g, ""));
                var payout = parseInt(m[10].replace(/,/g, ""));

                if (mode == "転売済み") {
                    $("#entered_at").val(entry_date.trim().replaceAll(/\//g, "-") + "T" + entry_time);
                    $("#result").val(3);
                }
                else {
                    var date = new Date();
                    if (parseInt(entry_time.split(":")[0]) > date.getHours()) date.setDate(date.getDate() - 1);
                    $("#entered_at").val(date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2) + "T" + entry_time);

                    if (bet > payout) {
                        if (entry_rate == finish_rate) {
                            $("#alert").html("方向が自動判別できませんでした。");
                            $("#direction").addClass("is-invalid");
                        }
                        else {
                            $("#direction").val(entry_rate > finish_rate ? 1 : 2);
                        }
                        $("#result").val(2);
                    }
                    else {
                        if (entry_rate == finish_rate) {
                            $("#alert").html("方向が自動判別できませんでした。");
                            $("#direction").addClass("is-invalid");
                        }
                        else {
                            $("#direction").val(entry_rate < finish_rate ? 1 : 2);
                        }
                        $("#result").val(1);
                    }

                    var trade_sec = new Date(0, 0, finish_time.split(":")[0] < entry_time.split(":")[0] ? 1 : 0, finish_time.split(":")[0], finish_time.split(":")[1], finish_time.split(":")[2]) - new Date(0, 0, 0, entry_time.split(":")[0], entry_time.split(":")[1], entry_time.split(":")[2]);
                    if (finish_time.split(":")[2] == "00" && trade_sec > 59999 && trade_sec <= 900000) {
                        if      (trade_sec >  59999 && trade_sec <= 300000) $("#mode").val(7);
                        else if (trade_sec > 300000 && trade_sec <= 600000) $("#mode").val(8);
                        else if (trade_sec > 600000 && trade_sec <= 900000) $("#mode").val(9);

                        if
                        (
                            trade_sec ==    30000 ||
                            trade_sec ==    60000 ||
                            trade_sec ==   180000 ||
                            trade_sec ==   300000 ||
                            trade_sec ==  3600000 ||
                            trade_sec == 86400000
                        )
                        {
                            $("#alert").html("取引種が自動判別できませんでした。");
                            $("#mode").addClass("is-invalid");
                        }
                    }
                    else {
                        if      (trade_sec ==    30000) $("#mode").val(3);
                        else if (trade_sec ==    60000) $("#mode").val(4);
                        else if (trade_sec ==   180000) $("#mode").val(5);
                        else if (trade_sec ==   300000) $("#mode").val(6);
                        else if (trade_sec ==   900000) $("#mode").val(9);
                        else if (trade_sec ==  3600000) $("#mode").val(1);
                        else if (trade_sec == 86400000) $("#mode").val(2);
                    }
                }

                changeWeekDay();
                $("#currency option").filter(function(index){return $(this).text().trim() === currency}).prop("selected", true);
                $("#pips").val(Math.abs(entry_rate - finish_rate));
                $("#bet").val(bet);
                $("#profit").val(payout - bet);

                //clearNewNote();
            }
        }

        $("#entered_at").on("change", function(e) {
            changeWeekDay();
        });

        function changeWeekDay() {
            if ($("#entered_at").val() != "") {
                $("#weekday").html(["日","月","火","水","木","金","土"][new Date($("#entered_at").val()).getDay()]);
            }
            else {
                $("#weekday").html("");
            }
        }
        changeWeekDay();

        $("#winning-currency, #winning-method").on("change", function(e) {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>/api/getWinningAverage",
                data: {
                    hour: lastHour,
                    currency: $("#winning-currency").val(),
                    method: $("#winning-method").val(),
                },
                dataType: "json",
            })
            .done(function(data) {
                $("#winning-average").html(data["average"].toLocaleString());
            });
        });

        $("#target-month").on("change", function(e) {
            drawProfitChart();
        });


        function updateTodayResult() {
            $.ajax({
                type: "GET",
                url: "<?= base_url() ?>/api/getTodayResult",
                dataType: "json",
            })
            .done(function(data) {
                $("#today-count").html(data["count"].toLocaleString());
                $("#today-profit").html(data["profit"].toLocaleString());
                $("#today-average").html(data["average"]);
            });
        }
        updateTodayResult();

        function updateTotalBalance() {
            $.ajax({
                type: "GET",
                url: "<?= base_url() ?>/user/api/getTotalBalance",
                dataType: "json",
            })
            .done(function(data) {
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
            interpolateNulls: true,
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
                0: {pointSize: 3},
                1: {lineWidth: 1, color: '#ffaaaa', enableInteractivity:false},
            },
            hAxis: {
                format: 'd',
            },
        };

        function drawProfitChart() {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>/api/getChartData",
                data: {
                    month: $("#target-month").val(),
                },
                dataType: "json",
            })
            .done(function(data) {
                $("#monthlyTotal").html(data.data.total);
                $("#monthlyProfit").html(data.data.profitTotal);
                $("#monthlyWin").html(data.data.winTotal);
                $("#monthlyLose").html(data.data.loseTotal);
                $("#monthlyAverage").html(data.data.average);
                $("#monthlyPF").html(data.data.pf);
                $("#monthlyWinPips").html(data.data.averageWinPips);
                $("#monthlyLosePips").html(data.data.averageLosePips);

                profitChartData = google.visualization.arrayToDataTable([[{type:'date', label:'日付'},{type:'number', label:'収支'},{type:'string',role:'tooltip'},{type:'number'}]].concat(data.chart));
                profitChart = new google.visualization.LineChart(document.getElementById('profit-chart'));
                profitChart.draw(profitChartData, profitChartOptions);
            });
        }

        $(window).on("resize", function() {
            profitChart.draw(profitChartData, profitChartOptions);
        });
    </script>
<?= $this->endSection() ?>