<?php
$students = [
    [
        "id" => 101,
        "firstName" => "Ivan",
        "lastName" => "Petrov",
        "major" => "Computer Science",
        "group" => "CS-102",
        "average_score" => 4.5
    ],
    [
        "id" => 102,
        "firstName" => "Anna",
        "lastName" => "Smirnova",
        "major" => "Mathematics",
        "group" => "MATH-202",
        "average_score" => 4.8
    ],
    [
        "id" => 103,
        "firstName" => "Petr",
        "lastName" => "Ivanov",
        "major" => "Informatics",
        "group" => "INF-102",
        "average_score" => 3.9
    ],
    [
        "id" => 104,
        "firstName" => "Olga",
        "lastName" => "Kuznetsova",
        "major" => "Physics",
        "group" => "PHYS-301",
        "average_score" => 4.2
    ],
    [
        "id" => 105,
        "firstName" => "Alexey",
        "lastName" => "Sidorov",
        "major" => "Computer Science",
        "group" => "CS-103",
        "average_score" => 4.0
    ]
];

function showStudents($students)
{
    echo "Список студентов:\n";
    foreach ($students as $s) {
        echo "ID: {$s['id']} | {$s['firstName']} {$s['lastName']} | " .
            "Специальность: {$s['major']} | Группа: {$s['group']} | Ср. балл: {$s['average_score']}\n";
    }
}

// Найти по фамилии
function findByLastName($students, $lastName)
{
    foreach ($students as $s) {
        if (strcasecmp($s['lastName'], $lastName) == 0) {
            echo "Найден студент: {$s['firstName']} {$s['lastName']} (ID {$s['id']})\n";
            return;
        }
    }
    echo "Студент с фамилией $lastName не найден.\n";
}

// Сортировка по среднему баллу
function sortByScore($students)
{
    usort($students, function ($a, $b) {
        return $b['average_score'] <=> $a['average_score'];
    });
    showStudents($students);
    return $students;
}

// Фильтрация по специальности
function filterByMajor($students, $major)
{
    foreach ($students as $s) {
        if (strcasecmp($s['major'], $major) == 0) {
            echo "ID: {$s['id']} | {$s['firstName']} {$s['lastName']} | {$s['group']} | Ср. балл: {$s['average_score']}\n";
        }
    }
}

// Фильтрация по группе
function filterByGroup($students, $group)
{
    foreach ($students as $s) {
        if (strcasecmp($s['group'], $group) == 0) {
            echo "ID: {$s['id']} | {$s['firstName']} {$s['lastName']} | {$s['major']} | Ср. балл: {$s['average_score']}\n";
        }
    }
}

// Общий средний балл
function calculateAverage($students)
{
    $sum = 0;
    foreach ($students as $s) {
        $sum += $s['average_score'];
    }
    $avg = $sum / count($students);
    echo "Общий средний балл студентов: " . round($avg, 2) . "\n";
}

// Добавить студента
function addStudent(&$students)
{
    $firstName = readline("Введите имя: ");
    $lastName = readline("Введите фамилию: ");
    $major = readline("Введите специальность: ");
    $group = readline("Введите группу: ");
    $avg = (float) readline("Введите средний балл: ");
    $newId = max(array_column($students, 'id')) + 1;

    $students[] = [
        "id" => $newId,
        "firstName" => $firstName,
        "lastName" => $lastName,
        "major" => $major,
        "group" => $group,
        "average_score" => $avg
    ];

    echo "Студент успешно добавлен (ID $newId)!\n";
}

// Удалить студента
function deleteStudent(&$students)
{
    $input = readline("Введите ID или фамилию студента для удаления: ");

    foreach ($students as $key => $s) {
        if ($s['id'] == $input || strcasecmp($s['lastName'], $input) == 0) {
            unset($students[$key]);
            $students = array_values($students); // пересобрать индексы
            echo "Студент удалён.\n";
            return;
        }
    }
    echo "Студент не найден.\n";
}

do {
    echo "\n=============================\n";
    echo "Система управления студентами\n";
    echo "=============================\n";
    echo "1 – Показать список студентов\n";
    echo "2 – Найти студента по фамилии\n";
    echo "3 – Отсортировать студентов по среднему баллу\n";
    echo "4 – Фильтрация по специальности\n";
    echo "5 – Фильтрация по группе\n";
    echo "6 – Вычислить общий средний балл\n";
    echo "7 – Добавить нового студента\n";
    echo "8 – Удалить студента\n";
    echo "0 – Выход\n";
    echo "-----------------------------\n";

    $choice = readline("Ваш выбор: ");

    switch ($choice) {
        case 1:
            showStudents($students);
            break;
        case 2:
            $ln = readline("Введите фамилию: ");
            findByLastName($students, $ln);
            break;
        case 3:
            $students = sortByScore($students);
            break;
        case 4:
            $mj = readline("Введите специальность: ");
            filterByMajor($students, $mj);
            break;
        case 5:
            $gr = readline("Введите группу: ");
            filterByGroup($students, $gr);
            break;
        case 6:
            calculateAverage($students);
            break;
        case 7:
            addStudent($students);
            break;
        case 8:
            deleteStudent($students);
            break;
        case 0:
            echo "Выход...\n";
            break;
        default:
            echo "Неверный выбор!\n";
            break;
    }
} while ($choice != 0);
