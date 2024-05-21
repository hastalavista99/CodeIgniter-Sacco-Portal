<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4 offset-4">
                <h4>Sign Up</h4>
                <hr>
                <?= validation_list_errors() ?>

                <?php
                    if(!empty(session()->getFlashdata('success'))){
                        ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                        <?php
                    } else if(!empty(session()->getFlashdata('fail'))){
                        ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('fail') ?>
                    </div>
                        <?php
                    }
                ?>
                <form action="/registerUser" method="post" class="form mb-3">

                    <?= csrf_field() ?>

                    <div class="form-group mb-3">
                        <label for="">Name</label>
                        <input type="text" name="name" id="" class="form-control" value="<?= set_value('name') ?>" placeholder="Name Here">

                    </div>
                    <div class="form-group mb-3">
                        <label for="">Email</label>
                        <input type="text" name="email" id="" class="form-control" value="<?= set_value('email') ?>" placeholder="Email Here">

                    </div>
                    <div class="form-group mb-3">
                        <label for="">Password</label>
                        <input type="password" name="password" id="" class="form-control" value="<?= set_value('password') ?>" placeholder="Password">

                    </div>
                    <div class="form-group mb-3">
                        <label for="">Confirm Password</label>
                        <input type="password" name="passwordConf" id="" class="form-control" value="<?= set_value('passwordConf') ?>" placeholder="Confirm Password">

                    </div>
                    <div class="form-group mb-3">
                        <input type="submit" value="Sign In" class="btn btn-info">
                    </div>
                </form>

                <a href="<?= site_url('auth') ?>">I already have an account</a>

            </div>
        </div>
    </div>

</body>

</html>