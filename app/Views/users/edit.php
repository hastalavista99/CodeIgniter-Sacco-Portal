<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Edit User <?= $this->endSection() ?>




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
        <form action="/updateUser?id=<?= $id ?>" method="post" class="form-floating">
          <?= csrf_field() ?>

          <div class="row">
            <div class="mb-3 col-6">
              <label for="name" class="col-form-label">Username:</label>
              <input type="text" name="name" id="name" value="<?= set_value('name', $user['name']) ?>" class="form-control">
            </div>
            <div class="mb-3 col-3">
              <label for="mobile" class="col-form-label">Mobile:</label>
              <input type="tel" name="mobile" pattern="[0-9]{10}" id="mobile" value="<?= set_value('mobile', $user['mobile']) ?>" class="form-control">
            </div>
            <div class="mb-3 col-3">
              <label for="memberNumber" class="col-form-label">Member No:</label>
              <input type="text" name="memberNumber" id="memberNumber" value="<?= set_value('member_no', $user['member_no']) ?>" class="form-control">
            </div>
            <div class="mb-3 col-6">
              <label for="email" class="col-form-label">Email:</label>
              <input type="email" name="email" id="email" value="<?= set_value('email', $user['email']) ?>" class="form-control">
            </div>
            <div class="mb-3 col-4">
              <label for="role" class="col-form-label">Role</label>
              <select name="role" id="role" class="form-control">
                <option value="<?= $userInfo['role'] ?>" selected><?= $userInfo['role'] ?></option>
                <option value="agent">Agent</option>
                <option value="member">Member</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
                <option value="accountant">Accountant</option>
                <option value="cashier">Cashier</option>
              </select>
            </div>
          </div>

          <!-- PERMISSIONS SECTION -->
          <h5 class="mt-4">Permissions</h5>
          <div class="row mx-2">
            <?php
            $availablePermissions = [
              'post_journal_entries' => 'Post Journal Entries',
              'approve_loans' => 'Approve Loans',
              'edit_member_details' => 'Edit Member Details',
              'access_system_parameters' => 'Access System Parameters',
              'view_payments' => 'View Payment Details',
              'manage_users' => 'Manage Users',
              'view_reports' => 'View Financial Reports',
              'create_members' => 'Create Members',
              'edit_settings' => 'Edit System Settings',
              'reverse_transactions' => 'Reverse Transactions',
              'close_month' => 'Close Month',
            ];

            $currentPermissions = json_decode($user['permissions'] ?? '[]', true);

            ?>

            <?php foreach ($availablePermissions as $key => $label): ?>
              <div class="form-check col-md-4 mb-2">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="<?= $key ?>" id="<?= $key ?>"
                  <?= (is_array($currentPermissions) && in_array($key, $currentPermissions)) ? 'checked' : '' ?>>
                <label class="form-check-label" for="<?= $key ?>">
                  <?= esc($label) ?>
                </label>
              </div>
            <?php endforeach; ?>
          </div>

          <div class="d-flex align-items-between justify-content-between me-2 mt-4">
            <a href="<?= site_url('/users') ?>" class="btn btn-info me-3"><i class="bi-chevron-left"></i> Back</a>
            <button type="submit" class="btn btn-success">Update</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>



<?= $this->endSection() ?>