php_login_session
=================

Description:
============
Codesnippet for a website login with mysql/mariadb and php sessions.
Ment to be modular and simple. Just to seperate/identify users.


Status: ready for testing
-------------------------


What you need:
==============
- a webserver with php7 support
- a mysql/mariadb database server
- a little knowledge about php, to incorporate the script logic into your pages.



Installation:
=============
- copy the 'pls' folder in the same directory where your 'index.php' lifes.
- update pls/db_config.php with your database data.
- copy the 'install' folder in the same directory, where your 'pls' directory.
  you can and maybe want to rename it from 'install' to something unpredictable,
  say 'eriofvntpdkq'.
- install the database by calling the index.php file inside the installtion
  directory (i.e.: https://example.dom/eriofvntpdkq/index.php) and follow the
  instructions there.
- if you want to, copy the other files es well. They demonstrate how you can
  use this script.


Customisation / Integration:
============================
- include the 'session.php' topmost in your php-pages (mainly index.php) with
  <?php require_once('session.php'); ?>
- edit pls/config.php to customize pages and error messages.
- to define your own target pages such as 'activate.php' for activating email,
  edit pls/config.php. In thes pages, you have to call the logic from the
  corresponding pls-script-files. But that's easy. Look inside the examples
  (activate.php, ban.php, register.php or status.php)
- The email for the activationmail is a small tamplate. The first line is the
  subject og the email, and the placeholder for the activation-link is
  '{link_activate}', for the ban-links its '{link_ban}'.





Tasks:
======
[ ] at least an option to seperate user_name from user_mail
[ ] delete unactivated users after x days 
[ ] use php exception handling 
[ ] add some 'confirm' checkbox to the registration form
[ ] plausibility check for emails


Done:
=====
- include/require-paranoia: make includes use full path.
- prevent spamming by ip address.
 

