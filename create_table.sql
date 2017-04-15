CREATE TABLE account(account_id INT NOT NULL AUTO_INCREMENT, type INT, username VARCHAR(40), password VARCHAR(40), email VARCHAR(40), PRIMARY KEY(account_id));
    /* account_id, type, username, password, email */

CREATE TABLE media(media_id INT NOT NULL AUTO_INCREMENT, name VARCHAR(200), type VARCHAR(20), path VARCHAR(200), last_access_time TIME, account_id INT, ip INT, upload_time TIME, PRIMARY KEY (media_id), FOREIGN KEY (account_id) REFERENCES account(account_id));
    /* media_id, name, type, path, last_access_time, account_id, ip, upload_time */

CREATE TABLE downloads(download_id INT NOT NULL AUTO_INCREMENT, account_id INT, media_id INT, ip INT, download_time TIME, PRIMARY KEY (download_id), FOREIGN KEY (account_id) REFERENCES account(account_id), FOREIGN KEY (media_id) REFERENCES media(media_id));
    /* download_id, account_id, media_id, ip, download_time */


/*create table account (account_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, type INT, username VARCHAR(40), password VARCHAR(40), email VARCHAR(40));*/

/*create table media (media_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(200), type VARCHAR(20), path VARCHAR(200), last_access_time TIME, account_id INT FOREIGN KEY REFERENCES account(account_id), ip INT, upload_time TIME);*/

/*create table downloads (download_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, account_id INT FOREIGN KEY REFERENCES account(account_id), media_id INT FOREIGN KEY REFERENCES media(media_id), ip INT, download_time TIME);*/
