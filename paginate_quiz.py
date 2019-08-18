from flask import Flask
from Compass import *

app = Flask(__name__)

@app.route('/')
def gen_page():
	# get questions from database
	qs = get_questions()
	src = "<html>"
	src = src + "<head>"
	src = src + "<title>Political Compass</title>"
	src = src + "</head>"
	src = src + "<body><center>"
	src = src + "<table style='table-layout: fixed; width: 100%' border='1' cellspacing='2' cellpaddin='2'>"
	src = src + "<form action='result' method='post'>"
	for q in qs:
		src = src + "<tr>"
		src = src + "<td style='word-wrap: break-word'>" + str(q[0]) + ". " + q[1] + "</td>"
		src = src + "<td>"
		src = src + "<input type='radio' name='q_" + str(q[0]) + "' value='1'>Strongly Agree</input>"
                src = src + "<br /><input type='radio' name='q_" + str(q[0]) + "' value='2'>Agree</input>"
                src = src + "<br /><input type='radio' name='q_" + str(q[0]) + "' value='3'>Disagree</input>"
                src = src + "<br /><input type='radio' name='q_" + str(q[0]) + "' value='4'>Strongly Disagree</input"
		src = src + "</td>"
		src = src + "</tr>"
	src = src + "</table>"
	src = src + "<input type='submit' value='submit'>"
	src = src + "</center></body>"
	src = src + "</html>"
	# return source code
	return src

if __name__ == '__main__':
	app.run()
