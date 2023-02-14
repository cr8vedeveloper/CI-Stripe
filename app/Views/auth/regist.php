<?= $this->extend('auth/authLayout') ?>

<?= $this->section('page_title') ?>
    <title>ねね丸シート - 新規登録</title>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
    <div class="card p-4">
        <div class="card-title text-center">
            <h1 class="mt-4 text-center">
                <img src="<?= base_url() ?>/logo.png" alt="ねね丸シート" style="width:80%">
            </h1>
        </div>
        <div class="card-body">
            <div id="msg" class="msg">
                <?php if (session()->has('message')) : ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <p>
                        <?= session('message') ?>
                    </p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php endif ?>
            </div>
            <form id="registerForm" method="POST" action="<?= route_to('register'); ?>" accept-charset="UTF-8"
                onsubmit="registerButton.disabled = true; return true;">
                <?php if (isset($message)): ?>
                    <div class="alert alert-warning text-center">
                    <?= $message ?>
                    </div>
                <?php endif ?>
                <div class="form-group">
                    <label for="fullname">氏名</label><br />
                    <input class="form-control" required minlength="2" type="text" name="fullname" value="<?= old('fullname') ?>" />
                </div>
                <div class="form-group">
                    <label for="email">メールアドレス</label><br />
                    <input class="form-control" required type="email" name="email" value="<?= old('email') ?>" />
                </div>
                <div class="form-group">
                    <label for="password">パスワード</label><br />
                    <input class="form-control" required minlength="4" type="password" name="password" value="" />
                </div>
                <!-- <div class="form-group">
                    <label for="password_confirm">Confirm your password</label><br />
                    <input class="form-control" required minlength="4" type="password" name="password_confirm" value="" />
                </div> -->
                <div class="form-check form-check-inline" style="margin-right: 0;">
                    <input class="form-check-input" required type="checkbox" id="agreewithus" value="option2"/>
                    <label class="form-check-label" for="agreewithus"><a href="<?= base_url() ?>/terms-of-use" target="_blank">利用規約</a>と<a href="<?= base_url() ?>/privacy-policy" target="_blank">プライバシーポリシー</a>に同意する</label>
                </div>
                <div class="form-group text-center">
                    <button class="form-control btn btn-sm btn-primary col-6 mt-3" name="registerButton" type="submit">新規登録</button>
                </div>
                <div class="small text-center">
                    <a href="<?= base_url() ?>/auth/login">ログイン</login>
                </div>
            </form>
            
        </div>
    </div>
<?= $this->endSection() ?>

