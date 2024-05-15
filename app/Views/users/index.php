<?= $this->extend('layouts/main') ?>
<?= $this->section('title')?>Users<?= $this->endSection() ?>

<?= $this->section('content')?>
<div class="row">
<?= $this->include('partials/navbar') ?>

    <?= $this->include('partials/sidebar')?>
    <div class="col-12 col-md-10">
    <div class="card shadow border-none my-4 px-2">
            <div class="d-flex justify-content-between mb-2">
                <div class="row col-md-7 p-0 mx-3 z-index-2 my-2" style="height: 35px;">
                    <div class="pt-1 pb-1 mb-2">
                        <h4 class="row text-capitalize display-4 ps-3">Users</h4>
                    </div>
                </div>
                <div class="col-md-2 pt-3">
                    <div>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUnitModal">
                            New User
                        </button>
                    </div>
                </div>

            </div>
            <div class="card-body px-0 pb-2">

                <!-- <h2><?= esc($title) ?></h2> -->
                <?php if (!empty($users) && is_array($users)) : ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="tableView">
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
                            </tbody>

                        <?php endforeach ?>
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

<?= $this->endSection()?>