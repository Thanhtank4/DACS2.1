<?php
session_start();
include '../model/db.php';

$results = isset($_SESSION['results']) ? $_SESSION['results'] : null;
$lesson_id = isset($_GET['lesson_id']) ? (int)$_GET['lesson_id'] : 0;

if (!$results) {
    die("No results found!");
}

$score = $results['score'];
$total = $results['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Lesson Results</h1>
        <p>You scored <?php echo $score; ?> out of <?php echo $total; ?>.</p>
        <a href="grammar_level.php?lesson_id=<?php echo $lesson_id; ?>" class="btn">Try Again</a>
        <a href="lessons.php" class="btn">Back to Lessons</a>
    </div>
</body>
</html>
