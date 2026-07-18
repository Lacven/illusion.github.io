<?php
// Разрешаем запросы с твоего сайта
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Данные твоей базы данных
$host = "ebppi0.h.filess.io";
$port = "61002";
$db = "BLUESTACKS_hornseatbe";
$user = "BLUESTACKS_hornseatbe";
$pass = "0449129887b1781db61f2ddffae37fdace3fbe60";

// Подключение к БД
$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die(json_encode(["error" => "Ошибка подключения к БД"]));
}

$action = $_GET['action'] ?? '';

// 1. ВЫДАТЬ СВОБОДНЫЙ КЛЮЧ
if ($action === 'get_free_key') {
    // Ищем 1 ключ, где HWID пустой
    $sql = "SELECT `Key` FROM HWIDKeys WHERE HWID IS NULL OR HWID = '' LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(["success" => true, "key" => $row['Key']]);
    } else {
        echo json_encode(["success" => false, "message" => "Нет свободных ключей"]);
    }
} 
// 2. ПРОВЕРИТЬ HWID
elseif ($action === 'check_hwid') {
    $hwid = $_GET['hwid'] ?? '';
    
    $stmt = $conn->prepare("SELECT `Key` FROM HWIDKeys WHERE HWID = ?");
    $stmt->bind_param("s", $hwid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(["status" => "linked", "key" => $row['Key']]);
    } else {
        echo json_encode(["status" => "not_found"]);
    }
} else {
    echo json_encode(["error" => "Неизвестное действие"]);
}

$conn->close();
?>
