<?php

declare(strict_types=1);

require __DIR__ . '/includes/quiz_lib.php';

use function PoliticalCompass\answer_label;
use function PoliticalCompass\calculate_coordinates;
use function PoliticalCompass\collect_answers;
use function PoliticalCompass\is_valid_csrf;
use function PoliticalCompass\load_questions;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: quiz.php');
    exit;
}

$questions = load_questions();
$token = filter_input(INPUT_POST, 'csrf_token', FILTER_UNSAFE_RAW);

$error = null;
$answers = [];

if (!is_valid_csrf($token)) {
    http_response_code(400);
    $error = 'Security verification failed. Please reload the quiz and try again.';
} else {
    $answers = collect_answers($questions);
    $missing = [];
    foreach ($questions as $question) {
        if (!array_key_exists($question['id'], $answers)) {
            $missing[] = $question['id'];
        }
    }

    if (!empty($missing)) {
        $error = 'Please answer every question before submitting the quiz.';
    }
}

$coordinates = [0.0, 0.0];
if ($error === null) {
    $coordinates = calculate_coordinates($questions, $answers);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <main class="container">
        <header class="page-header">
            <div>
                <p class="eyebrow">Results</p>
                <h1>Your Political Compass</h1>
                <p class="muted">Calculated exclusively from sanitized POST data.</p>
            </div>
        </header>
        <?php if ($error !== null): ?>
            <div class="alert alert--error">
                <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
                <a class="button" href="quiz.php">Return to the quiz</a>
            </div>
        <?php else: ?>
            <section class="results">
                <div class="results__coords">
                    <p>Your coordinates</p>
                    <p class="results__value">
                        Economic (x): <strong><?= number_format($coordinates[0], 2); ?></strong><br>
                        Social (y): <strong><?= number_format($coordinates[1], 2); ?></strong>
                    </p>
                </div>
                <a class="button" href="quiz.php">Retake the quiz</a>
            </section>
            <section>
                <h2>Answer summary</h2>
                <div class="answers">
                    <?php foreach ($questions as $question): ?>
                        <article class="answers__item">
                            <h3><?= htmlspecialchars($question['text'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <p><?= htmlspecialchars(answer_label($answers[$question['id']]), ENT_QUOTES, 'UTF-8'); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
