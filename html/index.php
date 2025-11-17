<?php

declare(strict_types=1);

require __DIR__ . '/includes/quiz_lib.php';

use function PoliticalCompass\ensure_session;
use function PoliticalCompass\load_questions;

// Toggle this flag while developing. When true the quiz can be submitted with unanswered prompts.
$testing = false;

ensure_session();
$_SESSION['testing'] = $testing;

$questionCount = count(load_questions());
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
        <section>
            <h1>Political Compass Quiz</h1>
            <p>This basic template reads <?= htmlspecialchars((string) $questionCount, ENT_QUOTES, 'UTF-8'); ?> weighted prompts from the CSV file and submits them securely to PHP.</p>
            <a class="button" href="quiz.php">Start the quiz</a>
        </section>
        <section>
            <h2>Testing toggle</h2>
            <p>Set <code>$testing = true;</code> in <code>index.php</code> while developing to allow blank submissions (all unanswered prompts count as “Disagree”).</p>
        </section>
    </main>
</body>
</html>
