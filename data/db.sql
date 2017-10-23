CREATE TABLE user (
    username VARCHAR(80) PRIMARY KEY,
    password VARCHAR(100) NOT NULL,
    role VARCHAR(80) DEFAULT 'user'
);

CREATE TABLE book (
    id BINARY PRIMARY KEY,
    title VARCHAR(80),
    author VARCHAR(80),
    publisher VARCHAR(80),
    pages INT NULL,
    year INT NOT NULL,
    isbn VARCHAR(13) UNIQUE NULL
);

CREATE TABLE review (
    id BINARY PRIMARY KEY,
    username VARCHAR(80) NOT NULL,
    book_id BINARY NOT NULL,
    review TEXT NOT NULL,
    stars INT NOT NULL
);

-- TEST DATA (all the users passwords are "password")
INSERT INTO user
(username, password, role)
VALUES
('user1', '$2y$10$dzIWbyW3txjt/XaF3v5hvOAc0TVl7C.FRb8YU9fQrCNVPpexX87Be', 'user'),
('user2', '$2y$10$mtbaqAxWKs9B11xuZ4pc.OAPeguw1QwlDgxU4ZqvEt8bM0wXUmOHm', 'user'),
('admin', '$2y$10$pO9gjgtsON97iF3TRUfQY.F2oqgJRyf5Z7MPev71/cAzHKo9nhJHa', 'admin');

INSERT INTO book
(id, title, author, publisher, pages, year, isbn)
VALUES
('53c04b62-ea6b-4f6c-9962-960b3db0e2b5', 'Modern PHP: New Features and Good Practices', 'Josh Lockhart', 'O''Reilly Media', 270, 2015, '9781491905012'),
('1411540e-bfd3-4714-85dc-b77ef92c4e39', 'PHP Objects, Patterns, and Practice', 'Matt Zandstra', 'Apress', 576, 2016, '9781484219959'),
('8028ce92-e7a3-468f-9e97-46f74d7f6e17', 'PHP and MySQL Web Development', 'Luke Welling, Laura Thomson', 'Addison-Wesley Professional', 688, 2016, '9780321833891');

INSERT INTO review
(id, username, book_id, review, stars)
VALUES
('c8e46839-6335-412b-956a-94fac1665971', 'user1', '53c04b62-ea6b-4f6c-9962-960b3db0e2b5', 'Very good reading!', 4),
('607ab5cf-c66f-4390-80af-0fb2964be3d0', 'user2', '1411540e-bfd3-4714-85dc-b77ef92c4e39', 'Awesome reading!', 5),
('74eec3a3-0100-4b66-8068-a6b1d8e3ed1e', 'user1', '8028ce92-e7a3-468f-9e97-46f74d7f6e17', 'One of my favourite PHP book!', 5);
