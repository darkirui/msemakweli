ALTER TABLE facilitydatabases ADD COLUMN id int(6) UNSIGNED PRIMARY KEY auto_increment;
ALTER TABLE facilitydatabases MODIFY COLUMN id INT(6) FIRST;