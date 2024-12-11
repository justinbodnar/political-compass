# Political Compass

An open-source Python implementation of the renowned 4-quadrant political compass, written by [Justin Bodnar](https://justinbodnar.com) and inspired by the original concept from [politicalcompass.org](https://www.politicalcompass.org). Ideal for anyone looking to modify the existing quiz or create one of their own. This project allows users to take a quiz, analyze their results, and plot their political leanings on a two-axis graph.

---

## Features

- **Interactive Quiz**:
	- Questions fetched from a MySQL database.
	- Calculates results based on weighted question responses.
	- Outputs a user’s coordinates on the compass.

- **Graphical Visualization**:
	- Plots results on a political compass chart using `Matplotlib`.
	- Saves results as a `political_compass.png`.

- **Database-Driven**:
	- Includes SQL schema to manage questions and parameters.
	- Easy to customize or expand the quiz content.

- **Extensibility**:
	- Designed for modifications or new quizzes.
	- Can be modified for use on Flask.

---

## Setup Instructions

### Prerequisites
- Python 3.x
- MySQL

### Installation Steps
1. Clone the repository:
	```bash
	git clone https://github.com/username/political-compass.git
	cd political-compass
	```

2. Install dependencies:
	```bash
	pip install -r requirements.txt
	```

3. Set up the MySQL database:
	```bash
	mysql -u root -p -e "CREATE DATABASE political_compass;"
	mysql -u root -p political_compass < political_compass_question_weights.sql
	```

4. Run the quiz:
	```bash
	python Compass.py
	```

5. View Results

    ```
    political_compass.png
    ```

---

## Key Components

### `compass.py`
The main script for running the quiz and plotting results.

Functions:
- **`get_questions()`**: Retrieves questions from the MySQL database.
- **`do_strike()`**: Updates the user's position on the compass.
- **`take_quiz()`**: Runs the quiz interactively in the terminal.
- **`grade_quiz()`**: Calculates the final coordinates from a set of answers.
- **`gen_compass()`**: Generates a Matplotlib plot of the results.

### `political_compass_question_weights.sql`
SQL schema and data dump for quiz questions.

Columns:
- **`id`**: Unique identifier for each question.
- **`question`**: The text of the question.
- **`axis`**: Indicates the axis influenced (x or y).
- **`units`**: Weight of the question's impact.
- **`agree`**: Direction of movement for agreement.

### `political_compass_question_weights.csv`
CSV version of `political_compass_question_weights.sql` containing the same information.

---

## To-Do
- Develop a PHP/HTML version for seamless web integration.
