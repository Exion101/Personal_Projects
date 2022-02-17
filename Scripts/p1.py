# Components of language
gamma = ['a','b','c','e','d','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z']
delta = ['.']
phi = ['@']

def intro():
    print("Project 1 for CS 341")
    print("Section number: ")
    print("Semester: Spring 2022")
    print("Written by: Joan Escamilla, je232")
    print("Instructor: Marvin Nakayama, marvin@njit.edu")

def getString():
    choice = input("Enter a String (y or n): ")
    if choice.lower() == 'y':
        email = input("Enter String: ")
    elif choice.lower() == 'n':
        print("Program Ended")
        exit()
    return email

def trapState(str):
    for letter in str:
        print("Trap State: {}".format(letter))

def q1(str):
    if str[0] in gamma:
        print("Q1: Start State")
        q2(str)
    else:
        trapState(str)

def q2(str):
    print("Q2: {}".format(str[0]))
    if str[0] in gamma:
        q2(str[1:])
    elif str[0] in delta:
        q1(str)
    elif str[0] in phi:
        q3(str[1:])
    else:
        try:
            print("{} in Trap State".format(str[0]))
        except IndexError:
            pass
        return 
        
def q3(str):
    if str[0] in gamma:
        q4(str[1:])
    else:
        try:
            print("{} in Trap State".format(str[0]))
        except IndexError:
            pass
        return 
def q4(str):
    print("Q4 : {}".format(str[0]))
    if str[0] in gamma:
        q4(str[1:])
    elif str[0] in delta:
        q5(str[1:])
    else:
        print(str[0] in gamma)
        try:
            print("{} in Trap State".format(str[0]))
        except IndexError:
            pass
        return

def q5(str):
    if str[0] == 'o':
        q6(str[1:])
    elif str[0] in gamma:
        q4(str[1:])
    else:
        try:
            print("{} in Trap State".format(str[0]))
        except IndexError:
            pass
        return

def q6(str):
    if str[0] in delta:
        q5(str[1:])
    elif str[0] == 'r':
        q7(str[1:])
    elif str[0] in gamma:
        q4(str[1:])
    elif len(str) == 0:
        try:
            print("{} in Trap State".format(str[0]))
        except IndexError:
            pass
        return 

def q7(str):
    print("Q7 : {}".format(str[0]))
    if str[0] in delta:
        q5(str[1:])
    elif str[0] == 'g':
        q8(str[1:])
    elif str[0] in gamma:
        q4(str[1:])
    else:
        try:
            print("{} in Trap State".format(str[0]))
        except IndexError:
            pass
        return 

# End State
def q8(str):
    if len(str) == 0:
        print("{} in q8 success".format(email))
    elif str[0] in delta:
        q5(str[1:])
    elif str[0] in gamma:
        q4(str[1:])
    else:
        try:
            print("{} in Trap State".format(str[0]))
        except IndexError:
            pass
        return 


# Start Program
if __name__ == "__main__":
    while True:
        email = getString()
        # print email then send string into DFA
        print(email)
        q1(email)
