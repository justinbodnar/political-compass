<?php

declare(strict_types=1);

require __DIR__ . '/includes/quiz_lib.php';

use function PoliticalCompass\ensure_session;
use function PoliticalCompass\load_questions;

// Toggle this flag to enable testing mode that auto-fills unanswered questions as "Disagree".
$tesintg = false;

ensure_session();
$_SESSION['tesintg'] = $tesintg;

$questionCount = count(load_questions());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Political Compass Quiz</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header class="hero">
        <div class="hero__content">
            <h1>Political Compass Quiz</h1>
            <p>
                This web version reuses the official CSV export that powers the original Python quiz and
                keeps your data in your browser. Answer <?= htmlspecialchars((string) $questionCount, ENT_QUOTES, 'UTF-8'); ?> weighted
                prompts to estimate your economic (Left ↔ Right) and social (Libertarian ↔ Authoritarian) leanings.
            </p>
            <a class="button" href="quiz.php">Start the quiz</a>
        </div>
    </header>
    <main class="container">
        <section>
            <h2>How it works</h2>
            <ol>
                <li>Questions and weights are read directly from <code>political_compass_question-weights.csv</code>.</li>
                <li>Your choices are collected via radio buttons only and processed securely on the server.</li>
                <li>A CSRF token and strict POST validation guard your responses.</li>
            </ol>
        </section>
        <section>
            <h2>Privacy &amp; Security</h2>
            <p>
                The quiz does not store submissions permanently. All POST data is validated and sanitized, and the CSV file is loaded
                from disk without granting the browser direct access to the filesystem.
            </p>
        </section>
    </main>
</body>
</html>
