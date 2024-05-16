<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Members <?= $this->endSection() ?>

<?= $this->section('content') ?>

<?= $this->include('partials/navbar') ?>
<div class="row">
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


  <?= $this->include('partials/sidebar') ?>
  <div class="col-12 col-md-10">
    <div class="card shadow border-none my-4 px-2">
      <div class="d-flex justify-content-between mb-3">
        <div class="row col-md-7 p-0 mx-3 z-index-2 my-2" style="height: 35px;">
          <div class="pt-1 pb-1 mb-2">
            <h4 class="row text-capitalize display-4 ps-3">Members</h4>
          </div>
        </div>
        <div class="col-md-2 pt-3">
          <div>

            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMemberModal"><i class="bi-person-plus me-1"></i>
              New Member
            </button>
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
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Joined</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($members as $member) : ?>
                  <tr>
                    <td><?= esc($member['pk_member_id']) ?></td>
                    <td><?= esc($member['member_name']) ?></td>

                    <!-- <div class="main"> -->
                    <td><?= esc($member['member_phone']) ?></td>
                    <td><?= esc($member['member_date']) ?></td>
                    <td><a href="/editMember?id=<?= $member['pk_member_id'] ?>" class="btn btn-info" ><i class="bi-pencil-square"></i></a></td>
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

// Add Member Modal
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">New Member</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="/newMember" class="form-floating mb-3">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label for="first-name" class="col-form-label">First Name:</label>
            <input type="text" class="form-control" id="first-name" name="first-name">
          </div>
          <div class="mb-3">
            <label for="last-name" class="col-form-label">Last Name:</label>
            <input type="text" class="form-control" id="last-name" name="last-name">
          </div>
          <div class="mb-3">
            <label for="mobile" class="col-form-label">Mobile No.</label>
            <input type="text" class="form-control" id="mobile" name="mobile">
          </div>
          <div class="d-flex flex-row-reverse">
            <input type="submit" value="Create" class="btn btn-info">
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

// Edit Member Modal
<div class="modal fade" id="editMemberModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Member</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="/newMember" class="form-floating mb-3">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label for="first-name" class="col-form-label">First Name:</label>
            <input type="text" class="form-control" id="first-name" name="first-name">
          </div>
          <div class="mb-3">
            <label for="last-name" class="col-form-label">Last Name:</label>
            <input type="text" class="form-control" id="last-name" name="last-name">
          </div>
          <div class="mb-3">
            <label for="mobile" class="col-form-label">Mobile No.</label>
            <input type="text" class="form-control" id="mobile" name="mobile">
          </div>
          <div class="d-flex flex-row-reverse">
            <input type="submit" value="Apply Changes" class="btn btn-info">
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>