<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= esc($title)?> <?= $this->endSection() ?>




<div class="row">
  <?= $this->section('content') ?>
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
  <div class="col-lg-12">
    <div class="card shadow border-none my-4 px-2">
      
      <div class="card-body px-0 pb-2">
        <form action="updatePayment?id=<?= $id ?>" method="post" class="form-floating">
          <?= csrf_field() ?>

          <div class="row">
            <div class="mb-3 col-md-4">
              <label for="name" class="col-form-label">M-PESA Name:</label>
              <input type="text" name="name" id="name" value="<?= set_value('name', $payment['mp_name']) ?>" class="form-control " readonly>
            </div>
            <div class="mb-3 col-md-4">
              <label for="name" class="col-form-label">Add to Name:</label>
              <input type="text" name="addname" id="addname" class="form-control">
            </div>
            <div class="mb-3 col-md-4">
              <label for="memberName" class="col-form-label">Member Number:</label>
              <input type="text" name="memberNumber" id="memberNumber" class="form-control">
            </div>
          </div>
          <div class="d-flex align-items-between justify-content-between me-2">
            <a href="<?= base_url('/payments') ?>" class="btn btn-info me-3"><i class="bi-chevron-left"></i> Back</a>
            <button type="submit" class="btn btn-success">Update</button>
          </div>
          



        </form>

      </div>
    </div>

  </div>
</div>



<?= $this->endSection() ?>