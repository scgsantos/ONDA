# ONDA

### Introduction
This project was developed during the Informatic Systems course (class of 2022/23) of the Multimedia Design Bachelor's in University of Coimbra. The main purpose was to create a dynamic website using PHP and a PostgreSQL database.

### Features
ONDA is a music streaming service that provides multiple features to both listeners and artists.

* As a listener, you'll be able to:
    * create an account
    * list all the available songs and sort by attribute
    * search songs by title or artist
    * create a playlist
        * randomly, by selecting the music genre and the number of songs
        * manually, by selecting each song
    * list and remove your playlists


* As an artist, you'll be able to: 
    * create an account
    * add a song (can be part of an album)
    * list, edit and remove songs

### Preview
![This is a alt text.](/image/sample.png "This is a sample image.")

### Setup
1. Make sure [PHP](https://www.php.net/downloads.php) and [PostgresSQL](https://www.postgresql.org/download/) are running on your machine
2. Create local repo of the project: ` git clone https://github.com/scgsantos/ONDA.git `
4. Create PostgreSQL database named *ONDA* and restore from [this](ONDAdb.sql) db dump file [(+ info)](https://www.postgresql.org/docs/current/backup-dump.html): ` user=postgres password=postgres host=localhost port=5432 `
6. Go to directory containing repo folder and run ` php -S localhost:port -t ONDA `
7. Go to http://localhost:port/home.html
