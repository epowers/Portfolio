Portfolio
=========

A simple PHP web application that presents portfolio images with nice swipe of thumbnails and categories,
and works offline with tablets and phones that support HTML5.

Installation:

1)  Get the code from here:

2)  Create an "images" directory underneath the code directory.

3)  Create category directories underneath the images directory.  These category directories
    can be named with spaces and some special characters, dashes, parentheses, etc.
    Categories will be sorted alphabetically, so if you want a particular order, put letters
    at the beginning of the category directory names, such as:

        A - Visual Reference
        B - Texture Painting
        C - Fine Art

4)  Create category directories for private images by including the word private.  i.e.:
        Fine Art (Private)

5)  Copy pictures in JPG format underneath each of the category directories.
    Images will be displayed in alphabetical order, so name and number them appropriately.

6)  Edit the index.php file.

7)  Change the $SALT and $PASSWORD variables and save.

8)  Copy the entire directory to your server.
