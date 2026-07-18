<?php
// Разрешаем запросы с твоего сайта
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Отключаем стандартный вывод ошибок PHP в HTML, чтобы не ломать JSON
error_reporting(0);
ini_set('display_errors', 0);

// Данные твоей базы данных
$host = "ebppi0.h.filess.io";
$port = "61002";
$db = "BLUESTACKS_hornseatbe";
$user = "BLUESTACKS_hornseatbe";
$pass = "0449129887b1781db61f2ddffae37fdace3fbe60";

// Включаем безопасный режим подключения (для PHP 8+)
mysqli_report(MYSQLI_REPORT_OFF);

try {
    $conn = new mysqli($host, $user,$pass, $db,$port);
    if ($conn->connect_error) {
        throw new Exception("Не удалось подключиться к MySQL: " . $conn->connect_error);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Ошибка БД: " . $e->getMessage()]);
    exit;
}

$action =$_GET['action'] ?? '';

// 1. ВЫДАТЬ СВОБОДНЫЙ КЛЮЧ
if ($action === 'get_free_key') {$sql = "SELECT `Key` FROM HWIDKeys WHERE HWID IS NULL OR HWID = '' LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result &&$result->num_rows > 0) {
        $row =$result->fetch_assoc();
        echo json_encode(["success" => true, "key" => $row['Key']]);
    } else {
        echo json_encode(["success" => false, "message" => "В базе данных закончились свободные ключи без HWID!"]);
    }
} 
// 2. ПРОВЕРИТЬ HWID
elseif ($action === 'check_hwid') {
    $hwid =$_GET['hwid'] ?? '';
    
    $stmt =$conn->prepare("SELECT `Key` FROM HWIDKeys WHERE HWID = ?");
    if ($stmt) {$stmt->bind_param("s", $hwid);$stmt->execute();
        $result =$stmt->get_result();
        
        if ($result &&$result->num_rows > 0) {
            $row =$result->fetch_assoc();
            echo json_encode(["status" => "linked", "key" => $row['Key']]);
        } else {
            echo json_encode(["status" => "not_found"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Ошибка подготовки запроса проверки HWID"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Неизвестное действие запроса"]);
}

$conn->close();
?>
