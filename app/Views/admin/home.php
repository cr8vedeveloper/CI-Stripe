<?= $this->extend('layout/default') ?>

<?= $this->section('page_title') ?>
    <title>ねね丸シート - ADMIN</title>
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

        table#users td {
            overflow: auto;
            display: inline-block;
            white-space: wrap;
        }
        table#users td.no {
            width: 5%;
        }
        table#users td.email {
            width: 15%;
        }
        table#users td.fullname {
            width: 10%;
        }
        table#users td.permission {
            width: 10%;
        }
        table#users td.join_date {
            width: 15%;
        }
        table#users td.plan {
            width: 10%;
        }
        table#users td.expire_date {
            width: 15%;
        }
        table#users td.action {
            width: 20%;
        }
        table#users .active-user {
            color: #0000FF;
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="card mb-5">
        <div class="card-head">
            <h5 class="card-title">
            </h5>
        </div>
        <div class="card-body">
            <h5 class="card-title">ユーザー管理</h5>
            <div class="table-responsive">
                <table id="users" class="table table-striped">
                    <thead>
                        <tr scope="col">
                            <td class="no">番号</td>
                            <td class="email">メールアドレス</td>
                            <td class="fullname">氏名</td>
                            <td class="permission">役割</td>
                            <td class="join_date">入会日</td>
                            <td class="plan">予定 (日)</td>
                            <td class="expire_date">有効期限</td>
                            <td class="action">動作</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; foreach ($users as $user): $i ++; ?>
                            <tr scope="col" id="<?= $user['id'] ?>">
                                <td class="no"><?php echo $i; ?></td>
                                <td 
                                    class="email <?= $user['active'] == 1 ? 'active-user' : '' ?>"
                                >
                                    <?= $user['email'] ?>
                                </td>
                                <td class="fullname"><?= $user['fullname'] ?></td>
                                <td class="permission">
                                    <select id="role" class="form-control" onchange="focuseApplyButton(<?= $user['id'] ?>)">
                                        <option value="1" <?= $user['role'] == '1' ? 'selected' : '' ?>>役割1</option>
                                        <option value="3" <?= $user['role'] == '3' ? 'selected' : '' ?>>役割2</option>
                                        <option value="8" <?= $user['role'] == '8' ? 'selected' : '' ?>>役割3</option>
                                        <option value="1023" <?= $user['role'] == '1023' ? 'selected' : '' ?>>管理者</option>
                                    </select>
                                </td>
                                <td class="join_date"><?= $user['created_at'] ?></td>
                                <td class="plan"><?= $user['plan'] ?></td>
                                <td class="expire_date">
                                    <input name="expire_date" id="expire_date" value="<?= date_format(date_create($user['expire_date']),"Y-m-d") ?>" type="date" class="form-control form-control-sm" style="width:9rem">
                                </td>
                                <td class="action">
                                    <button id="apply" onclick="updateUserB(<?= $user['id'] ?>, <?= $i ?>)" type="button" class="btn btn-light">適用する</button>
                                    <button id="delete" onclick="deleteUserB(<?= $user['id'] ?>, <?= $i ?>)" type="button" class="btn btn-light">削除</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>

    <div id="deleteModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div>削除してもよろしいでしょうか？</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteUser()">削除</button>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section("addition_script") ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js" integrity="sha512-blBYtuTn9yEyWYuKLh8Faml5tT/5YPG0ir9XEABu5YCj7VGr2nb21WPFT9pnP4fcC3y0sSxJR1JqFTfTALGuPQ==" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <!-- <script src="http://localhost/public/assets/jsgrid.min.js" integrity="sha512-blBYtuTn9yEyWYuKLh8Faml5tT/5YPG0ir9XEABu5YCj7VGr2nb21WPFT9pnP4fcC3y0sSxJR1JqFTfTALGuPQ==" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://localhost/public/assets/loader.js"></script> -->

    <script>

    function deleteUserB(userid, tableid) {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>/admin/api/deleteUser",
                data: {
                    id: userid,
                },
            })
            .done(function() {
                alert("Successfully deleted");
                $("#users #" + tableid).remove();
            });
    }

    function updateUserB(userid, tableid) {
        var role = $("#users #" + userid + " #role").children("option:selected").val()
        var expire_date = $("#users #" + userid + " #expire_date").val();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/admin/api/updateUser",
            data: {
                id: userid,
                role: role,
                expire_date: expire_date,
            },
            dataType: "json",
            success: function(result){  
                
                console.log(result)
            },
            error: function(xhr) {
                console.log(xhr)
            }
        });
    }

    function focuseApplyButton(userid) {
        $("#users #" + userid + " #apply").focus();
    }
    </script>
<?= $this->endSection() ?>