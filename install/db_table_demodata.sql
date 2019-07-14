-- example entries for testing

insert into users (login_email, login_pass, register_date) values
	('anton@localhost', '$2y$10$QNvFY9FFu88SCgDpUuTIvOaEXfj7UIREsywYQ1SBvj.7jGJ3aD4Qi', curdate()), -- password ist 123456
	('berta@localhost', '$2y$10$WVaoNUcRUUzqDRIMyUa6MOuHObGMMsiLh9uKK0M9/luY7Ob7jgcdW', curdate()); -- password ist qweasd

insert into blocked_email (email, added_date) values
	('zebra@localhost', curdate());

insert into task_activate_user (user_id, verify_string) values
	(1,'yDsNMZiIKLJG9AW2giOeOZwHRt4em_Izk-RyUPBs');
