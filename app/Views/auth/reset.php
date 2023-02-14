

<?= $this->extend('auth/authLayout') ?>

<?= $this->section('page_title') ?>
    <title>ねね丸シート - ログイン</title>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
    <div class="card p-4">
        <div class="card-title text-center">
            <h1 class="mt-4 text-center">
                <img src="<?= base_url() ?>/logo.png" alt="ねね丸シート" style="width:80%">
            </h1>
        </div>
        <div class="card-body">
            <?php if (session()->has('message')): ?>
                <div class="alert alert-warning text-center">
                    <?= session('message') ?>
                </div>
            <?php endif ?>
            <form class="form-text" method="POST" action="<?= current_url()."?token=".$token ?>" accept-charset="UTF-8"
                onsubmit="submitButton.disabled = true; return true;">
                
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input class="form-control" type="password" name="password" id="password" required >
                </div>
                <div class="form-group text-center">
                    <input class="form-control btn btn-sm btn-primary col-6 mt-3" type="submit" id="submit" value="Update password">
                </div>
            </form>
            <div class="small text-center">
                <a href="<?= base_url() ?>/auth/login">ログイン</login>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>