<?= $this->extend('layouts/main') ?>
<?= $this->section('title')?>Dashboard <?= $this->endSection()?>

<?= $this->section('content')?>
        <div class="row">
            <?= $this->include('partials/sidebar') ?>
            <div class="col-12 col-md-9">
                <div class="card">
                <div class="card-header p-3 pt-2">
                <div
                  class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute"
                >
                  <i class="material-icons opacity-10">weekend</i>
                </div>
                <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize">Today's Money</p>
                  <h4 class="mb-0">$53k</h4>
                </div>
              </div>
                <h4><?= $title ?></h4>
                <hr>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">
                                <img src="" alt="" width="200px" height="150px">
                                <form action="<?= base_url('auth/uploadImage') ?>" method="post" enctype="multipart/form-data">
                                    <input type="file" class="form-control" name="userImage" size="10" id="image">
                                    <hr>
                                    <input type="submit" value="Upload" class="btn btn-info">
                                </form>
                            </th>
                            <td>
                                <?= $userInfo['name'] ?>
                            </td>
                            <td>
                                <?= $userInfo['email'] ?>
                            </td>
                            <td>
                                <a href="logout">Logout</a>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <?php if (!empty(session()->getFlashdata('notification'))) {
                ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('notification') ?>
                    </div>
                <?php } ?></div>
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>
