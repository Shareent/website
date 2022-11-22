<nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
  <div class="container">
    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDefault"
      aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <img src="Img/sharent1.png" alt="">

    <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="./">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="/about">About</a>
        </li>

        <li class="nav-item">
          <a class="nav-link " href="/property">Property</a>
        </li>

        <li class="nav-item">
          <a class="nav-link " href="/contact">Contact</a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link " href="blog-grid">Blog</a>
          </li> -->

        <li class="nav-item dropdown">
          <a class="nav-link login-btn" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">Register</a>
          <div class="dropdown-menu">
            <a class="dropdown-item " href="register?account-type=agent">As an agent</a>
            <a class="dropdown-item " href="register?account-type=buyer">As a buyer</a>
          </div>
        </li>
      </ul>
    </div>

    <button type="button" class="btn btn-b-n navbar-toggle-box navbar-toggle-box-collapse" data-bs-toggle="collapse"
      data-bs-target="#navbarTogglerDemo01">
      <i class="bi bi-search"></i>
    </button>

  </div>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const location = new URL(window.location)
    document.querySelectorAll('a.nav-link')?.forEach(el => {
      if (el.getAttribute('href').includes(location.pathname)) {
        el.classList.toggle('active')
      }else{
        el.classList.remove('active')
      }
    })
  })
</script>