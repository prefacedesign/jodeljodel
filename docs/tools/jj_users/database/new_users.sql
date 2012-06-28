ALTER TABLE `user_users` DROP FOREIGN KEY `fk_user_users_user_groups1`;
ALTER TABLE `user_users` DROP INDEX `fk_user_users_user_groups1`;
ALTER TABLE `user_users` DROP PRIMARY KEY, ADD PRIMARY KEY ( `id` );
ALTER TABLE `user_users` DROP `user_group_id`;

DROP TABLE `user_groups`;

DROP TABLE `aros_acos`;
DROP TABLE `aros`;
DROP TABLE `acos`;