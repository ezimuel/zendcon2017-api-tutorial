CREATE TABLE user (
    id BINARY PRIMARY KEY,
    username VARCHAR(80) UNIQUE,
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
    user_id BINARY NOT NULL,
    book_id BINARY NOT NULL,
    review TEXT NOT NULL,
    stars INT NOT NULL
);

-- TEST DATA
INSERT INTO user
(id, username, password, role)
VALUES
('a856c675-bbf5-45e3-aa89-476760f315e4', 'test', '$2y$10$XETzLKDQKw6z1bt6c5WnlOLi71JyCpf7Mo3SFSdkegLT.OcRMfxEi', 'user'),
('357ac026-0026-472f-a316-18b8a2a35aa0', 'admin', '$2y$10$4kOO1tHw0tJ4FOjYuc84NeeUNjGWdsiuuVBcMkTAxqJIPbtuPixgu', 'admin');

INSERT INTO book
(id, title, author, publisher, pages, year, isbn)
VALUES
('53c04b62-ea6b-4f6c-9962-960b3db0e2b5', 'Modern PHP: New Features and Good Practices', 'Josh Lockhart', 'O''Reilly Media', 270, 2015, '9781491905012'),
('1411540e-bfd3-4714-85dc-b77ef92c4e39', 'PHP Objects, Patterns, and Practice', 'Matt Zandstra', 'Apress', 576, 2016, '9781484219959'),
('8028ce92-e7a3-468f-9e97-46f74d7f6e17', 'PHP and MySQL Web Development', 'Luke Welling, Laura Thomson', 'Addison-Wesley Professional', 688, 2016, '9780321833891');

INSERT INTO review
(id, user_id, book_id, review, stars)
VALUES
('c8e46839-6335-412b-956a-94fac1665971', 'a856c675-bbf5-45e3-aa89-476760f315e4', '53c04b62-ea6b-4f6c-9962-960b3db0e2b5', 'Very good reading!', 4),
('607ab5cf-c66f-4390-80af-0fb2964be3d0', 'a856c675-bbf5-45e3-aa89-476760f315e4', '1411540e-bfd3-4714-85dc-b77ef92c4e39', 'Awesome reading!', 5),
('74eec3a3-0100-4b66-8068-a6b1d8e3ed1e', 'a856c675-bbf5-45e3-aa89-476760f315e4', '8028ce92-e7a3-468f-9e97-46f74d7f6e17', 'One of my favourite PHP book!', 5);
