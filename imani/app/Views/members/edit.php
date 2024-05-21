<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Edit Member <?= $this->endSection() ?>

<?= $this->section('content') ?>

<?= $this->include('partials/navbar') ?>
<div class="row">
  <?php
  if (!empty(session()->getFlashdata('success'))) {
  ?>
    <div class="alert alert-success alert-dismissible fade show">
      <i class="bi-check-circle-fill"></i> <?= session()->getFlashdata('success') ?>
      <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
    </div>
  <?php
  } else if (!empty(session()->getFlashdata('fail'))) {
  ?>
    <div class="alert alert-danger alert-dismissible fade show">
      <i class="bi-exclamation-triangle-fill"></i> <?= session()->getFlashdata('fail') ?>
      <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
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
            <h4 class="row text-capitalize display-4 ps-3">Edit Member</h4>
          </div>
        </div>


      </div>
      <div class="card-body px-0 pb-2">
        <form action="/updateMember?id=<?= $id ?>" method="post" class="form-floating">
          <?= csrf_field() ?>

          <div class="row">
            <div class="mb-3 col-6">
              <label for="name" class="col-form-label">Name:</label>
              <input type="text" name="name" id="name" value="<?= set_value('name', $member['member_name']) ?>" class="form-control">
            </div>
            <div class="mb-3 col-6">
              <label for="mobile" class="col-form-label">Mobile:</label>
              <input type="text" name="mobile" id="mobile" value="<?= set_value('mobile', $member['member_phone']) ?>" class="form-control">
            </div>
          </div>
          <div class="d-flex align-items-end justify-content-end me-2">
            <button type="submit" class="btn btn-success">Update</button>
          </div>
          



        </form>

      </div>
    </div>

  </div>
</div>



<?= $this->endSection() ?>