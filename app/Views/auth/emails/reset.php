<?= $this->extend('auth/authLayout') ?>

<?= $this->section('content') ?>
    <div class="card p-4">
        <div class="card-title text-center">
            <h1 class="mt-4 text-center">
                <img src="<?= base_url() ?>/logo.png" alt="ねね丸シート" style="width:80%">
            </h1>
        </div>
        <div class="card-body">
            <p>青いボタンをクリックして、パスワードのリセットページに移動してください。</p>
            <div class="form-group text-center">
                <a class="form-control btn btn-sm btn-primary col-6 mt-3" href="<?= base_url('auth/reset-password') . '?token=' . $hash ?>" >パスワードを再設定する</a>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>