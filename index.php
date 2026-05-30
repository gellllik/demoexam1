<?php
session_start();

// Выход из системы
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

// Проверяем, установлен ли ключ admin в сессии
$is_admin = isset($_SESSION['admin']) && $_SESSION['admin'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Пассажирам.РФ — запись на курсы водителей пассажирских перевозок</title>
  <!-- Подключение шрифта PT Sans -->
  <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&family=PT+Sans:ital@1&display=swap" rel="stylesheet">
 <link rel="stylesheet" href="css/style-index.css">
  <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>
<header class="user-header">
        <div class="logo">
            <img src="picture/9.png" alt="Логотип">
            <span>Главная страница</span>
        </div>
        <div class="nav-buttons">
      <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="login.php" class="btn-login">Войти</a>
        <a href="register.php" class="btn-register">Регистрация</a>
      <?php elseif (isset($_SESSION['user_id'])): ?>
        <a href="history.php" class="btn-lk">Мои заявки</a>
        <a href="create.php" class="btn-create">Новая заявка</a>
        <a href="?logout=1" class="btn-exit">Выход</a>
      <?php endif; ?>
    </div>
    </header>



<!-- Слайдер с обучением пассажирским перевозкам (исправленные рабочие картинки) -->
<div class="slideshow-container">
  <div class="mySlides fade">
    <img src="https://www.m24.ru/b/d/nBkSUhL2g1kgms6wPqzZvc62gYT28pj21CLFh_fH_nKUPXuaDyXTjHou4MVO6BCVoZKf9GqVe5Q_CPawk214LyWK9G1N5ho=bCJb6WxPBmMVFYvl90sZCg.jpg" alt="Автобус в городе">
    <div class="slide-text"> Курсы водителей автобусов</div>
  </div>

  <div class="mySlides fade">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/KAMAZ-6282._Электробус._Москва_07.08.2025.jpg/960px-KAMAZ-6282._Электробус._Москва_07.08.2025.jpg" alt="Современный электробус">
    <div class="slide-text"> Электробусы — транспорт будущего</div>
  </div>

  <div class="mySlides fade">
    <img src="https://гэт.рус/images/news/1439537842.jpg" alt="Трамвай на рельсах">
    <div class="slide-text"> Вождение трамвая с нуля</div>
  </div>

  <div class="mySlides fade">
    <img src="https://avatars.mds.yandex.net/i?id=0d8f871da94e9d66f5eac92d4dd27fbe_l-5869113-images-thumbs&n=13" alt="Обучение в классе">
    <div class="slide-text"> Теория ПДД и практика</div>
  </div>

  <a class="prev" onclick="plusSlides(-1)">❮</a>
  <a class="next" onclick="plusSlides(1)">❯</a>
</div>

<div class="dot-container">
  <span class="dot" onclick="currentSlide(1)"></span>
  <span class="dot" onclick="currentSlide(2)"></span>
  <span class="dot" onclick="currentSlide(3)"></span>
  <span class="dot" onclick="currentSlide(4)"></span>
</div>

<!-- Основной контент — преимущества курсов -->
<section class="features-section">
  <h1 class="features-title">Почему выбирают «Пассажирам.РФ»?</h1>
  
  <div class="features-grid">
    <div class="feature-card">
      <h3> Обучение на автобус</h3>
      <p>Полный курс подготовки водителей категории «D» с опытными инструкторами и современным автопарком.</p>
    </div>
    
    <div class="feature-card">
      <h3> Электробусы — новый профиль</h3>
      <p>Освойте управление экологичным транспортом будущего. Востребованная специальность в мегаполисах.</p>
    </div>
    
    <div class="feature-card">
      <h3> Вождение трамвая</h3>
      <p>Практические занятия на действующих маршрутах. Выдаём свидетельство установленного образца.</p>
    </div>
  </div>
</section>

<footer class="footer">
  © 2026 Пассажирам.РФ — запись на курсы водителей пассажирского транспорта в вашем городе
</footer>

<script>
// Слайдер
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");

  if (n > slides.length) { slideIndex = 1 }
  if (n < 1) { slideIndex = slides.length }

  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (let i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }

  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}

// Автосмена каждые 3 секунды
let slideInterval = setInterval(() => plusSlides(1), 3000);

const container = document.querySelector('.slideshow-container');
if (container) {
  container.addEventListener('mouseenter', () => clearInterval(slideInterval));
  container.addEventListener('mouseleave', () => {
    slideInterval = setInterval(() => plusSlides(1), 3000);
  });
}
</script>
</body>
</html>