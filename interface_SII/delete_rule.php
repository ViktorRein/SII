<?php
if (isset($_GET['id']) && isset($_GET['category'])) {
    // Загружаем текущие данные из файла
    $data = json_decode(file_get_contents('data.json'), true);

    // Получаем ID из URL и корректируем его (прибавляем 1)
    $id = $_GET['id'] + 1;  // ID из URL начинается с 0, в JSON с 1
    $category = $_GET['category'];

    // Проверяем, существует ли нужная категория в данных
    if (isset($data[$category]) && is_array($data[$category])) {
        // Удаляем правило по ID из выбранной категории
        $data[$category] = array_filter($data[$category], function ($rule) use ($id) {
            return $rule['id'] != $id;  // Убираем правило с данным ID
        });

        // Пересчитываем индексы массива
        $data[$category] = array_values($data[$category]);

        // Сохраняем данные обратно в JSON с правильным форматированием
        file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    // Перенаправляем на главную страницу после удаления
    header('Location: index.php');
    exit;
}
?>





<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Удаление правила</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .message {
            font-size: 18px;
            color: #333;
            text-align: center;
            margin: 20px 0;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #ff4444;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            margin: 20px 0;
        }
        .btn:hover {
            background-color: #ff0000;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #007BFF;
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Удаление правила</h1>
        <div class="message">
            <?php if (isset($id)) { ?>
                Правило с ID <?php echo htmlspecialchars($id); ?> успешно удалено.
            <?php } else { ?>
                Произошла ошибка. Попробуйте снова.
            <?php } ?>
        </div>
        <a href="index.php" class="back-link">Вернуться на главную страницу</a>
    </div>
</body>
</html>
