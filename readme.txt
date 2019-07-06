desc:
=====
Codesnippet for a website login with mysql/mariadb and php sessions.
Ment to be modular and simple. Just to seperate/identify users.

How to use:
===========
- you need a webserver with support for php7 and mysql
- 
- install the mysql-tables. See db_table.sql, but delete possible demonstration values and/or add stuff you need.
- include the 'session.php' topmost in your php-pages (mainly index.php)
- 



todo:
=====
[ ] remove error_reporting / display errors from all files
[.] support for 'registering'
	[.] comparing with email-block-list
[ ] at least an option to seperate user_name from user_mail
[ ] delete unactivated users after x days 
[ ] study charsets in mysql/mariadb
[ ] use php exception handling
[ ] add template for registration-email.

done:
=====
added no-cache to index.php, for development.
[x] realized: bit in mysql works like a nightmare with php. Changed it to tinyint!
[x] session.php: cleanup. check for activated account.
cleanup activationcode for url-use.
added account activation.
[x] verification of email / registering user
