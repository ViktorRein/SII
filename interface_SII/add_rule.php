<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('data.json'), true);

    // Получение данных из формы
    $new_rule = [
        "id" => end($data[$_POST['category']])['id'] + 1, // Автоинкремент ID для выбранной категории
        "condition" => $_POST['condition'],
        "result" => $_POST['result'],
        "description" => $_POST['description']
    ];

    // Проверка на наличие такого правила в выбранной категории
    $rule_exists = false;
    foreach ($data[$_POST['category']] as $rule) {
        if ($rule['condition'] == $new_rule['condition'] && $rule['result'] == $new_rule['result']) {
            $rule_exists = true;
            break;
        }
    }

    if ($rule_exists) {
        // Если правило уже существует, выводим сообщение об ошибке
        $error_message = "Правило с таким условием и результатом уже существует!";
    } else {
        // Добавление нового правила в выбранную категорию
        $data[$_POST['category']][] = $new_rule;
        file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); // JSON_UNESCAPED_UNICODE для сохранения русских символов
        header('Location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить правило</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <h1>База знаний Университета "Дубна"</h1>
        <p>Добавление нового правила</p>
    </header>

    <div class="add-rule-form">
        <h2>Добавить новое правило</h2>

        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Условие:</label><br>
            <input type="text" name="condition" required><br>
            
            <label>Результат:</label><br>
            <input type="text" name="result" required><br>
            
            <label>Описание:</label><br>
            <textarea name="description"></textarea><br>

            <!-- Добавляем выпадающий список для выбора категории -->
            <label>Категория:</label><br>
            <select name="category" required>
                <option value="admission_rules">Правила для поступления</option>
                <option value="student_rules">Правила для студентов</option>
                <option value="professor_rules">Правила для преподавателей</option>
            </select><br>

            <button type="submit">Добавить правило</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Университет "Дубна"</p>
    </footer>
</body>
</html>
