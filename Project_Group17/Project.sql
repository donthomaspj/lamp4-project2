/*Drop database if exists and create a new one 
Author: Don Thomas*/
Drop database if exists employees;
Create Database Employees charset utf8;


USE Employees;
drop table if exists Employees;

CREATE TABLE if not exists Employees(
    ID int(11) NOT NULL AUTO_INCREMENT,
    Name varchar(100) NOT NULL,
    Surname varchar(100) NOT NULL,
    PRIMARY KEY(id)
);
/*
UNIQUE VALUES

Alter table Employees ADD UNIQUE INDEX(firstName,middleName,lastName);
Alter table Employees ADD UNIQUE (firstName,middleName,lastName);

/*
user
CREATE USER 'project_Group17'@'localhost' identified BY '!Project17!';

GRANT ALL PRIVILEGES ON Employees.* TO 'Project'@'localhost';
*/