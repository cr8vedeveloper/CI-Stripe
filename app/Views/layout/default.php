<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" integrity="sha512-3Epqkjaaaxqq/lt5RLJsTzP6cCIFyipVRcY4BcPfjOiGM1ZyFCv4HHeWS7eCPVaAigY3Ha3rhRgOsWaWIClqQQ==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" integrity="sha512-jx8R09cplZpW0xiMuNFEyJYiGXJM85GUL+ax5G3NlZT3w6qE7QgxR4/KE1YXhKxijdVTDNcQ7y6AJCtSpRnpGg==" crossorigin="anonymous" />
    

    <?= $this->renderSection('page_title') ?>
    
    <?= $this->renderSection('addition_style') ?>
    
    <style>
        .submit-button {
            margin-top: 10px;
        }
        .page-loading {
            display: none;
        }
        .loading {
            position: relative;
        }
        .loading .page-loading {
            position: absolute; 
            width: calc(100% - 30px); 
            display: flex; 
            justify-content: center; 
            height: calc(100% - 30px); 
            align-items: center; 
            z-index: 1000;
            background: #00a1ff;
            opacity: 0.4;
        }
        .loading .loading-hidden {
            display: none;
        }
        .loading-show {
            display: none;
        }
        .loading .loading-show {
            display: inherit;
        }
    </style>
</head>

<body style="background-color:#dfdfdc; margin-bottom:0.2rem">
    <div class="container-fluid">

        <?= $this->include('common/topbar') ?>

        <?= $this->include('common/navbar') ?>

        <div class="container mt-2 p-0" style="width:100%; max-width:1200px">

            <div id="msg" class="msg">
                
            </div>

            <?= $this->renderSection('content') ?>

        </div>
  
    </div>

    <?= $this->renderSection('modals') ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <?= $this->renderSection('addition_script') ?>

</body>
</html>