<header class="header">
  <a href="/index.php" class="header__logo">
    <img src="/img/logo.svg" alt="Кнопка" />
  </a>

  <ul class="header__menu">
    <li><a href="#" onclick="scrollToTours()">Экскурсии</a></li>
    <li><a href="#" onclick="scrollToTeam()">Команда</a></li>
    <li><a href="#" onclick="scrollToAbout()">О нас</a></li>
    <li><a href="#" onclick="scrollToContact()">Контакты</a></li>
  </ul>

  <div class="burger-menu" onclick="toggleMenuModal()">
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
  </div>
</header>

<div id="menuModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="toggleMenuModal()">&times;</span>
    <ul class="modal-menu">
      <li><a href="#" onclick="scrollToTours()">Экскурсии</a></li>
      <li><a href="#" onclick="scrollToTeam()">Команда</a></li>
      <li><a href="#" onclick="scrollToAbout()">О нас</a></li>
      <li><a href="#" onclick="scrollToContact()">Контакты</a></li>
    </ul>
  </div>
</div>


<script>
  $(document).ready(function () {
    $(".burger-menu").click(function () {
      $(this).toggleClass("open");
      // $('.header__menu').slideToggle();
    });
  });
  $(document).ready(function () {
    $(".burger-menu").click(function () {
      $(this).toggleClass("open");
      $(".modal-content").toggleClass("show-close");
      $("#menuModal").toggleClass("show");
    });
  });

  function toggleMenuModal() {
    $(".modal").toggleClass("show");
    $(".modal-content").toggleClass("show-close");
  }
</script>
