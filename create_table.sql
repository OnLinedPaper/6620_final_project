create table account (account_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, type INT, username VARCHAR(40), password VARCHAR(40), email VARCHAR(40));
    /* account_id, type, username, password, email */

create table media (media_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(200), type VARCHAR(20), path VARCHAR(200), last_access_time TIME, account_id INT FOREIGN KEY REFERENCES account(account_id), ip INT, upload_time TIME);
    /* media_id, name, type, path, last_access_time, account_id, ip, upload_time */

create table download (download_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, account_id INT FOREIGN KEY REFERENCES account(account_id), media_id INT FOREIGN KEY REFERENCES media(media_id), ip INT, download_time TIME);
    /* download_id, account_id, media_id, ip, download_time */
