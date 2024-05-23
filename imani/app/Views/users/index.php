<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Users<?= $this->endSection() ?>


<div class="row">
    <?= $this->section('content') ?>

    <?= $this->include('partials/sidebar') ?>
    <div class="col-lg-12">
    <?php
  if (!empty(session()->getFlashdata('success'))) {
  ?>
    <div class="alert alert-success alert-dismissible fade show">
      <i class="bi-check-circle-fill"></i> <?= session()->getFlashdata('success') ?>
      <button type="button" class="container btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
    </div>
  <?php
  } else if (!empty(session()->getFlashdata('fail'))) {
  ?>
    <div class="alert alert-danger alert-dismissible fade show">
      <i class="bi-exclamation-triangle-fill"></i> <?= session()->getFlashdata('fail') ?>
      <button type="button" class="container btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
    </div>
  <?php
  }
  ?>
        <div class="card shadow border-none my-4 px-2">
            <div class="d-flex justify-content-end mb-2">
                
                <div class="col-md-2 pt-3">
                    <!-- <div>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUnitModal">
                            <i class="bi-person-plus me-2"></i> New User
                        </button>
                    </div> -->
                </div>

            </div>
            <div class="card-body px-0 pb-2">

                <!-- <h2><?= esc($title) ?></h2> -->
                <?php if (!empty($users) && is_array($users)) : ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="viewsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Auth Level</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?= esc($user['auth_id']) ?></td>
                                        <td><?= esc($user['auth_name']) ?></td>

                                        <!-- <div class="main"> -->
                                        <td><?= esc($user['auth_level']) ?></td>
                                        <td><?= esc($user['auth_time']) ?></td>
                                    </tr>


                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>

                <?php else : ?>

                    <h3>No users</h3>

                    <p>Unable to find any users for you.</p>

                <?php endif ?>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>