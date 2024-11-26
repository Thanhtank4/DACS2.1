<?php
// File: ../controller/GrammarController.php
session_start();
include '../model/db.php';
include '../model/GrammarModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lesson_id = isset($_POST['lesson_id']) ? (int)$_POST['lesson_id'] : 0;
    $user_answers = isset($_POST['answers']) ? $_POST['answers'] : [];

    // Lấy câu hỏi và đáp án từ Model
    $questions = getQuestionsByLessonId($pdo, $lesson_id);

    $score = 0;
    $total = count($questions);
    $results = [];

    // Kiểm tra câu trả lời
    foreach ($questions as $question) {
        $qid = $question['id'];
        $correct_answer = strtolower(trim($question['answer']));
        $user_answer = isset($user_answers[$qid]) ? strtolower(trim($user_answers[$qid])) : '';

        if ($user_answer === $correct_answer) {
            $score++;
            $results[$qid] = 'correct';
        } else {
            $results[$qid] = 'wrong';
        }
    }

    // Gửi kết quả tới session
    $_SESSION['results'] = [
        'score' => $score,
        'total' => $total,
        'details' => $results,
    ];

    // Chuyển hướng tới view hiển thị kết quả
    header("Location: ../view/result.php?lesson_id=" . $lesson_id);
    exit();
}

