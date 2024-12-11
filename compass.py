"""
Python implementation of the Political Compass.

Author: Justin Bodnar
"""
import mysql.connector
import matplotlib.pyplot as plt

def get_questions():
	"""
	Retrieve questions from the database.

	Returns:
		list: A list of tuples containing the question data.
	"""
	# Database configuration
	host = "localhost"
	user = "root"
	passwd = "PASSWORD HERE"
	database = "political_compass"

	# Connect to the database
	db = mysql.connector.connect(host=host, user=user, passwd=passwd, database=database)
	cursor = db.cursor()

	# Execute command to fetch all questions
	cmd = "SELECT * FROM questions"
	cursor.execute(cmd)
	rows = [row for row in cursor]
	return rows

def do_strike(agree, answer, axis, weight, x_coord, y_coord):
	"""
	Calculate the updated coordinates based on the user's answer.

	Args:
		agree (str): Direction of agreement ('+' or '-').
		answer (int): User's answer (1: Strongly Agree to 4: Strongly Disagree).
		axis (str): Axis affected by the question ('x' or 'y').
		weight (float): The weight of the question.
		x_coord (float): Current x-coordinate.
		y_coord (float): Current y-coordinate.

	Returns:
		tuple: Updated (x_coord, y_coord).
	"""
	strike = weight
	if 1 < answer < 4:
		strike /= 2.0

	# Adjust based on agreement or disagreement
	if answer < 3:
		if agree == "-":
			strike *= -1
	elif agree == "+":
		strike *= -1

	if answer in [2, 3]:
		strike /= 2.0

	# Update the appropriate axis
	if axis == "y":
		y_coord += strike
	elif axis == "x":
		x_coord += strike

	return x_coord, y_coord

def take_quiz():
	"""
	Run the political compass quiz interactively.

	Prompts the user with questions and updates coordinates based on answers.
	"""
	questions = get_questions()
	total_questions = len(questions)

	# Initialize coordinates
	x_coord = 0.0
	y_coord = 0.0

	for i, row in enumerate(questions):
		# Display question progress
		print(f"\n\nQuestion {i + 1} of {total_questions}")
		print(row[1])  # Print the question text
		axis = row[2]
		weight = row[3]
		agree = row[4]

		# Validate user input
		while True:
			print("(agree) 1 - 2 - 3 - 4 (disagree)")
			try:
				answer = int(input())
				if answer not in [1, 2, 3, 4]:
					raise ValueError
				break
			except ValueError:
				print("Invalid input. Please enter a number between 1 and 4.")

		# Calculate the updated coordinates
		x_coord, y_coord = do_strike(agree, answer, axis, weight, x_coord, y_coord)
		print(f"Current Position: ({x_coord:.2f}, {y_coord:.2f})")

	return x_coord, y_coord

def grade_quiz(answers):
	"""
	Calculate final coordinates based on a list of answers.

	Args:
		answers (list): A list of answers (1: Strongly Agree to 4: Strongly Disagree).

	Returns:
		tuple: Final (x_coord, y_coord) representing the user's position.
	"""
	questions = get_questions()
	if len(answers) != len(questions):
		raise ValueError("Number of answers must match the number of questions.")

	x_coord = 0.0
	y_coord = 0.0
	for index, row in enumerate(questions):
		x_coord, y_coord = do_strike(row[4], answers[index], row[2], row[3], x_coord, y_coord)
	return x_coord, y_coord

def gen_compass(x, y, filename="political_compass.png"):
	"""
	Generate a political compass chart and save it as a PNG file.

	Args:
		x (float): Final x-coordinate.
		y (float): Final y-coordinate.
		filename (str): The filename to save the chart as (default: 'political_compass.png').
	"""
	# Create a figure and axis
	plt.figure(figsize=(8, 8))
	ax = plt.gca()

	# Set axis limits
	ax.set_xlim([-10, 10])
	ax.set_ylim([-10, 10])

	# Add background colors for the quadrants
	ax.fill_betweenx([0, 10], 0, 10, color="#FFCCCC", zorder=0)  # Right-Authoritarian
	ax.fill_betweenx([0, 10], -10, 0, color="#CCCCFF", zorder=0)  # Left-Authoritarian
	ax.fill_betweenx([-10, 0], 0, 10, color="#CCFFCC", zorder=0)  # Right-Libertarian
	ax.fill_betweenx([-10, 0], -10, 0, color="#FFFFCC", zorder=0)  # Left-Libertarian

	# Draw gridlines for reference
	ax.axhline(0, color='black', linewidth=1.0)  # Horizontal axis
	ax.axvline(0, color='black', linewidth=1.0)  # Vertical axis
	ax.set_xticks(range(-10, 11, 2))
	ax.set_yticks(range(-10, 11, 2))
	ax.grid(color='gray', linestyle='--', linewidth=0.5, alpha=0.7)

	# Add labels for the quadrants
	ax.text(5, 5, "Right-Authoritarian", fontsize=12, ha='center')
	ax.text(-5, 5, "Left-Authoritarian", fontsize=12, ha='center')
	ax.text(5, -5, "Right-Libertarian", fontsize=12, ha='center')
	ax.text(-5, -5, "Left-Libertarian", fontsize=12, ha='center')

	# Add axis labels
	plt.xlabel("Economic (Left - Right)", fontsize=12)
	plt.ylabel("Social (Libertarian - Authoritarian)", fontsize=12)

	# Add title
	plt.title("Your Political Compass Position", fontsize=16)

	# Plot the user's position
	plt.scatter(x, y, color="red", s=100, zorder=5)
	plt.annotate(f"({x:.1f}, {y:.1f})", (x, y), textcoords="offset points", xytext=(10, -10), fontsize=10)

	# Save the plot to a file
	plt.savefig(filename, dpi=300)
	plt.close()

# Interactive quiz
final_x, final_y = take_quiz()
gen_compass(final_x, final_y)

