CREATE
DATABASE project1pm;

CREATE TABLE admins
(
    aid        int AUTO_INCREMENT PRIMARY KEY,
    full_name  varchar(100),
    username   varchar(100) UNIQUE,
    email      varchar(100) UNIQUE,
    password   varchar(100),
    gender     ENUM('male','female'),
    user_type  ENUM('admin','user') DEFAULT 'user',
    status     boolean DEFAULT 0,
    image      varchar(100),
    created_at datetime,
    update_at  datetime
)