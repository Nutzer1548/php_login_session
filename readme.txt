php_login_session
=================

desc:
=====
Codesnippet for a website login with mysql/mariadb and php sessions.
Ment to be modular and simple. Just to seperate/identify users.

ready for testing


How to use:
===========
- you need: a webserver with support for php7 and mysql/mariadb
- copy the 'pls' folder in your main directory of your webserver, say
  '/var/www/html/'. The other files are just for demonstration purpose. (But you
  my want to copy them as well ... for demonstration purpose).
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
[ ] use php exception handling

done:
=====
cleanup db_table.sql
install-script added.
reorganized db-tables (seperate tables from demo-data)

