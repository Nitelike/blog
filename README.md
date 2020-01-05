# blog
Simple `mvc` blog template. It has users accounts system and `CRUD` system for posts and categories.
# Users system
There are three types of users accounts
* **user**
* **member**
* **editor**
* **admin**

**User** can only read articles. Every person who visites site is user. <br> <br>
**Member** can read articles, add them to list of his tracked articles and change login and password from his account. Every who registered on site is **member**. <br> <br>
**Editor** can do the same things as **member** can do. But he also can create and update articles. Only **member** can become **editor**. **Editor** should have **editor** status. <br> <br>
**Admin** can do the same things as **editor** can do. But he also can delete articles, can do `CRUD` operations with categories on site, can block and delete users accounts, can change status of user account. Only **editor** can give **editor** status to account with **member** status. Nobody can add **admin** account from site.<br>

# Dependencies
* **mysql database** (there is examle in project's root directory)
* **apache server**

# Notice
This project can have a lot of security problems. Also it could have some support issues. You should be careful with all these problems.
