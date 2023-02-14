<?= $this->extend('layout/default') ?>

<?= $this->section('page_title') ?>
    <title>ねね丸シート - 入出金</title>
<?= $this->endSection() ?>

<?= $this->section('addition_style') ?>
    <link rel="stylesheet" href="<?= base_url() ?>/public/css/stripe.css" />
    <style>
        .pricing-table{
        background-color: #eee;
        font-family: 'Montserrat', sans-serif;
        }

        .pricing-table .block-heading {
        padding-top: 50px;
        margin-bottom: 40px;
        text-align: center; 
        }

        .pricing-table .block-heading h2 {
        color: #3b99e0;
        }

        .pricing-table .block-heading p {
        text-align: center;
        max-width: 420px;
        margin: auto;
        opacity: 0.7; 
        }

        .pricing-table .heading {
        text-align: center;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1); 
        }

        .pricing-table .item {
        background-color: #ffffff;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.075);
        border-top: 2px solid #5ea4f3;
        padding: 30px;
        overflow: hidden;
        position: relative; 
        }
        .pricing-table .item:hover {
            margin-top: -10px;
        }

        .pricing-table .col-md-5:not(:last-child) .item {
        margin-bottom: 30px; 
        }

        .pricing-table .item button {
        font-weight: 600; 
        }

        .pricing-table .ribbon {
        width: 160px;
        height: 32px;
        font-size: 12px;
        text-align: center;
        color: #fff;
        font-weight: bold;
        box-shadow: 0px 2px 3px rgba(136, 136, 136, 0.25);
        background: #4dbe3b;
        transform: rotate(45deg);
        position: absolute;
        right: -42px;
        top: 20px;
        padding-top: 7px; 
        }

        .pricing-table .item p {
        text-align: center;
        margin-top: 20px;
        opacity: 0.7; 
        }

        .pricing-table .features .feature {
        font-weight: 600; }

        .pricing-table .features h4 {
        text-align: center;
        font-size: 18px;
        padding: 5px; 
        }

        .pricing-table .price h4 {
        margin: 15px 0;
        font-size: 45px;
        text-align: center;
        color: black;
        font-weight: bold; 
        }

        .pricing-table .btn-plan-select {
            text-align: center;
            margin: auto;
            font-weight: 600;
            padding: 9px 0; 
            transition-property: all;
            transition-duration: 0.3s;
            transition-delay: 0s;
        }
        .pricing-table .btn-plan-select:hover {
            background: linear-gradient(to bottom, #f2850c, #f26d0c) !important;
            color: white !important;
            width: 100% !important;
        }
        .pricing-content {
            display: flex;
            min-height: 9rem;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
#subscription-status th, #subscription-status td {
    text-align: center;
}
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="pricing-table">
        <?php if (isset($subscription_plan)) { ?>
            <div id="cancel_form">
            <form id="subscription-ctrl-form" data-subscription-id="<?= $stripe_subscription_id ?>" action="">
                <div class="page-loading" style="width: 100%; height: 100%;">
                    <div class="spinner-grow text-primary" role="status">
                        <span class="sr-only">読み込み中...</span>
                    </div>
                    <div class="spinner-grow text-secondary" role="status">
                        <span class="sr-only">読み込み中...</span>
                    </div>
                    <div class="spinner-grow text-success" role="status">
                        <span class="sr-only">読み込み中...</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <h3 style="text-align: center;">
                            現在のプラン
                        </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table id='subscription-status' class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="name">氏名</th>
                                <!-- <th scope="col" class="sort" data-sort="id">StripeID</th> -->
                                <th scope="col" class="" data-sort="cost">プラン</th>
                                <!-- <th scope="col" class="sort" data-sort="status">状態</th> -->
                                <!-- <th scope="col" data-sort="receipt-email">領収書メール</th> -->
                                <th scope="col" data-sort="next-update-date">次回更新日</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            <tr>
                                <th scope="row">
                                    <div class="media align-items-center" style="padding: 0.375rem;">
                                        <div class="media-body">
                                        <span class="name mb-0 text-sm"><?= $fullname ?></span>
                                        </div>
                                    </div>
                                </th>
                                <!-- <td class="id">
                                    <div style="padding: 0.375rem;">
                                        <a target="_blank" href="https://dashboard.stripe.com/test/subscriptions/<?= $stripe_subscription_id ?>">
                                        <?= $stripe_subscription_id ?>
                                        </a>
                                    </div>
                                </td> -->
                                <td class="cost">
                                    <div style="padding: 0.375rem;">
                                        <?= $plan_interval_count ?>ヶ月
                                    </div>
                                </td>
                                <!-- <td>
                                    <div style="padding: 0.375rem;">
                                        <span class="badge badge-dot mr-4">
                                            <i class="bg-warning"></i>
                                            <span class="status"><?= $status ?></span>
                                        </span>
                                    </div>
                                </td> -->
                                <!-- <td>
                                    <div style="padding: 0.375rem;">
                                        <a href="mailto:<?= $payer_email ?>">
                                        <?= $payer_email ?>
                                        </a>
                                    </div>
                                </td> -->
                                <td>
                                    <div style="padding: 0.375rem;text-align: center;">
                                        <?= date("Y-m-d", strtotime($plan_period_end)) ?>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-secondary" onclick="$('#confirm-cancel-modal').modal('show')" >お支払いを停止する</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
            </div>
            
            <hr />
        <?php } ?>
        <div class="container">
            <div class="block-heading">
                <h2 style="background: #0072BB;color: white;padding: 0.7rem;font-weight: bold;">自分に合ったプランを選ぼう</h2>
                <p>全てのプランでねね丸シートの全ての機能を使えます。</p>
                <!-- <?php if ((strtotime($_SESSION["expire_time"]) - time()) > 0) { ?>
                    <p>使用期間は
                    <?= floor((strtotime($_SESSION["expire_time"]) - time()) / 3600 / 24) ?> 日 
                    <?= floor((strtotime($_SESSION["expire_time"]) - time()) / 3600 % 24) ?> 時間
                    <?= floor((strtotime($_SESSION["expire_time"]) - time()) / 60 % 60) ?> 分
                    <?= floor((strtotime($_SESSION["expire_time"]) - time()) % 60) ?> 秒のままです。
                    </p>
                <?php } else { ?>
                    <p>使用期間が終了しました。私たちのサービスにお支払いください。</p>
                <?php } ?> -->
                <img style="height: 30px;" src="<?= base_url() ?>/public/images/credit-card.png" alt="" srcset="">
            </div>
            <div class="row justify-content-md-center">
                <div id="pricing-30" class="col-md-5 col-lg-4">
                    <div class="page-loading">
                        <div class="spinner-grow text-primary" role="status">
                            <span class="sr-only">読み込み中...</span>
                        </div>
                        <div class="spinner-grow text-secondary" role="status">
                            <span class="sr-only">読み込み中...</span>
                        </div>
                        <div class="spinner-grow text-success" role="status">
                            <span class="sr-only">読み込み中...</span>
                        </div>
                    </div>
                    <div class="item" style="background-color: transparent;box-shadow: none;border-top: none;">
                        <div class="heading">
                            <h3><span style="color: rgb(164,140,255)">1ヶ月</span>（30日間）</h3>
                        </div>
                        <div class="pricing-content">
                            <p>
                            お試しで使ってみたい方におすすめ <br/>他の取引記録サービスとの違いを 実感できます!<br/>
                            </p>
                        </div>
                        <div class="features">
                            <!-- <h4><span class="feature">期間</span> : <span class="value">30 日</span></h4> -->
                        </div>
                        <div class="price">
                            <h4>1500 円</h4>
                        </div>
                        <div style="width: 100%;height: 80px;">
                            
                        </div>
                        <button onclick="buyUsageTicket(30)" class="btn btn-block btn-primary btn-plan-select" type="button" style="margin: auto; width: 10rem;font-size: 1.5rem;background: #0072BB;">使ってみる</button>
                    </div>
                </div>
                <div id="pricing-90" class="col-md-5 col-lg-4">
                    <div class="page-loading">
                        <div class="spinner-grow text-primary" role="status">
                            <span class="sr-only">読み込み中...</span>
                        </div>
                        <div class="spinner-grow text-secondary" role="status">
                            <span class="sr-only">読み込み中...</span>
                        </div>
                        <div class="spinner-grow text-success" role="status">
                            <span class="sr-only">読み込み中...</span>
                        </div>
                    </div>
                    <div class="item" style="background-color: transparent;box-shadow: none;border-top: none;">
                        <div class="heading">
                            <h3><span style="color: rgb(164,140,255)">3ヶ月</span>（90日間）</h3>
                        </div>
                        <div class="pricing-content">
                            <p>
                            取引記録を初めて利用する方におすすめ <br/>取引記録のメリットを身をもって 感じることが出来ます!<br/>
                            </p>
                        </div>
                        <div class="features">
                            <!-- <h4><span class="feature">期間</span> : <span class="value">30 日</span></h4> -->
                        </div>
                        <div class="price">
                            <h4>4000 円</h4>
                        </div>
                        <div style="width: 100%;">
                            <p>1ヶ月で利用するより <br/><b style="color: blue;font-size: 1.5rem;">500円</b>お得!</p>
                        </div>
                        <button onclick="buyUsageTicket(90)" class="btn btn-block btn-primary btn-plan-select" type="button" style="margin: auto; width: 10rem;font-size: 1.5rem;background: #0072BB;">使ってみる</button>
                    </div>
                </div>
                <div id="pricing-180" class="col-md-5 col-lg-4">
                    <div class="page-loading">
                        <div class="spinner-grow text-primary" role="status">
                            <span class="sr-only">読み込み中...</span>
                        </div>
                        <div class="spinner-grow text-secondary" role="status">
                            <span class="sr-only">読み込み中...</span>
                        </div>
                        <div class="spinner-grow text-success" role="status">
                            <span class="sr-only">読み込み中...</span>
                        </div>
                    </div>
                    <div class="item" style="background-color: transparent;box-shadow: none;border-top: none;">
                        <div class="heading">
                            <h3><span style="color: rgb(164,140,255)">6ヶ月</span>（180日間）</h3>
                        </div>
                        <div class="pricing-content">
                            <p>
                            長く使って頂く方におすすめ <br/>一番お得なプランです!<br/>
                            </p>
                        </div>
                        <div class="features">
                            <!-- <h4><span class="feature">期間</span> : <span class="value">30 日</span></h4> -->
                        </div>
                        <div class="price">
                            <h4>7000 円</h4>
                        </div>
                        <div style="width: 100%;">
                            <p>1ヶ月で利用するより <br/><b style="color: blue;font-size: 1.5rem;">2000円</b>お得!</p>
                        </div>
                        <button onclick="buyUsageTicket(180)" class="btn btn-block btn-primary btn-plan-select" type="button" style="margin: auto; width: 10rem;font-size: 1.5rem;background: #0072BB;">使ってみる</button>
                    </div>
                </div>
            </div>

            <div class="row" style="padding-bottom: 4rem;">
                <div class="col-12" style="text-align: center;">
                    <a href="<?= base_url() ?>/terms-of-use" target="_blank">利用規約</a>
                </div>
                <div class="col-12" style="text-align: center;">
                    <a href="<?= base_url() ?>/privacy-policy" target="_blank">プライバシーポリシー</a> 
                </div>
                <div class="col-12" style="text-align: center;">
                    <a href="<?= base_url() ?>/specifiedTransaction" target="_blank">特定商取引法に基づく表記</a>
                </div>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>

    <!-- Pay Modal -->
    <div class="modal fade" id="pay-modal" tabindex="-1" aria-labelledby="pay-modal" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pay-modal-label">決済情報入力</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="removeAllLoading()">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"></a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"></a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false"></a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div id="stripe-message">
                                <!-- <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <h4 class="alert-heading">私たちのサービスへようこそ!</h4>
                                    <p>ストライプのアカウントをお持ちでない場合は、</p>
                                    <p><a href="#" target="_blank">ここに</a>をクリックしてストライプアカウントを作成してください。</p>
                                    <p>
                                        利用期間は 
                                        <?= date("Y", strtotime($_SESSION["expire_time"])) ?>年 
                                        <?= date("m", strtotime($_SESSION["expire_time"])) ?>月 
                                        <?= date("d", strtotime($_SESSION["expire_time"])) ?>日
                                        までです。
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div> -->
                            </div>
                            <form 
                                style="display: block;"
                                accept-charset="UTF-8" action="/" 
                                class="require-validation" 
                                data-cc-on-file="false" 
                                data-stripe-publishable-key="<?= getenv('pk_key') ?>" 
                                action="<?= base_url() ?>/payment/pricing-table"
                                id="payment-form" 
                                method="post"
                            >
                                <div class="page-loading" style="width: 100%; height: 100%;">
                                    <div class="spinner-grow text-primary" role="status">
                                        <span class="sr-only">読み込み中...</span>
                                    </div>
                                    <div class="spinner-grow text-secondary" role="status">
                                        <span class="sr-only">読み込み中...</span>
                                    </div>
                                    <div class="spinner-grow text-success" role="status">
                                        <span class="sr-only">読み込み中...</span>
                                    </div>
                                </div>
                                <div style="margin:0;padding:0;display:inline">
                                    <input name="utf8" type="hidden" value="✓" />
                                    <input name="_method" type="hidden" value="PUT" />
                                    <input name="authenticity_token" type="hidden" value="qLZ9cScer7ZxqulsUWazw4x3cSEzv899SP/7ThPCOV8=" />
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email">メールアドレス</label>
                                        <input type="email" class="form-control" id="email" name="email" aria-describedby="email" value="<?= $email ?>">
                                        <small id="email-valid" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="customername">お客様氏名</label>
                                        <input type="text" size="4" class="form-control" id="customername" name="customername" aria-describedby="cardname">
                                        <small id="customername-valid" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class='form-group required'>
                                        <label for="cardnumber">カード番号</label>
                                        <div id="cardnumber" class='form-control card-number'></div>
                                        <!-- <input autocomplete='off' id="cardnumber" name="cardnumber" class='form-control card-number' size='20' type='text' placeholder='1234 1234 1234 1234'> -->
                                        <small id="cardnumber-valid" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class='col-6 form-group cvc required'>
                                            <label class='cvc'>CVC</label>
                                            <div id="cvc" class='form-control card-cvc'></div>
                                            <!-- <input autocomplete='off' id="cvc" name="cvc" class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'> -->
                                            <small id="cvc-valid" class="form-text text-muted"></small>
                                        </div>
                                        <div class='col-6 form-group expiration required'>
                                            <label class='expiration'>有効期限</label>
                                            <div id="expiration" class='form-control card-expiry-month'></div>
                                            <!-- <input id="expiration" name="expiration" class='form-control card-expiry-month' placeholder='MM / YY' size='2' type='text'> -->
                                            <small id="expiration-valid" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline" style="margin-right: 0;">
                                        <input class="form-check-input" type="checkbox" id="autoPay" value="option2"/>
                                        <label class="form-check-label" for="autoPay"><a href="<?= base_url() ?>/terms-of-use" target="_blank">利用規約</a>と<a href="<?= base_url() ?>/privacy-policy" target="_blank">プライバシーポリシー</a>に同意する</label>
                                    </div>
                                </div>
                                <div class='col-md-12 form-group'>
                                    <button class='form-control btn btn-primary submit-button' type='submit'>
                                        <span class="loading-hidden">Pay »</span>
                                        <span class="loading-show">Paying 
                                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                            <span class="sr-only">Loading...</span>
                                        </span>
                                    </button>
                                </div>
                            </form>
                            <form id="stripe-payment-form" style="display:none;">
                                <div class="page-loading" style="width: 100%; height: 100%;">
                                    <div class="spinner-grow text-primary" role="status">
                                        <span class="sr-only">読み込み中...</span>
                                    </div>
                                    <div class="spinner-grow text-secondary" role="status">
                                        <span class="sr-only">読み込み中...</span>
                                    </div>
                                    <div class="spinner-grow text-success" role="status">
                                        <span class="sr-only">読み込み中...</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                </div>
                                <div id="stripe-pay-demo">
                                    <div id="card-element"><!--Stripe.js injects the Card Element--></div>  
                                    <button id="pay-button">支払う »</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">Paypal</div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">Payoneer</div>
                    </div>
                        
                </div>
            </div>
            <div class="modal-footer">
<!--                <button id="pay-modal-close" type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button> -->
                <!-- <button type="button" class="btn btn-primary" onclick="savecardinfomation()">Save Information</button> -->
            </div>
            </div>
        </div>
    </div>

    <!-- Comfirm Pay Modal -->
    <div class="modal fade" id="confirmpay-modal" tabindex="-1" aria-labelledby="confirmpay" aria-hidden="true">
        <div class="modal-dialog">
            <form id="confirmpay-form" action="/">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmpay-label">本当に確認する</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    あなたは本当にこのサイトにお金を払っていますか？
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-primary">確認</button>
                </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Comfirm Cancel Modal -->
    <div class="modal fade" id="confirm-cancel-modal" tabindex="-1" aria-labelledby="confirmcancel" aria-hidden="true">
        <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmpay-label">お支払いを停止する</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="font-size: 0.8rem;">お支払いを停止後も次回更新日までご利用いただけます。<br>
                    お取引データは次回更新日から半年間保存されます。</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                    <button type="button" onclick="$('#subscription-ctrl-form').submit(); " data-dismiss="modal" class="btn btn-primary">確認</button>
                </div>
                </div>
        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('addition_script') ?>
    
<script src="https://js.stripe.com/v3/"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    <script>

        var clientSecret = "";
        var card = null;
        var stripe = null;
        var pk_key = "";
        var server_res = null
        var email = ""
        var customername = ""
        var plan = "";

        var stripe_err = "";
        function removeAllLoading() {
            $("#pricing-30").removeClass("loading");            
            $("#pricing-90").removeClass("loading");            
            $("#pricing-180").removeClass("loading");            
        }
        
        function buyUsageTicket(mode) {
            $("#pricing-" + mode).addClass("loading");
            plan = mode;
            
            $(function() {
                // Make inputs
                (function () {
                    // Creating Stripe Object
                    stripe = Stripe("<?= getenv('pk_key') ?>");
                    var elements = stripe.elements();

                    var style = {
                        base: {
                            fontWeight: 400,
                            fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
                            fontSize: '16px',
                            lineHeight: '1.4',
                            color: '#555',
                            backgroundColor: '#fff',
                            '::placeholder': {
                                color: '#888',
                            },
                        },
                        invalid: {
                            color: '#eb1c26',
                        }
                    };
                    var cardElement = elements.create('cardNumber', {
                        style: style
                    });
                    
                    cardElement.mount('#payment-form div#cardnumber');

                    var exp = elements.create('cardExpiry', {
                        'style': style
                    });
                    exp.mount('#payment-form div#expiration');

                    var cvc = elements.create('cardCvc', {
                        'style': style
                    });
                    cvc.mount('#payment-form div#cvc');

                    cardElement.addEventListener('change', function(event) {
                        if (event.error) {
                            stripe_err = event.error.message;
                            $("#stripe-message").html('<p>'+event.error.message+'</p>');
                        } else {
                            stripe_err = '';
                            $("#stripe-message").html('');
                        }
                    });

                    card = cardElement;

                    $('#payment-form').on('submit', function(e) {
                        e.preventDefault();
                        email = $("#payment-form input[name='email']").val();
                        customername = $("#payment-form input[name='customername']").val();
                        
                        var verified = true
                        if (email == "") {
                            $("#payment-form #email-valid").html("無効なメール");
                            verified = verified && false;
                        } else {
                            $("#payment-form #email-valid").html("");
                        }
                        if (customername == "") {
                            $("#payment-form #customername-valid").html("カードの名前が無効です");
                            verified = verified && false;
                        } else {
                            $("#payment-form #customername-valid").html("");
                        }
                        if (verified) {
                            /////////////
                            
                            var autoPay = $("#autoPay").prop("checked");
                            if (autoPay) {
                                $("#payment-form").addClass("loading");
                                createToken();
                            } else {
                                $("#payment-form").removeClass("loading");
                            }

                            function createToken() {
                                stripe.createToken(card).then(function(result) {
                                    if (result.error) {
                                        $("#stripe-message").html('<p>'+result.error.message+'</p>');
                                    } else {
                                        stripeTokenHandler(result.token);
                                    }
                                });
                            }
                            function stripeTokenHandler(token) {
                                console.log("--------------")
                                console.log(customername, email, plan)
                                $.ajax({
                                    type: "POST",
                                    url: "<?= base_url() ?>/payment/stripe-subscription",
                                    data: {
                                        stripeToken: token.id,
                                        name: customername,
                                        email: email,
                                        plan: plan,
                                    },
                                    dataType: "json",
                                    success: function(result2){  
                                        if (result2.code == 200) {
                                            console.log(result2)
                                            if (!result2.updated) {
                                            } else {
                                            }
                                        } else {
                                            $("#msg.msg").append("\
                                            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">\
                                                <h4 class=\"alert-heading\">カード情報が正しくありません</h4>\
                                                <hr>\
                                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\
                                                    <span aria-hidden=\"true\">&times;</span>\
                                                </button>\
                                            </div>\
                                            ");
                                        }
                                        $("#payment-form").removeClass("loading");
                                        $("#pay-modal").modal("hide");
                                        $("#pricing-" + plan ).removeClass("loading");
                                        
                                    },
                                    error: function(xhr) {
                                        console.log(xhr)
                                        $("#msg.msg").append("\
                                            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">\
                                                <h4 class=\"alert-heading\">カード情報が正しくありません</h4>\
                                                <hr>\
                                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\
                                                    <span aria-hidden=\"true\">&times;</span>\
                                                </button>\
                                            </div>\
                                        ");
                                        $("#payment-form").removeClass("loading");
                                        $("#pay-modal").modal("hide");
                                        $("#pricing-" + plan ).removeClass("loading");
                                    }
                                });
                                        
                            }
                            /////////////
                            
                        } else {

                        }
                    });
                    
                    $("#pay-modal").modal("show");

                })();

            });
        }

        <?php if (isset($subscription_plan)) { ?>
            $("#subscription-ctrl-form").on('submit', function(e) {
                e.preventDefault();
                $("#subscription-ctrl-form").addClass("loading");
                var subscription_id = $("#subscription-ctrl-form").data('subscription-id')
                
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>/payment/stripe-subscription-cancel",
                    data: {
                        subscription_id: subscription_id,
                    },
                    dataType: "json",
                    success: function(result){  
                        $("#subscription-ctrl-form").removeClass("loading");
                        $("#cancel_form").html("");
                        $("#msg.msg").append("\
                            <div class=\"alert alert-delete alert-dismissible fade show\" role=\"alert\">\
                                <h4 class=\"alert-heading\">\
                                お支払いは停止されました。\
                                次回更新日までご利用いただけます。\
                                </h4>\
                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\
                                    <span aria-hidden=\"true\">&times;</span>\
                                </button>\
                            </div>\
                        ");
                    },
                    error: function(xhr) {
                        console.log(xhr)
                        $("#subscription-ctrl-form").removeClass("loading");
                        $("#msg.msg").append("\
                            <div class=\"alert alert-delete alert-dismissible fade show\" role=\"alert\">\
                                <h4 class=\"alert-heading\">\
                                キャンセルに失敗します。\
                                </h4>\
                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\
                                    <span aria-hidden=\"true\">&times;</span>\
                                </button>\
                            </div>\
                        ");
                    }
                });
            });
        <?php } ?>
    </script>

<?= $this->endSection() ?>
