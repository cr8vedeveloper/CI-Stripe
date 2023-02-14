<p><?= base_url() ?>___の親愛なるメンバー、</p>

<p>次のリンクをクリックして、新しい電子メールアドレスを確認してください!</p>
<p><a href="<?= base_url('confirm-email') . '?token=' . $hash ?>"><?= base_url('confirm-email') . '?token=' . $hash ?></a></p>

<p>このウェブサイトに登録しなかった場合は、このメールを無視してください。</p>