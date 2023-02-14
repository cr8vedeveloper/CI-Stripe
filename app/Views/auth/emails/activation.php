<?= $this->extend('auth/authLayout') ?>

<?= $this->section('content') ?>
    <div class="card p-4">
        <div class="card-title text-center">
            <h1 class="mt-4 text-center">
                <img src="<?= base_url() ?>/logo.png" alt="ねね丸シート" style="width:80%">
            </h1>
        </div>
        <div class="card-body">
        <p>私たちのサービスはあなたの財務分析を支援します。</p>
        <p>今後とも変わらぬご支援、ご鞭撻を賜りますようお願い申し上げます。</p>
            <div class="form-group text-center">
                <a class="form-control btn btn-sm btn-primary col-6 mt-3" href="<?= base_url('auth/active-account') . '?token=' . $hash ?>" >アカウントを有効にする</a>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>