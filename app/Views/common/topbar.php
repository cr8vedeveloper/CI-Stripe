<div class="row p-0" style="background-color:#ffffff;">
    <div class="row d-flex align-items-center mx-auto my-2" style="width:100%; max-width:1200px">
        <div class="col text-left">
            <img src="<?= base_url() ?>/logo.png" alt="ねね丸シート" style="margin-left:0.5rem; height:3rem;">
        </div>
        <div class="col text-right small">
            <?= $email ?> | <a href="<?= base_url() ?>/auth/logout">ログアウト</a>
            <br>
            残高 <span id="total-balance">--</span>円 | 収支 <span id="total-profit">--</span>円 | 勝率 <span id="total-average">--</span>%
        </div>
    </div>
</div>