<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Members <?= $this->endSection() ?>



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
    <div class="card shadow border-none my-2 px-2">
      <div class="d-flex justify-content-end mb-3">
        
        <div class="col-md-2 pt-3">
          <div>
            <a href="<?= site_url('members/new')?>" class="btn btn-success"><i class="bi-person-plus me-1"></i>Add Member</a>
          </div>
        </div>

      </div>
      <div class="card-body px-0 pb-2">

        <!-- <h2><?= esc($title) ?></h2> -->
        <?php if (!empty($members) && is_array($members)) : ?>
          <div class="table-responsive">
            <table class="table table-hover" id="viewsTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Member No.</th>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Joined</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($members as $member) : ?>
                  <tr>
                    <td><?= esc($member['id']) ?></td>
                    <td><?= esc($member['member_number']) ?></td>
                    <td><?= esc($member['first_name']) ?> <?= esc($member['first_name']) ?></td>
                    <td><?= esc($member['phone_number']) ?></td>
                    <td><?= esc($member['email']) ?></td>
                    <td><?= esc($member['join_date']) ?></td>
                    <td><a href="<?= site_url('members/view/'. $member['id'])?>" class="btn btn-sm btn-success" ><i class="bi-eye"></i></a>
                    <a href="<?= site_url('members/edit/'. $member['id'])?>" class="btn btn-sm btn-info" ><i class="bi-pencil-square"></i></a></td>
                  </tr>


                <?php endforeach ?>
              </tbody>
            </table>
          </div>

        <?php else : ?>

          <h3>No members</h3>

          <p>Unable to find any members for you.</p>

        <?php endif ?>
      </div>
    </div>

  </div>
</div>


<?= $this->endSection() ?>