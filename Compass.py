##################################################
# Python implementation of the Political Compass #
# by Justin Bodnar                               #
##################################################
import mysql.connector
import matplotlib.pyplot as plt

##################################################
# get_questions() function
# pull questions from db, return as list of tuples
##################################################
def get_questions():
	# db config
	host="localhost"
	user="root"
	passwd="abc123"
	database="political_compass"
	# connect to db
	db = mysql.connector.connect( host=host, user=user, passwd=passwd, database=database )
	cursor = db.cursor()

	# execute command to grab questions
	cmd = "select * from questions"
	cursor.execute( cmd )
	rows = []
	for row in cursor:
		rows = rows + [row]
	return rows

###################
# do_strike() function
# takes in agree, answer, x_coord, y_coord
def do_strike( agree, answer, axis, weight, x_coord, y_coord ):
	strike = weight
	if answer > 1 and answer < 4:
		strike = strike / 2.0
	# if user agrees
	if answer < 3:
		# check if we need to sub on agreement
		if agree == "-":
			strike = strike * (-1)
	# else if user disagrees
	else:
		# check if we need to sub on disagreement
		if agree == "+":
			strike = strike * (-1)
	# determine how much they dis/agree
	if answer == 2 or answer == 3:
		strike = strike / 2.0

	# check which axis to strike
	if axis == "y":
		y_coord = y_coord + strike
	elif axis == "x":
		x_coord = x_coord + strike

	# return coords
	return x_coord, y_coord

######################
# take_quiz function #
######################
def take_quiz():
	cursor = get_questions()
	# set up coordinates
	x_coord = 0.0
	y_coord = 0.0
	axis = "y"

	# print output of command

	# row indices
	# 0 = id
	# 1 = question
	# 2 = axis
	# 3 = units
	# 4 = agree
	axis = 7

	for row in cursor:
		print
		# question id
		print( "ID: " + str( row[0] ) )
		# question text
		print( row[1] )
		# get axis of revolution
		axis = row[2]
		# weight (units)
		weight = row[3]
		# agree path
		agree = row[4]
		# get input
		print( "(agree) 1 - 2 - 3 - 4 (disagree)" )
		answer = input()
		print( row )
		x_coord, y_coord = do_strike( agree, answer, axis, weight, x_coord, y_coord )
		print( "(" + str( x_coord ) + ", " + str( y_coord ) + ")" )

#######################
# grade_quiz() function
# takes a 62 element list of answers within { -1, -0.5, 0.5, 1 }
def grade_quiz( answers ):
	questions = get_questions()
	x_coord = 0.0
	y_coord = 0.0
	index = 0
	for row in questions:
		x_coord, y_coord = do_strike( row[4], answers[index], row[2], row[3], x_coord, y_coord )
		index = index + 1
	return x_coord, y_coord

########################
# gen_compass() function
# simply plots a single dot
def gen_compass( x, y ):
	plt.plot( x, y, s=1000)
'''
# for testing
# build answer list

answers = []
answers = answers + [ 1, 4, 1, 4, 4, 4, 1, 1, 4, 1 ]
answers = answers + [ 1, 1, 1, 1, 1, 4, 4, 4, 1, 1 ]
answers = answers + [ 4, 4, 1, 4, 4, 1, 4, 4, 1, 1 ]
answers = answers + [ 4, 4, 4, 1, 4, 4, 1, 4, 4, 4 ]
answers = answers + [ 4, 4, 4, 4, 4, 1, 1, 1, 4, 1 ]
answers = answers + [ 4, 4, 4, 4, 4, 4, 4, 1, 1, 1 ]
answers = answers + [ 4, 4 ]

# generate random answer array
answers = []
for i in range(62):
	answers = answers + [1]

x_coord, y_coord = grade_quiz( answers )
print( "(" + str( x_coord ) + ", " + str( y_coord ) + ")" )
'''
take_quiz()
