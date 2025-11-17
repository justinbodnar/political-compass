<?php

declare(strict_types=1);

require __DIR__ . '/includes/quiz_lib.php';

use function PoliticalCompass\calculate_coordinates;
use function PoliticalCompass\collect_answers;
use function PoliticalCompass\ensure_session;
use function PoliticalCompass\is_valid_csrf;
use function PoliticalCompass\load_questions;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: quiz.php');
    exit;
}

$questions = load_questions();
$token = filter_input(INPUT_POST, 'csrf_token', FILTER_UNSAFE_RAW);
ensure_session();
$testingMode = !empty($_SESSION['testing']);

$error = null;
$answers = [];

if (!is_valid_csrf($token)) {
    http_response_code(400);
    $error = 'Security verification failed. Reload the quiz and try again.';
} else {
    $answers = collect_answers($questions);
    $missing = [];
    foreach ($questions as $question) {
        if (!array_key_exists($question['id'], $answers)) {
            $missing[] = $question['id'];
        }
    }

    if (!empty($missing)) {
        if ($testingMode) {
            foreach ($missing as $questionId) {
                $answers[$questionId] = 3; // default to "Disagree"
            }
        } else {
            $error = 'Please answer every question before submitting the quiz.';
        }
    }
}

$coordinates = [0.0, 0.0];
if ($error === null) {
    $coordinates = calculate_coordinates($questions, $answers);
}

$clampedX = max(-10, min(10, $coordinates[0]));
$clampedY = max(-10, min(10, $coordinates[1]));
$dotLeft = (($clampedX + 10) / 20) * 100;
$dotTop = ((10 - $clampedY) / 20) * 100;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <main class="page">
        <h1>Quiz results</h1>
        <?php if ($error !== null): ?>
            <p class="note error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <a class="button" href="quiz.php">Return to the quiz</a>
        <?php else: ?>
            <p>Your coordinates are:</p>
            <p class="coords">
                Economic (x): <strong><?= number_format($coordinates[0], 2); ?></strong><br>
                Social (y): <strong><?= number_format($coordinates[1], 2); ?></strong>
            </p>
            <div class="compass">
                <div class="compass__grid">
                    <span>Authoritarian</span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span>Libertarian</span>
                    <div class="compass__axis compass__axis--x"></div>
                    <div class="compass__axis compass__axis--y"></div>
                    <div
                        class="compass__dot"
                        style="left: <?= number_format($dotLeft, 2, '.', ''); ?>%; top: <?= number_format($dotTop, 2, '.', ''); ?>%;"
                        aria-label="<?= 'Coordinates ' . number_format($coordinates[0], 2) . ', ' . number_format($coordinates[1], 2); ?>"
                        role="img"
                    ></div>
                </div>
                <p class="note">Horizontal axis = economic (Left ↔ Right). Vertical axis = social (Libertarian ↔ Authoritarian).</p>
            </div>
            <a class="button" href="quiz.php">Retake the quiz</a>
        <?php endif; ?>
    </main>
</body>
</html>
