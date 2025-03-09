<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link collapsed" href="/dashboard">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <?php if ($userInfo['role'] == 'admin') { ?>

      <li class="nav-item">
        <a href="/members" class="nav-link collapsed">
          <i class="bi bi-people"></i>
          <span>Members</span>

        </a>
      </li>
      <li class="nav-item">
        <a href="<?= site_url('accounting/journals/page')?>" class="nav-link collapsed">
          <i class="bi bi-journal-arrow-down"></i>
          <span>Journals</span>

        </a>
      </li>
      <!-- <li class="nav-item">
        <a href="/payments" class="nav-link collapsed">
          <i class="bi bi-cash-stack"></i>
          <span>
            Payments
          </span>

        </a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#payments" role="button" aria-expanded="false"
          aria-controls="collapseExample">
          <i class="bi bi-cash-stack"></i>
          <span>
            Payments
          </span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>

        <div class="collapse" id="payments">
          <ul>
            <li class="nav-item">
              <a href="<?= site_url('/payments') ?>" class="nav-link collapsed">
                <i class="bi bi-phone"></i>
                <span>
                  PayBill
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('/payments/ac_bank') ?>" class="nav-link collapsed">
                <i class="bi bi-bank"></i>
                <span>
                  CO-OP
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('payments/deposits') ?>" class="nav-link collapsed">
                <i class="bi bi-piggy-bank"></i>
                <span>
                  Saving Deposits
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('payments/shares') ?>" class="nav-link collapsed">
                <i class="bi bi-box-arrow-in-down"></i>
                <span>
                  Share Deposits
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('payments/repayments') ?>" class="nav-link collapsed">
                <i class="bi bi-cash-coin"></i>
                <span>
                  Loan Repayments
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('payments/group') ?>" class="nav-link collapsed">
                <i class="bi bi-people"></i>
                <span>
                  Group Payments
                </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#loans" role="button" aria-expanded="false"
          aria-controls="collapseExample">
          <i class="bi bi-bank"></i>
          <span>
            Loans
          </span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>

        <div class="collapse" id="loans">
          <ul>
            <li class="nav-item">
              <a href="<?= site_url('loans/apply') ?>" class="nav-link collapsed">
                <i class="bi bi-pencil-square"></i>
                <span>
                  Apply Loan
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('loans/my_loans?user' . $userInfo['id']) ?>" class="nav-link collapsed">
                <i class="bi bi-person-workspace"></i>
                <span>
                  My Loans
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('loans/new') ?>" class="nav-link collapsed">
                <i class="bi bi-card-checklist"></i>
                <span>
                  Loan Applications
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('loans/approved') ?>" class="nav-link collapsed">
                <i class="bi bi-check2-circle"></i>
                <span>
                  Approved Loans
                </span>
              </a>
            </li>
            
            <li class="nav-item">
              <a href="<?= site_url('loans/settings') ?>" class="nav-link collapsed">
                <i class="bi bi-gear"></i>
                <span>
                  Loan Settings
                </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#agentPay" role="button" aria-expanded="false"
          aria-controls="collapseExample">
          <i class="bi bi-person-lines-fill"></i>
          <span>
            Agents
          </span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>

        <div class="collapse" id="agentPay">
          <ul>
            <li class="nav-item">
              <a href="<?= site_url('/agents') ?>" class="nav-link collapsed">
                <i class="bi bi-people"></i>
                <span>
                  Agent List
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('agent/commissions') ?>" class="nav-link collapsed">
                <i class="bi bi-piggy-bank"></i>
                <span>
                  Commissions
                </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <!-- <li class="nav-item">
        <a href="/agents" class="nav-link collapsed">
          <i class="bi bi-person-vcard"></i>
          <span>Agents</span>
        </a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#settings" role="button" aria-expanded="false"
          aria-controls="collapseExample">
          <i class="bi bi-gear
          "></i>
          <span>
            Settings
          </span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>

        <div class="collapse" id="settings">
          <ul>
            <li class="nav-item">
              <a href="<?= site_url('balances/upload')?>" class="nav-link collapsed">
                <i class="bi bi-sliders"></i>
                <span>
                  Balances
                </span>
              </a>
            </li>
            
            <li class="nav-item">
              <a href="<?=site_url('/users')?>" class="nav-link collapsed">
                <i class="bi bi-person-check"></i>
                <span>Users</span>

              </a>
            </li>
          </ul>
        </div>
      </li>

      <!-- <li class="nav-item">
        <a href="/sms" class="nav-link collapsed">
          <i class="bi bi-envelope-arrow-up"></i>
          <span>SMS</span>

        </a>
      </li> -->
    <?php } ?>
    <?php if ($userInfo['role'] == 'agent') { ?>
      <li class="nav-item">
        <a href="<?= site_url('agent/myCommissions') ?>" class="nav-link collapsed">
          <i class="bi-cash-stack"></i>
          <span>Commissions</span>
        </a>
      </li>
    <?php } ?>
    <li class="nav-item">
      <a href="/myPayments" class="nav-link collapsed">
        <i class="bi-cash-stack"></i>
        <span>My Payments</span>
      </a>
    </li>
    <?php if ($userInfo['role'] == 'member') { ?>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#loans" role="button" aria-expanded="false"
          aria-controls="collapseExample">
          <i class="bi bi-bank"></i>
          <span>
            Loans
          </span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>

        <div class="collapse" id="loans">
          <ul>
            <li class="nav-item">
              <a href="<?= site_url('loans/apply') ?>" class="nav-link collapsed">
                <i class="bi bi-pencil-square"></i>
                <span>
                  Apply Loan
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('loans/my_loans?user' . $userInfo['id']) ?>" class="nav-link collapsed">
                <i class="bi bi-person-workspace"></i>
                <span>
                  My Loans
                </span>
              </a>
            </li>

          </ul>
        </div>
      </li>
    <?php } ?>


  </ul>

</aside>

<!-- <div class="col-12 col-md-2 col-sm-2">
    
<div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style=" height: 100vh !important;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      <i class="bi-person-circle text-success me-2" style="font-size: 3rem;"></i>
      <span class="fs-1"><?= $userInfo['name'] ?></span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
       
        
        <a href="/dashboard" class="nav-link text-white">
            <i class="bi-house me-2 h5"></i> 
          Dashboard
        </a>
      </li>
      <?php if ($userInfo['role'] == 'admin') { ?>

      <li>
        <a href="/members" class="nav-link text-white">
          <i class="bi-people me-2 h5"></i>
          Members
        </a>
      </li>
      <li>
        <a href="/payments" class="nav-link text-white">
            <i class="bi-cash-stack me-2 h5"></i>
          Payments
        </a>
      </li>
      <li>
        <a href="/agents" class="nav-link text-white">
            <i class="bi-person-vcard me-2 h5"></i>
          Agents
        </a>
      </li>
      <li>
        <a href="/users" class="nav-link text-white">
        <i class="bi-person-check me-2 h5"></i>
          Users
        </a>
      </li>-->
<?php } ?>



<!-- <li> 
        <a href="#" class="nav-link text-white">
        <i class="bi-person-square me-2 h5"></i>
          Profile
        </a>
      </li>
      
      
      <li>
        <a href="/logout" class="nav-link text-white">
          <i class="bi-box-arrow-right me-2 h5"></i>
          Logout
        </a>
      </li>
    </ul>
    <hr>
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
        <strong>mdo</strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
        <li><a class="dropdown-item" href="#">New project...</a></li>
        <li><a class="dropdown-item" href="#">Settings</a></li>
        <li><a class="dropdown-item" href="#">Profile</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Sign out</a></li>
      </ul>
    </div>
  </div>


</div></aside> -->