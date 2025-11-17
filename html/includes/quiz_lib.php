<?php

declare(strict_types=1);

namespace PoliticalCompass; // simple namespace for shared helpers

use RuntimeException;
use SplFileObject;

/**
 * Absolute path to the canonical CSV data source.
 */
const CSV_FILE = __DIR__ . '/../../political_compass_question-weights.csv';

/**
 * Lazily load and memoize all quiz questions from the CSV export.
 *
 * @return array<int, array{id:int,text:string,axis:string,units:float,agree:string}>
 */
function load_questions(): array
{
    static $questions = null;
    if ($questions !== null) {
        return $questions;
    }

    $csvPath = realpath(CSV_FILE);
    if ($csvPath === false || !is_readable($csvPath)) {
        throw new RuntimeException('Question data file is missing or unreadable.');
    }

    $file = new SplFileObject($csvPath);
    $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);

    $questions = [];
    $isHeader = true;
    foreach ($file as $row) {
        if ($row === false || $row === [null] || $row === null) {
            continue;
        }

        if ($isHeader) {
            $isHeader = false;
            continue; // skip the header line
        }

        [$id, $question, $axis, $units, $agree] = array_pad($row, 5, '');
        $questions[] = [
            'id' => (int) $id,
            'text' => trim((string) $question),
            'axis' => strtolower((string) $axis) === 'y' ? 'y' : 'x',
            'units' => (float) $units,
            'agree' => trim((string) $agree) === '+' ? '+' : '-',
        ];
    }

    return $questions;
}

/**
 * Convert an answer (1-4) into the effect on the axes.
 */
function apply_strike(array $question, int $answer, float $x, float $y): array
{
    $strike = $question['units'];

    if ($answer > 1 && $answer < 4) {
        $strike /= 2.0;
    }

    if ($answer < 3) {
        if ($question['agree'] === '-') {
            $strike *= -1;
        }
    } elseif ($question['agree'] === '+') {
        $strike *= -1;
    }

    if ($answer === 2 || $answer === 3) {
        $strike /= 2.0;
    }

    if ($question['axis'] === 'y') {
        $y += $strike;
    } else {
        $x += $strike;
    }

    return [$x, $y];
}

/**
 * Aggregate all answers into a final coordinate pair.
 */
function calculate_coordinates(array $questions, array $answers): array
{
    $x = 0.0;
    $y = 0.0;

    foreach ($questions as $question) {
        $questionId = $question['id'];
        if (!array_key_exists($questionId, $answers)) {
            continue;
        }

        $answer = $answers[$questionId];
        [$x, $y] = apply_strike($question, $answer, $x, $y);
    }

    return [$x, $y];
}

/**
 * Ensure we have an active secure session for CSRF protection.
 */
function ensure_session(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_set_cookie_params([
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();
    }
}

/**
 * Get or generate the CSRF token for the visitor.
 */
function csrf_token(): string
{
    ensure_session();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

/**
 * Validate a submitted CSRF token.
 */
function is_valid_csrf(?string $token): bool
{
    ensure_session();
    if (!isset($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], (string) $token);
}

/**
 * Sanitize all POSTed answers for the provided questions.
 *
 * @return array<int,int>
 */
function collect_answers(array $questions): array
{
    $answers = [];
    foreach ($questions as $question) {
        $field = 'q' . $question['id'];
        $value = filter_input(
            INPUT_POST,
            $field,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1, 'max_range' => 4]]
        );

        if ($value !== false && $value !== null) {
            $answers[$question['id']] = (int) $value;
        }
    }

    return $answers;
}

/**
 * Helper for mapping numeric answers to friendly labels.
 */
function answer_label(int $value): string
{
    return [
        1 => 'Strongly Agree',
        2 => 'Agree',
        3 => 'Disagree',
        4 => 'Strongly Disagree',
    ][$value] ?? 'Unknown';
}

