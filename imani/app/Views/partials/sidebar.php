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
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#entries" role="button" aria-expanded="false"
          aria-controls="collapseExample">
          <i class="bi bi-person-lines-fill"></i>
          <span>
            Entries
          </span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>

        <div class="collapse" id="entries">
          <ul>
            <li class="nav-item">
              <a href="<?= site_url('accounting/remittances') ?>" class="nav-link collapsed">
                <i class="bi bi-cash-coin"></i>
                <span>
                  Remittances
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('accounting/journals/page') ?>" class="nav-link collapsed">
                <i class="bi bi-journal"></i>
                <span>Journals</span>
              </a>
            </li>
          </ul>
        </div>
      </li>


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
            <!-- <li class="nav-item">
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
            </li> -->
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
            <!-- <li class="nav-item">
              <a href="<?= site_url('loans/my_loans?user' . $userInfo['id']) ?>" class="nav-link collapsed">
                <i class="bi bi-person-workspace"></i>
                <span>
                  My Loans
                </span>
              </a>
            </li> -->
            <li class="nav-item">
              <a href="<?= site_url('loans/all') ?>" class="nav-link collapsed">
                <i class="bi bi-card-checklist"></i>
                <span>
                  Loan Applications
                </span>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="<?= site_url('loans/approved') ?>" class="nav-link collapsed">
                <i class="bi bi-check2-circle"></i>
                <span>
                  Approved Loans
                </span>
              </a>
            </li> -->

            <li class="nav-item">
              <a href="<?= site_url('loans/type') ?>" class="nav-link collapsed">
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
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#reports" role="button" aria-expanded="false"
          aria-controls="collapseExample">
          <i class="bi bi-receipt"></i>
          <span>
            Reports
          </span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>

        <div class="collapse" id="reports">
          <ul>
            <li class="nav-item active">
              <a href="<?= site_url('accounting/reports/trial-balance') ?>" class="nav-link collapsed">
                <i class="bi bi-receipt-cutoff"></i>
                <span>Trial Balance</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('accounting/reports/balance-sheet') ?>" class="nav-link collapsed">
                <i class="bi bi-receipt-cutoff"></i>
                <span>
                  Balance Sheet
                </span>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= site_url('accounting/reports/income-statement') ?>" class="nav-link collapsed">
                <i class="bi bi-receipt-cutoff"></i>
                <span>Income Statement</span>

              </a>
            </li>
          </ul>
        </div>
      </li>
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
              <a href="<?= site_url('accounting/accounts/page') ?>" class="nav-link collapsed">
                <i class="bi bi-journal-bookmark-fill"></i>
                <span>Chart of Accounts</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('balances/upload') ?>" class="nav-link collapsed">
                <i class="bi bi-sliders"></i>
                <span>
                  Balances
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('/users') ?>" class="nav-link collapsed">
                <i class="bi bi-person-check"></i>
                <span>Users</span>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="<?= site_url('/settings') ?>" class="nav-link collapsed">
                <i class="bi bi-gear"></i>
                <span>System Settings</span>
              </a>
            </li> -->
            <li class="nav-item">
              <a href="<?= site_url('/admin/settings') ?>" class="nav-link collapsed">
                <i class="bi bi-person-gear"></i>
                <span>Admin Settings</span>
              </a>
            </li>
          </ul>
        </div>
      </li>

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