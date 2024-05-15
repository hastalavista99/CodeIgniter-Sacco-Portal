<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-4 m-10">

                <?= validation_list_errors() ?>
                <form action="/loginUser" class="form mb-3" method="post">
                    <h1 class="h3 mb3 fw-formal">Sign In</h1>
                    <?= csrf_field() ?>

                    <?php
                    if (!empty(session()->getFlashdata('success'))) {
                    ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php
                    } else if (!empty(session()->getFlashdata('fail'))) {
                    ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('fail') ?>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="form-floating mb-1">

                        <input type="text" name="name" value="<?= set_value('name') ?>" id="floatingInput" class="form-control" placeholder="Username Here">
                        <label for="floatingInput">Username</label>
                    </div>

                    <div class="form-floating">

                        <input type="password" name="password" value="<?= set_value('password') ?>" id="floatingPassword" class="form-control" placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="form-check text-start my-3">
                        <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Remember me
                        </label>
                    </div>
                    
                        <input type="submit" value="Sign In" class="btn btn-primary w-100 py-2">
                    
                </form>
                <a href="<?= site_url('auth/register') ?>">I don't have an account</a>

                <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2024</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>