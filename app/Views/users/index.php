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
                    <div>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="bi-person-plus me-2"></i> New User
                        </button>
                    </div>
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
                                    <th>Member No.</th>
                                    <th>Mobile</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?= esc($user['id']) ?></td>
                                        <td><?= esc($user['name']) ?></td>
                                        <td><?= esc($user['member_no']) ?></td>

                                        <!-- <div class="main"> -->
                                        <td><?= esc($user['mobile']) ?></td>
                                        <td><?= esc($user['role']) ?></td>
                                        <td><a href="<?= site_url('/editUser?id='.$user['id'])  ?>" class="btn btn-sm btn-info"><i class="bi-pencil-square"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger"><i class="bi-trash3"></i></a>

                                        </td>
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

<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">New User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/newUser" class="form-floating mb-3">
                    <?= csrf_field() ?>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="username" class="col-form-label">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="mobile" class="col-form-label">Mobile No.:</label>
                            <input type="tel" class="form-control" id="mobile" name="mobile" pattern="[0-9]{10}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="col-form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="checkPassword">
                        <label class="form-check-label" for="checkPassword">
                            Show Password
                        </label>
                    </div>
                    <div class="mb-3 col-4">
                        <select name="role" id="role" class="form-control">
                            <option selected>-- Select role --</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="accountant">Accountant</option>
                            <option value="cashier">Cashier</option>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assign Permissions:</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="post_journal_entries" id="post_journal_entries">
                                    <label class="form-check-label" for="post_journal_entries">Post Journal Entries</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="approve_loans" id="approve_loans">
                                    <label class="form-check-label" for="approve_loans">Approve Loans</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="edit_member_details" id="edit_member_details">
                                    <label class="form-check-label" for="edit_member_details">Edit Member Details</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="access_system_parameters" id="access_system_parameters">
                                    <label class="form-check-label" for="access_system_parameters">Access System Parameters</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="access_payments_details" id="access_payments_details">
                                    <label class="form-check-label" for="access_payments_details">Access Payments Details</label>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="send_sms_to_member" id="send_sms_to_member">
                                    <label class="form-check-label" for="send_sms_to_member">Send SMS</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="view_reports" id="view_reports">
                                    <label class="form-check-label" for="view_reports">View System Reports</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="create_members" id="create_members">
                                    <label class="form-check-label" for="create_members">Create Members</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="edit_settings" id="edit_settings">
                                    <label class="form-check-label" for="edit_settings">Edit System Settings</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="reverse_transactions" id="reverse_transactions">
                                    <label class="form-check-label" for="reverse_transactions">Reverse Transactions</label>
                                </div>
                            </div>

                        </div>

                        <!-- You can add more permissions here -->
                    </div>


                    <div class="d-flex flex-row-reverse">
                        <input type="submit" value="Create" class="btn btn-info">
                    </div>


                </form>
                <script>
                    document.getElementById('checkPassword').addEventListener('change', function() {
                        let passwordFields = document.querySelectorAll('#password');
                        passwordFields.forEach(field => {
                            if (this.checked) {
                                field.type = 'text';
                            } else {
                                field.type = 'password';
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>