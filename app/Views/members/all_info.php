<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= esc($title) ?> <?= $this->endSection() ?>
<?= $this->section('content') ?>
<?= $this->include('partials/sidebar') ?>

<div class="container mt-3">


    <div class="row mb-4">
        <div class="col-md-3 mt-3">
            <?php if (!empty($member['photo_path'])): ?>
                <img src="<?= site_url('uploads/photos/' . $member['photo_path']) ?>" class="img-thumbnail" alt="Member Photo">
            <?php else: ?>
                <i class="bi bi-person-circle img-thumbnail px-4" style="font-size: 8rem;"></i>
            <?php endif; ?>
        </div>
        <div class="col-md-9">
            <div class="card shadow border-none my-2 px-2">
                <div class="card-body px-0 pb-2 mt-3">
                    <table class="table table-striped">
                        <tr>
                            <th>Member Number</th>
                            <td><?= esc($member['member_number']) ?></td>
                        </tr>
                        <tr>
                            <th>Full Name</th>
                            <td><?= esc($member['first_name'] . ' ' . $member['last_name']) ?></td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td><?= esc($member['dob']) ?></td>
                        </tr>
                        <tr>
                            <th>Join Date</th>
                            <td><?= esc($member['join_date']) ?></td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td><?= esc($member['gender']) ?></td>
                        </tr>
                        <tr>
                            <th>Nationality</th>
                            <td><?= esc($member['nationality']) ?></td>
                        </tr>
                        <tr>
                            <th>Marital Status</th>
                            <td><?= esc($member['marital_status']) ?></td>
                        </tr>
                        <tr>
                            <th>ID Number</th>
                            <td><?= esc($member['id_number']) ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= esc($member['email']) ?></td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td><?= esc($member['phone_number']) ?></td>
                        </tr>
                        <tr>
                            <th>Alternate Phone</th>
                            <td><?= esc($member['alternate_phone']) ?></td>
                        </tr>
                        <tr>
                            <th>Street Address</th>
                            <td><?= esc($member['street_address']) ?></td>
                        </tr>
                        <tr>
                            <th>Address Line 2</th>
                            <td><?= esc($member['address_line2']) ?></td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td><?= esc($member['city']) ?></td>
                        </tr>
                        <tr>
                            <th>County</th>
                            <td><?= esc($member['county']) ?></td>
                        </tr>
                        <tr>
                            <th>Zip Code</th>
                            <td><?= esc($member['zip_code']) ?></td>
                        </tr>
                        <tr>
                            <th>Active?</th>
                            <td><?= $member['is_active'] ? 'Yes' : 'No' ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card shadow border-none my-2 px-2">
                <div class="card-body px-0 pb-2 mt-3">

                    <h4 class="mt-5">Beneficiaries</h4>

                    <?php if (!empty($beneficiaries)): ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Date of Birth</th>
                                    <th>Phone Number</th>
                                    <th>Relationship</th>
                                    <th>Entitlement (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($beneficiaries as $b): ?>
                                    <tr>
                                        <td><?= esc($b['first_name'] . ' ' . $b['last_name']) ?></td>
                                        <td><?= esc($b['dob']) ?></td>
                                        <td><?= esc($b['phone_number']) ?></td>
                                        <td><?= esc($b['relationship']) ?></td>
                                        <td><?= esc($b['entitlement_percentage']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No beneficiaries listed.</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <a href="<?= site_url('members/view/'.$member['id']) ?>" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Back</a>
</div>

<?= $this->endSection() ?>