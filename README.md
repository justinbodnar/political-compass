# Political Compass
reverse engineered version of the 4-panel compass found on politicalcompass.org

# quick start

pip install -r requirements.txt

mysql -u username -p database_name < political_compass_question_weights.sql
python Compass.py

# political-compass-question-weights.csv

a csv representation of the political commpass quiz. each row contains a 'id' and the 'question' text for that id. an 'axis' is defined showing which direction the compass is affected by the question (up-down or left-right). the 'agree' column defines which direction the point should move for an user that agrees. obviously, disagreeing will move in the opposite direction. the 'units' column defines the distance between an answer of 'completely agree' and 'completely disagree.' this is a max distance. being that the possible answers are within { 1, 2, 3, 4 }, the difference between each of these is constant, and is ( units/4 ) for any question. when calculating results from a list of answers, we assume the point begins at the center within this range and AT MOST we move a point (units/2) in the appropriate direction. in this way we maintain accuracy comparable to the original quiz.

# political-compass-question-weights.sql

a backup of the MySQL database holding the question weights

# Compass.py

contains the following functions:

get_questions()

connects to the sql server and gets the data regarding the questions

do_strike( agree, answer, axis, weight, x_coord, y_coord ):

takes in a users answer, fields from the database row for the question, and the users current coordinates.
outputs the appropriatly struck coordinates.

take_quiz():

launches a quiz to be taken through the terminal.
results are graphed in matplotlib

grade_quiz( answers ):

grades a set of answers, and launches the graphed result in matplotlib.
answers are represented as a list of size 64, with elements within { 1, 2, 3, 4 }.

gen_compass( x, y )

graphs coordinates on a matplotlib graph and displays it to the screen

# paginate_quiz.py

a rough draft of the code to paginate the quiz for user submission, using flask/jinja.



