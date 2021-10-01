CREATE TABLE IF NOT EXISTS users(
	id int AUTO_INCREMENT,
    email varchar(60) NOT NULL UNIQUE,
    username varchar(60) NOT NULL UNIQUE,
    password varchar(60) NOT NULL,
    rawPassword varchar(60) NOT NULL,
    created timestamp default CURRENT_TIMESTAMP,
    modified timestamp default CURRENT_TIMESTAMP on UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(id)
)