<?php
// practice_1.php
session_start();
include '../model/db.php'; // Đảm bảo file db.php có kết nối đến database

// Truy vấn tất cả câu hỏi từ database
$sql = "SELECT * FROM practice";  // Không lọc theo ID nữa, lấy tất cả câu hỏi
$result = $db->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practice Test</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>

<body>
    <div class="container">
        <h1>Practice Test</h1>

        <?php
        if ($result->num_rows > 0) {
        ?>
            <form action="submit_answer.php" method="POST">
                <?php
                // Lặp qua tất cả câu hỏi
                while ($question = $result->fetch_assoc()) {
                ?>
                    <div class="question-card">
                        <h2><?php echo htmlspecialchars($question['question']); ?></h2>

                        <input type="hidden" name="test_ids[]" value="<?php echo $question['id']; ?>">

                        <div>
                            <label>
                                <input type="radio" name="answer_<?php echo $question['id']; ?>" value="A" required>
                                <?php echo htmlspecialchars($question['option_a']); ?>
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="radio" name="answer_<?php echo $question['id']; ?>" value="B">
                                <?php echo htmlspecialchars($question['option_b']); ?>
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="radio" name="answer_<?php echo $question['id']; ?>" value="C">
                                <?php echo htmlspecialchars($question['option_c']); ?>
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="radio" name="answer_<?php echo $question['id']; ?>" value="D">
                                <?php echo htmlspecialchars($question['option_d']); ?>
                            </label>
                        </div>
                    </div>
                <?php
                }
                ?>
                <button type="submit">Submit All Answers</button>
            </form>
        <?php
        } else {
            echo "<p>Không có câu hỏi nào!</p>";
        }
        ?>
    </div>
</body>

</html>
