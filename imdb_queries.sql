SELECT m.name
FROM movies m
WHERE m.year=1995;


SELECT COUNT(a.first_name)
FROM movies m
JOIN roles r ON m.id=r.movie_id
JOIN actors a ON r.actor_id=a.id
WHERE m.name="Lost in Translation";

SELECT a.first_name'First name',a.last_name'Last name'
FROM movies m
JOIN roles r ON m.id=r.movie_id
JOIN actors a ON r.actor_id=a.id
WHERE m.name="Lost in Translation";


SELECT d.first_name
FROM movies m
JOIN movies_directors md ON m.id=md.movie_id
JOIN directors d ON md.director_id=d.id
WHERE m.name="Fight Club";


SELECT COUNT(m.name)
FROM directors d
JOIN movies_directors md ON d.id=md.director_id
JOIN movies m ON md.movie_id=m.id
WHERE d.first_name="Clint" AND d.last_name="Eastwood";


SELECT m.name
FROM directors d
JOIN movies_directors md ON d.id=md.director_id
JOIN movies m ON md.movie_id=m.id
WHERE d.first_name="Clint" AND d.last_name="Eastwood";


SELECT d.first_name
FROM movies_genres mg
JOIN movies_directors md ON mg.movie_id=md.movie_id
JOIN directors d ON md.director_id=d.id
WHERE mg.genre="Horror";

SELECT a.first_name 'First name',a.last_name 'Last name'
FROM directors d
JOIN movies_directors md ON d.id=md.director_id
JOIN roles r ON md.movie_id=r.movie_id
JOIN actors a ON r.actor_id=a.id
WHERE d.first_name="Christopher" AND d.last_name="Nolan";
