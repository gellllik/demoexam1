<?php
session_start();
if (!isset($_SESSION['user_id'])) die('Чтобы записаться на курсы, надо войти в аккаунт.');

$success = false;
$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $review = $_POST['review'];
    $date = $_POST['date'];
    $venue = $_POST['venue'];
    $payment = $_POST['payment'];
    $status = 'Новая'; // Статус устанавливается автоматически
    
    include('db.php');
    
    // Для безопасности в реальном проекте используйте подготовленные выражения (prepared statements)
    $user_id = (int)$_SESSION['user_id']; // Защита от SQL-инъекций
    $review = $con->real_escape_string($review);
    $venue = $con->real_escape_string($venue);
    $payment = $con->real_escape_string($payment);
    
    $query = $con->query("INSERT INTO request (review, date, curses, payment, user_id, status) 
                          VALUES ('$review', '$date', '$venue', '$payment', '$user_id', '$status')");
    
    if (!$query) {
        $error = true;
        $error_msg = 'Ошибка: ' . $con->error;
    } else {
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запись на курсы — Пассажирам.РФ</title>
    <!-- Подключение шрифта PT Sans -->
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&family=PT+Sans:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style-create.css">
</head>
<body>
    <div class="container">
        <!-- Кнопки навигации -->
        <div class="nav-buttons">
            <a href="index.php" class="btn-nav"> Главная</a>
            <a href="history.php" class="btn-nav"> Мои заявки</a>
        </div>
        
        <h1> Запись на курсы вождения</h1>

        <?php if ($success): ?>
            <div class="success-message">
                 Заявка на обучение успешно отправлена!<br><br>
                <a href="history.php"> Перейти к истории моих заявок</a>
                <br><br>
                Наш менеджер свяжется с вами в ближайшее время для уточнения деталей.
            </div>
        <?php elseif ($error): ?>
            <div class="error-message">
                 Ошибка при отправке заявки: <?php echo htmlspecialchars($error_msg); ?><br>
                <a href="javascript:history.back()"> Попробовать снова</a>
            </div>
        <?php endif; ?>

        <?php if (!$success): ?>
        <form method="POST" action="" id="requestForm">
            
            <label for="venue"> Выберите направление обучения</label>
            <select id="venue" name="venue" required>
                <option value="Водитель автобуса"> Водитель автобуса (категория D)</option>
                <option value="Водитель электробуса"> Водитель электробуса</option>
                <option value="Водитель трамвая"> Водитель трамвая</option>
            </select>

            <label for="date"> Желаемая дата начала обучения</label>
            <input id="date" type="datetime-local" name="date" required>

            <label for="payment"> Форма оплаты</label>
            <select id="payment" name="payment" required>
                <option value="наличные"> Наличные </option>
                <option value="перевод"> Безналичный </option>
                <option value="карта"> Банковской картой онлайн</option>
            </select>

            <label for="review"> Дополнительная информация</label>
            <textarea id="review" name="review" placeholder="Укажите комментарии к обучению"></textarea>
             
            <button type="submit" id="submitBtn"> Отправить заявку на обучение</button>
        </form>
        <?php endif; ?>
    </div>

    <script>
        // Анимация при отправке формы
        const form = document.getElementById('requestForm');
        const submitBtn = document.getElementById('submitBtn');
        
        if (form) {
            form.addEventListener('submit', function(e) {
                // Добавляем класс загрузки на кнопку
                submitBtn.classList.add('loading');
                submitBtn.textContent = 'Отправка';
            });
        }

        // Анимация при фокусе на полях
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transition = 'all 0.2s ease';
            });
            
            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.style.transform = 'scale(1)';
                }
            });
        });
    </script>
</body>
</html>