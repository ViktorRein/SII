<?php
// Чтение данных из JSON
$data = json_decode(file_get_contents('data.json'), true);

// Функция для отображения правил с кнопками изменения и удаления
function displayRules($rules, $category) {
    foreach ($rules as $index => $rule) {
        echo "<div class='rule'>
                <h3>{$rule['condition']}</h3>
                <p><strong>Результат:</strong> {$rule['result']}</p>
                <p><strong>Описание:</strong> {$rule['description']}</p>
                
                <!-- Кнопки для редактирования и удаления -->
                <a href='update_rule.php?id={$index}&category={$category}' class='edit-btn'>Изменить</a>
                <a href='delete_rule.php?id={$index}&category={$category}' class='edit-btn'>Удалить</a>
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
    
    <div class="add-rule-btn">
        <a href="add_rule.php" class="add-rule-link">Добавить новое правило</a>
    </div>

    <div class="block">
        <h2 class="clickable">Правила для поступления</h2>
        <div class="rules hidden">
            <?php displayRules($data['admission_rules'], 'admission_rules'); ?>
        </div>
    </div>

    <div class="block">
        <h2 class="clickable">Правила для студентов</h2>
        <div class="rules hidden">
            <?php displayRules($data['student_rules'], 'student_rules'); ?>
        </div>
    </div>

    <div class="block">
        <h2 class="clickable">Правила для преподавателей</h2>
        <div class="rules hidden">
            <?php displayRules($data['professor_rules'], 'professor_rules'); ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Университет "Дубна"</p>
    </footer>
    <script src="scripts.js"></script>
</body>
</html>
