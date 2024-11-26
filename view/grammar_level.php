<?php
session_start();
include '../model/db.php';

$lesson_id = isset($_GET['lesson_id']) ? (int)$_GET['lesson_id'] : 1;

$stmt = $pdo->prepare("SELECT * FROM lessons WHERE id = ?");
$stmt->execute([$lesson_id]);
$lesson = $stmt->fetch();

if (!$lesson) {
    die("Lesson not found!");
}

$stmt = $pdo->prepare("SELECT * FROM grammar WHERE lesson_id = ?");
$stmt->execute([$lesson_id]);
$questions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($lesson['title']); ?> - Grammar Exercise</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/lessons.css">
    <link rel="stylesheet" href="../public/css/navbar.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container main-content">
        <div class="breadcrumb">
            <a href="../index.php">Home</a> > 
            <a href="lessons.php?level=<?php echo $lesson['level']; ?>">Level <?php echo $lesson['level']; ?></a> >
            <?php echo htmlspecialchars($lesson['title']); ?>
        </div>

        <div class="lesson-header">
            <h1><?php echo htmlspecialchars($lesson['title']); ?></h1>
            <p><?php echo htmlspecialchars($lesson['content']); ?></p>
        </div>

        <form action="../controller/submit_answers.php" method="POST" class="questions-form">
            <input type="hidden" name="lesson_id" value="<?php echo $lesson_id; ?>">
            <?php foreach ($questions as $index => $question): ?>
                <div class="question-item">
                <p><strong>Question <?php echo $index + 1; ?>:</strong> <?php echo htmlspecialchars($question['question']); ?></p>

                    <input type="text" name="answers[<?php echo $question['id']; ?>]" class="answer-input" placeholder="Your answer">
                </div>
            <?php endforeach; ?>

            <button type="submit" class="submit-btn">Submit Answers</button>
        </form>
    </div>
</body>
</html>
