<?php
$host = 'localhost';
$dbname = 'english_learning';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
function getQuestionsByLessonId($pdo, $lesson_id)
{
    $stmt = $pdo->prepare("SELECT id, answer FROM grammar WHERE lesson_id = ?");
    $stmt->execute([$lesson_id]);
    return $stmt->fetchAll();
}

?>