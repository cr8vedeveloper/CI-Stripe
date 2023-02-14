<div class="row p-0" style="background-color:#0072BB;">
    <nav class="navbar navbar-expand-sm navbar-dark text-right mx-auto px-2 py-0" style="width:100%; max-width:1200px; background-color:#0072BB">
        <span></span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item 
                <?= strpos(current_url(),'home') > 0 ? 'active' : "" ?>
                ">
                    <a class="nav-link" href="<?= base_url() ?>/home">HOME</a>   
                </li>
                <li class="nav-item
                <?= strpos(current_url(),'analysis') > 0 ? 'active' : "" ?>
                ">
                    <a class="nav-link" href="<?= base_url() ?>/analysis">分析</a>
                </li>
                <li class="nav-item
                <?= strpos(current_url(),'history') > 0 ? 'active' : "" ?>
                ">
                    <a class="nav-link" href="<?= base_url() ?>/history">取引履歴</a>
                </li>
                <li class="nav-item
                <?= strpos(current_url(),'account') > 0 ? 'active' : "" ?>
                ">
                    <a class="nav-link" href="<?= base_url() ?>/account">入出金</a>
                </li>
                <li class="nav-item
                <?= strpos(current_url(),'user') > 0 ? 'active' : "" ?>
                ">
                    <a class="nav-link" href="<?= base_url() ?>/user">設定</a>
                </li>
                <?php
                if ($_SESSION['login'] && $_SESSION['login']['role'] == 1023) {
                ?>
                    <li class="nav-item
                    <?= strpos(current_url(),'admin') > 0 ? 'active' : "" ?>
                    ">
                        <a class="nav-link" href="<?= base_url() ?>/admin">管理者</a>
                    </li>
                <?php
                }
                ?>
            </ul>
            <ul class="navbar-nav" style="margin-left: auto">
                <li class="nav-item">
                    <a 
                        href="<?= base_url() ?>/payment/pricing-table" 
                        class="nav-link" 
                    >
                        サイトに支払う
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
