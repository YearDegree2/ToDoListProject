CREATE TABLE IF NOT EXISTS TasksList
(id INT AUTO_INCREMENT NOT NULL,
name VARCHAR(255) NOT NULL,
deadline DATETIME NOT NULL,
PRIMARY KEY(id)
)ENGINE = InnoDB CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS Task
(id INT AUTO_INCREMENT NOT NULL,
name VARCHAR(255) NOT NULL,
status INT NOT NULL,
taskslist_id INT NOT NULL,
PRIMARY KEY(id),
FOREIGN KEY (taskslist_id) REFERENCES TasksList(id)
)ENGINE = InnoDB CHARACTER SET utf8;
