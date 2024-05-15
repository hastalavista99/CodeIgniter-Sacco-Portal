<div class="col-12 col-md-2">
    
<div class="position-fixed d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 230px; height: 100vh !important;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      <i class="bi-person-circle text-success me-2" style="font-size: 3rem;"></i>
      <span class="fs-1"><?= $userInfo['name'] ?></span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <!-- <i class="material-symbols-outlined opacity-10">dashboard</i> -->
        
        <a href="/dashboard" class="nav-link text-white">
            <i class="bi-house me-2 h5"></i> 
          Dashboard
        </a>
      </li>
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
        <a href="#" class="nav-link text-white">
        <i class="bi-person-square me-2 h5"></i>
          Profile
        </a>
      </li>
      
      <li>
        <a href="/users" class="nav-link text-white">
        <i class="bi-person-check me-2 h5"></i>
          Users
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


</div></aside>