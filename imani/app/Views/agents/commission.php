<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= esc($title)?> <?= $this->endSection() ?>


<div class="row">
  <?= $this->section('content') ?>
  <?= $this->include('partials/sidebar') ?>

  <div class="col-lg-12">
  <?php
  if (!empty(session()->getFlashdata('success'))) {
  ?>
    <div class="alert alert-success alert-dismissible fade show">
      <i class="bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
      <button type="button" class="container btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
    </div>
  <?php
  } else if (!empty(session()->getFlashdata('fail'))) {
  ?>
    <div class="alert alert-danger alert-dismissible fade show">
      <i class="bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('fail') ?>
      <button type="button" class="container btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
    </div>
  <?php
  }
  ?>
    <div class="card shadow border-none my-2 px-2">
      <div class="d-flex justify-content-end mb-3">
        
        <div class="col-md-2 pt-3">
          <div>

            <!-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAgentModal"><i class="bi-person-plus me-1"></i>
              New Agent
            </button> -->
          </div>
        </div>

      </div>
      <div class="card-body px-0 pb-2">

        <!-- <h2></h2> -->
        <?php if (!empty($commissions) && is_array($commissions)) : ?>
          <div class="table-responsive">
            <table class="table table-hover" id="viewsTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Agent</th>
                  <th>Amount</th>
                  <th>Member Phone</th>
                  <th>time</th>
                  <th></i></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($commissions as $commission) : ?>
                  <tr>
                    <td><?= esc($commission['id']) ?></td>
                    <td><?= esc($commission['agent']) ?></td>

                    <!-- <div class="main"> -->
                    <td><?= esc($commission['amount']) ?></td>
                    <td><?= esc($commission['member_phone']) ?></td>
                    <td><?= esc($commission['time']) ?></td>
                    <td><a href="#" class="btn btn-sm btn-info" ><i class="bi-pencil-square"></i></a>
                    <a href="#" class="btn btn-sm btn-danger" ><i class="bi-trash3"></i></a>
                    
                  </td>
                  </tr>


                <?php endforeach ?>
              </tbody>
            </table>
          </div>

        <?php else : ?>

          <h3>No Commissions</h3>

          <p>Unable to find any commissions for you.</p>

        <?php endif ?>
      </div>
    </div>

  </div>
</div>

<!-- // Add Agent Modal -->
<div class="modal fade" id="addAgentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">New Agent</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="/newAgent" class="form-floating mb-3">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label for="name" class="col-form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          <div class="row">
            <div class="col-4 mb-3">
              <label for="agent_no" class="col-form-label">Agent No.</label>
              <input type="text" class="form-control" id="agent_no" name="agent_no">
            </div>
            <div class="col-8 mb-3">
              <label for="mobile" class="col-form-label">Mobile No.</label>
              <input type="text" class="form-control" id="mobile" name="mobile">
            </div>
          </div>

          <div class="mb-3">
            <label for="email" class="col-form-label">Email:</label>
            <input type="text" class="form-control" id="email" name="email">
          </div>

          <div class="d-flex flex-row-reverse">
            <input type="submit" value="Create" class="btn btn-info">
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>