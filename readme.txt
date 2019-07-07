desc:
=====
Codesnippet for a website login with mysql/mariadb and php sessions.
Ment to be modular and simple. Just to seperate/identify users.

important
=========
not ready to use. still in development.


How to use:
===========
- you need: a webserver with support for php7 and mysql/mariadb
- copy the 'pls' folder in your main directory of your webserver, say
  '/var/www/html/'. The other files are just for demonstration purpose.
- install the mysql-tables. See db_table.sql, but delete possible demonstration
  values and/or add stuff you need.
- update pls/db_config.php with your database data.
- include the 'session.php' topmost in your php-pages (mainly index.php)
- to define your own target pages such as 'activate.php' for activating email,
  edit pls/config.php. In thes pages, you have to call the logic from the
  corresponding pls-script-files. But that's easy. Look inside the examples
  (activate.php, ban.php, register.php or status.php)
- The email for the activationmail is a small tamplate. The first line is the
  subject og the email, and the placeholder for the activation-link is
  '{link_activate}', for the ban-links its '{link_ban}'.



todo:
=====
[ ] at least an option to seperate user_name from user_mail
[ ] delete unactivated users after x days 
[ ] study charsets in mysql/mariadb
[ ] use php exception handling

done:
=====
[x] remove error_reporting / display errors from all files
[x] add template for registration-email.
[x] complete 'how to use'
remove unneedet test-files.
