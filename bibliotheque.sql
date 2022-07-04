CREATE DATABASE projet_bibliotheque;
USE projet_bibliotheque;

CREATE TABLE authors (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    lastname_author TINYTEXT NOT NULL,
    firstname_author TINYTEXT NOT NULL
);

CREATE TABLE books (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    isbn VARCHAR(13) NOT NULL,
    title VARCHAR(255) NOT NULL,
    book_date VARCHAR(4) NOT NULL,
    book_editing VARCHAR (100) NOT NULL,
    book_picture VARCHAR (255),
    author_id INTEGER NOT NULL,
    CONSTRAINT fk_book_author
    FOREIGN KEY (author_id)
    REFERENCES authors(id)
);

CREATE TABLE customers (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    customer_lastname TINYTEXT,
    customer_firstname TINYTEXT,
    customer_email VARCHAR(100),
    customer_tel VARCHAR(20)
);

CREATE TABLE borrow (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    numero_emprunt VARCHAR(100) NOT NULL,
    date_emprunt DATE NOT NULL,
    customer_id INTEGER NOT NULL,
    book_id INTEGER NOT NULL,
    CONSTRAINT fk_customer_borrow FOREIGN KEY (customer_id) REFERENCES customers(id),
    CONSTRAINT fk_book_borrow FOREIGN KEY (book_id) REFERENCES books(id)
);