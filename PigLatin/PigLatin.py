# translation rules defined at: https://web.ics.purdue.edu/~morelanj/RAO/prepare2.html

"""
1. If a word starts with a consonant and a vowel, put the first letter of the word at the end of the word and add "ay."
2. If a word starts with two consonants move the two consonants to the end of the word and add "ay."
3. If a word starts with a vowel add the word "way" at the end of the word.
"""

def isVowel(c): # checks if vowel
    vowel_list = ['a','e','i','o','u']
    if c in vowel_list:
        return True
    return False

def toPigLatin(word): # translates and returns a word
    vowel_end = "way"
    default_end = "ay"

    if isVowel(word[0]):
        return word+vowel_end
    else:
        if isVowel(word[1]):
            return word[1:]+ word[0] + default_end
        else:
            return word[2:] + word[:2] + default_end

def translate(sentence): # takes sentence and passes translates individual word at a time
    translation = ""

    sentence = sentence.lower()
    word_list = sentence.split()

    for word in word_list:
        translation += toPigLatin(word) + " "
    
    print(translation)

print("Translate English to Pig Latin", end="\n")

# get sentence to translate from user
choice = ""
while choice != 'n':
    sentence = input("Enter a sentence to translate: ")
    translate(sentence)

    choice = input("Translate Another Sentence? [y or n]:   ")
print("Have a Nice Day!")
