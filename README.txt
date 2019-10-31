About:
	Final version for district step of olympiad
	To run site, open file "index.php" on server
	You can change your database settings (name, server, user, password) in "includes/connect.php"
	You can create user account. For this click on the button "SIGN IN" on the top navigation panel
	User with account could like/dislike posts
	Only user with login "admin" can create posts

Requrements:
	-My SQL database (first in brackets - type, second in brackets (if exists) - value by default), can be found in "database/blog.sql"
		-articles
			-id (int, auto_increment)
			-title (varchar)
			-text (text)
			-pubdate (datetime, current_timestamp())
			-views (int, 0)
			-likes (int, 0)
			-dislikes (int, 0)
			-category_id (varchar, null)
		
		-categories
			-id (int, auto_increment)
			-title (varchar)
		
		-users
			-id (int, auto_increment)
			-name (varchar)
			-password (text)
			-liked (text, null)
			-disliked (text, null)
			-image_url (text, null)
	
	-Server with php support (I used xampp)
