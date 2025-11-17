<?php

declare(strict_types=1);

require __DIR__ . '/includes/quiz_lib.php';

use function PoliticalCompass\csrf_token;
use function PoliticalCompass\ensure_session;
use function PoliticalCompass\load_questions;

$questions = load_questions();
$token = csrf_token();
$totalQuestions = count($questions);

ensure_session();
$testingMode = !empty($_SESSION['testing']);

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Political Compass Quiz</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <main class="page">
        <h1>Answer each prompt</h1>
        <p>This page only uses radio buttons and a CSRF token. Customize the markup to match your site.</p>
        <?php if ($testingMode): ?>
            <p class="note">Testing mode is on. Blank responses count as “Disagree.”</p>
        <?php endif; ?>
        <form method="post" action="results.php" autocomplete="off">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>">
            <?php foreach ($questions as $index => $question): $questionNumber = $index + 1; ?>
                <fieldset>
                    <legend>Question <?= $questionNumber; ?> of <?= $totalQuestions; ?></legend>
                    <p><?= htmlspecialchars($question['text'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <?php foreach ($answerChoices as $value => $label): ?>
                        <?php $inputId = 'q' . $question['id'] . '-' . $value; ?>
                        <label for="<?= $inputId; ?>">
                            <input
                                type="radio"
                                id="<?= $inputId; ?>"
                                name="q<?= $question['id']; ?>"
                                value="<?= $value; ?>"
                                <?php if ($value === 1 && !$testingMode): ?>required<?php endif; ?>
                            >
                            <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                        </label>
                    <?php endforeach; ?>
                </fieldset>
            <?php endforeach; ?>
            <button class="button" type="submit">Show my coordinates</button>
        </form>
    </main>
</body>
</html>
