<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Agents <?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row g-0">
    <?= $this->include('partials/navbar') ?>
  <?= $this->include('partials/sidebar') ?>
  
  <div class="col-12 col-md-10">
    
    <div class="card shadow border-none my-4 px-2">
      <div class="d-flex justify-content-between mb-3">
        <div class="row col-md-7 p-0 mx-3 z-index-2 my-2" style="height: 35px;">
          <div class="pt-1 pb-1 mb-2">
            <h4 class="row text-capitalize display-4 ps-3"><?= esc($title) ?></h4>
          </div>
        </div>
        <div class="col-md-2 pt-3">
          <div>
            
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAgentModal"><i class="bi-person-plus me-1"></i>
              New Agent
            </button>
          </div>
        </div>

      </div>
      <div class="card-body px-0 pb-2">

        <!-- <h2></h2> -->
        <?php if (!empty($agents) && is_array($agents)) : ?>
          <div class="table-responsive">
            <table class="table table-hover" id="tableView">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Agent No.</th>
                  <th>Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($agents as $agent) : ?>
                  <tr>
                    <td><?= esc($agent['id']) ?></td>
                    <td><?= esc($agent['agent_no']) ?></td>

                    <!-- <div class="main"> -->
                    <td><?= esc($agent['name']) ?></td>
                    <td><?= esc($agent['mobile']) ?></td>
                    <td><?= esc($agent['email']) ?></td>
                  </tr>
              </tbody>

            <?php endforeach ?>
            </table>
          </div>

        <?php else : ?>

          <h3>No Agents</h3>

          <p>Unable to find any agents for you.</p>

        <?php endif ?>
      </div>
    </div>

  </div>
</div>

// Add Agent Modal
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