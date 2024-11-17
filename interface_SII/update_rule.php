<?php
// Чтение данных из JSON
$data = json_decode(file_get_contents('data.json'), true);

// Проверяем, что параметры id и category переданы
if (!isset($_GET['id']) || !isset($_GET['category'])) {
    die('Ошибка: ID или категория не переданы!');
}

$id = $_GET['id'];
$category = $_GET['category'];

// Проверяем, существует ли категория в данных
if (!isset($data[$category])) {
    die('Категория не существует');
}

// Поиск редактируемого правила
$rule = null;
foreach ($data[$category] as $r) {
    // Здесь мы учитываем сдвиг ID, т.е. находим правило, ID которого совпадает с переданным id
    if ($r['id'] == ($id + 1)) { // Если ID в URL начинается с 0, а в JSON с 1, то прибавляем 1
        $rule = $r;
        break;
    }
}

// Если правило не найдено
if ($rule === null) {
    die('Правило не найдено');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Проходим по данным и изменяем нужную запись
    foreach ($data[$category] as &$r) {
        if ($r['id'] == ($id + 1)) {
            $r['condition'] = $_POST['condition'];
            $r['result'] = $_POST['result'];
            $r['description'] = $_POST['description'];
            break;
        }
    }

    // Преобразуем массив в JSON без экранирования русских символов
    $json_data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    // Проверяем на ошибки
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo 'Ошибка при преобразовании в JSON: ' . json_last_error_msg();
    } else {
        file_put_contents('data.json', $json_data);
        header('Location: index.php');
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Изменить правило</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            margin: 20px auto;
            width: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: inline-block;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #2980b9;
        }

        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

<header>
    <h1>Изменить правило</h1>
</header>

<form method="POST">
    <label>Условие:</label><br>
    <input type="text" name="condition" value="<?php echo htmlspecialchars($rule['condition']); ?>" required><br>

    <label>Результат:</label><br>
    <input type="text" name="result" value="<?php echo htmlspecialchars($rule['result']); ?>" required><br>

    <label>Описание:</label><br>
    <textarea name="description" required><?php echo htmlspecialchars($rule['description']); ?></textarea><br>

    <button type="submit">Обновить правило</button>
</form>

<footer>
    <p>&copy; 2024 Университет "Дубна"</p>
</footer>

</body>
</html>
