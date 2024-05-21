<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Dashboard <?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <?= $this->include('partials/sidebar') ?>
    <div class="col-12 col-md-10">
        <div class="card shadow border-none my-2 px-2">
            
        <div class="d-flex justify-content-between mb-3">
        <div class="row col-md-7 p-0 mx-3 z-index-2 my-2" style="height: 35px;">
          <div class="pt-1 pb-1 mb-2">
            <h4 class="row text-capitalize display-4 ps-3"><?= $title ?></h4>
          </div>
        </div>
        
      </div>
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
            <?php } ?>
        </div>
    </div>
</div>
</div>
<?= $this->endSection() ?>