# Remote-Collab

Main files to open - 
1. newfile.php
  #Description
    For User to open projects->files and make changes
    Also has a chat window for communication
  #Dependent on -
    1. update.php -> Sends the changes made in the file to the server
    2. open.php -> Gets all the changes made in the file by other users from the server
    3. chat.php -> Sends the chat message to the server
    4. getChats.php -> Gets the chat messages from the server
    
2. wordGamev1.php
  #Description
    A game that generates a random word from all the project files' content and gives you 3s to enter the first word that comes to your mind when you see the word
    Game over if you run out of time or type the same word twice
  #Dependent on -
    1. genWord.php -> Generating a random keyword from the project files' content (Removes stopwords and punctuations)
    
3. draw.php
  #Description
    A game where you have to draw an image to explain a word to your teammates
  #Dependent on
    1. drawData.php -> Sends the drawing to the server
    
4. showDrawing.php
  #Description
    Gets the drawing of the player for the game
  #Dependent on
    1. getDrawing.php -> Gets the drawing from the server
    
5. getImgForStoryboard.php
  #Description
    Gets random combinations of keywords from the project, performs a google image search on them, and shows you a result, chosen randomly
  #Dependent on
    1. genWord.php -> Generating a random keyword from the project files' content
