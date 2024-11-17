<?php
// Чтение данных из JSON
$data = json_decode(file_get_contents('data.json'), true);

// Функция для отображения правил без кнопок изменения и удаления
function displayRules($rules) {
    foreach ($rules as $rule) {
        echo "<div class='rule'>
                <h3>{$rule['condition']}</h3>
                <p><strong>Результат:</strong> {$rule['result']}</p>
                <p><strong>Описание:</strong> {$rule['description']}</p>
              </div>";
    }
}

// Загрузка данных из файла JSON
$data = json_decode(file_get_contents('data.json'), true);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>База знаний Университета "Дубна"</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <h1>База знаний Университета "Дубна"</h1>
        <p>Правила для поступления, студентов и преподавателей</p>
    </header>
    
    <div class="block">
        <h2 class="clickable">Правила для поступления</h2>
        <div class="rules hidden">
            <?php displayRules($data['admission_rules']); ?>
        </div>
    </div>

    <div class="block">
        <h2 class="clickable">Правила для студентов</h2>
        <div class="rules hidden">
            <?php displayRules($data['student_rules']); ?>
        </div>
    </div>

    <div class="block">
        <h2 class="clickable">Правила для преподавателей</h2>
        <div class="rules hidden">
            <?php displayRules($data['professor_rules']); ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Университет "Дубна"</p>
    </footer>
    <script src="scripts.js"></script>
</body>
</html>
