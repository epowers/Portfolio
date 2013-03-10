Portfolio
=========

A simple PHP web application that presents portfolio images with nice swipe of thumbnails and categories,
and works offline with tablets and phones that support HTML5.

Example:

    http://www.mrpowers.com/Portfolio

Installation:

1)  Get the code from here:

    https://github.com/epowers/Portfolio.git

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
    For some tablets, the maximum offline data allowed is 50MB, so consider this limit
    when choosing images, their size, and compression quality.

6)  Copy your resume to the Portfolio directory, name it resume.pdf

7)  Edit the index.php file.

8)  Change the $SALT and $PASSWORD variables and save.

9)  Edit the index.html, change my name to your name and your description.

10)  Copy the entire directory to your server.

Use:

Anyone who accesses the site will get the non-private images.  Users can swipe through categories and images,
double-click on images to open them in the browser or image viewer.

To access private images, type your password in the text field in the upper right and hit enter.

DO NOT GIVE AWAY YOUR PASSWORD TO ANYONE.

Once you have typed in your password, a special code will replace your password.  This code will expire
automatically in 7 days.  Give the code to someone who wants to view the private categories.

To use the application offline, bookmark it or add a home icon, then use the bookmark with the special code
or your password once.  Wait a while to make sure all of the images download for offline use.
