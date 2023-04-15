# Political Compass
An accurate recreation of the renowned 4-panel political compass from politicalcompass.org

# quick start

pip install -r requirements.txt

mysql -u username -p database_name < political_compass_question_weights.sql
python Compass.py

# political-compass-question-weights.csv

This file contains a CSV representation of the political compass quiz. Each row contains an 'id' and the 'question' text for that id. An 'axis' is defined, showing which direction the compass is affected by the question (up-down or left-right). The 'agree' column defines which direction the point should move for a user that agrees, while disagreeing will move in the opposite direction. The 'units' column defines the distance between an answer of 'completely agree' and 'completely disagree.' This is a maximum distance.

Considering the possible answers are within { 1, 2, 3, 4 }, the difference between each of these is constant and is ( units/4 ) for any question. When calculating results from a list of answers, we assume the point begins at the center within this range and AT MOST we move a point (units/2) in the appropriate direction. In this way, we maintain accuracy comparable to the original quiz.

# political-compass-question-weights.sql

A backup of the MySQL database holding the question weights.

# Compass.py

- `get_questions()`: Connects to the SQL server and retrieves question data.
- `do_strike(agree, answer, axis, weight, x_coord, y_coord)`: Adjusts coordinates based on the user's answer and question parameters.
- `take_quiz()`: Initiates a quiz through the terminal with results visualized in Matplotlib.
- `grade_quiz(answers)`: Evaluates a set of answers and presents the graphed result using Matplotlib. Answers are represented as a list of 64 elements, each within the set { 1, 2, 3, 4 }.
- `gen_compass(x, y)`: Plots coordinates on a Matplotlib graph and displays the result.


# paginate_quiz.py

A rough draft of the code to paginate the quiz for user submission, using flask/jinja.



