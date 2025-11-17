<?php

declare(strict_types=1);

require __DIR__ . '/includes/quiz_lib.php';

use function PoliticalCompass\csrf_token;
use function PoliticalCompass\ensure_session;
use function PoliticalCompass\load_questions;

$questions = load_questions();
$token = csrf_token();
$totalQuestions = count($questions);
$testingMode = false;
ensure_session();
if (!empty($_SESSION['tesintg'])) {
    $testingMode = true;
}
$answerChoices = [
    1 => 'Strongly Agree',
    2 => 'Agree',
    3 => 'Disagree',
    4 => 'Strongly Disagree',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take the Political Compass Quiz</title>
    <link rel="stylesheet" href="assets/style.css">
    <script defer src="assets/app.js"></script>
</head>
<body>
    <main class="container">
        <header class="page-header">
            <div>
                <p class="eyebrow">Secure Web Quiz</p>
                <h1>Answer each prompt</h1>
                <p class="muted">Only radio inputs are used. All POST data is validated and CSRF-protected before we calculate your position.</p>
                <?php if ($testingMode): ?>
                    <p class="muted"><strong>Testing mode:</strong> unanswered items will count as "Disagree" so you can submit the form empty.</p>
                <?php endif; ?>
            </div>
            <div class="progress" data-progress>0 / <?= htmlspecialchars((string) $totalQuestions, ENT_QUOTES, 'UTF-8'); ?> answered</div>
        </header>
        <form id="quiz-form" class="quiz" method="post" action="results.php" autocomplete="off">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>">
            <?php foreach ($questions as $index => $question): $questionNumber = $index + 1; ?>
                <article class="question" id="question-<?= $questionNumber; ?>">
                    <header>
                        <p class="eyebrow">Question <?= $questionNumber; ?> of <?= $totalQuestions; ?></p>
                        <h2><?= htmlspecialchars($question['text'], ENT_QUOTES, 'UTF-8'); ?></h2>
                    </header>
                    <div class="options" role="radiogroup" aria-labelledby="question-<?= $questionNumber; ?>">
                        <?php foreach ($answerChoices as $value => $label): ?>
                            <?php $inputId = 'q' . $question['id'] . '-' . $value; ?>
                            <label class="option" for="<?= $inputId; ?>">
                                <input
                                    type="radio"
                                    id="<?= $inputId; ?>"
                                    name="q<?= $question['id']; ?>"
                                    value="<?= $value; ?>"
                                    <?php if ($value === 1 && !$testingMode): ?>required<?php endif; ?>
                                >
                                <span><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endforeach; ?>
            <div class="quiz__actions">
                <button class="button" type="submit">Show my coordinates</button>
                <p class="muted">We do not log submissions. Your responses exist only for this calculation.</p>
            </div>
        </form>
    </main>
</body>
</html>
