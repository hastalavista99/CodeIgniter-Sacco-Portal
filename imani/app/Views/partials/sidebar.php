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
        <a href="/payments" class="nav-link collapsed">
          <i class="bi bi-cash-stack"></i>
          <span>
            Payments
          </span>

        </a>
      </li>
      <li class="nav-item">
        <a href="/agents" class="nav-link collapsed">
          <i class="bi bi-person-vcard"></i>
          <span>Agents</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="/users" class="nav-link collapsed">
          <i class="bi bi-person-check"></i>
          <span>Users</span>

        </a>
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
        <a href="<?= site_url('agent/myCommissions')?>" class="nav-link collapsed">
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
      </li>
      <?php } ?>
      <?php if ($userInfo['role'] == 'member') { ?>
        <li>
        <a href="/myPayments" class="nav-link text-white">
            <i class="bi-cash-stack me-2 h5"></i>
          My Payments
        </a>
      </li>
      <?php } ?>


      <li>
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