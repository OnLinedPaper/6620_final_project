CREATE TABLE account(account_id INT NOT NULL AUTO_INCREMENT, type INT, username VARCHAR(40), password VARCHAR(40), email VARCHAR(40), PRIMARY KEY(account_id));
    /* account_id, type, username, password, email */

CREATE TABLE media(media_id INT NOT NULL AUTO_INCREMENT, name VARCHAR(200), type VARCHAR(20), path VARCHAR(200), last_access_time TIME, account_id INT, ip INT, upload_time TIME, PRIMARY KEY (media_id), FOREIGN KEY (account_id) REFERENCES account(account_id));
    /* media_id, name, type, path, last_access_time, account_id, ip, upload_time */

CREATE TABLE downloads(download_id INT NOT NULL AUTO_INCREMENT, account_id INT, media_id INT, ip INT, download_time TIME, PRIMARY KEY (download_id), FOREIGN KEY (account_id) REFERENCES account(account_id), FOREIGN KEY (media_id) REFERENCES media(media_id));
    /* download_id, account_id, media_id, ip, download_time */

CREATE TABLE interaction(account_id INT, target_id INT, contact TINYINT(1), friend TINYINT(1), foe TINYINT(1), blocked TINYINT(1), media_blocked TINYINT(1), FOREIGN KEY (account_id) REFERENCES account(account_id), FOREIGN KEY (target_id) REFERENCES account(account_id));
    /* account_id, target_id, contact, friend, foe, blocked, media_blocked */

CREATE TABLE comments(media_id INT, account_id INT, comment VARCHAR(2000));

CREATE TABLE media_metadata(media_id INT, keyword VARCHAR(40) PRIMARY KEY (media_id, keyword));

CREATE TABLE favourite(account_id INT NOT NULL, media_id INT NOT NULL, PRIMARY KEY(account_id, media_id), FOREIGN KEY(account_id) REFERENCES account(account_id) ON DELETE CASCADE, FOREIGN KEY(media_id) REFERENCES media(media_id) ON DELETE CASCADE);

CREATE TABLE list(entry_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, list_id INTEGER, account_id INTEGER, media_id INTEGER, name VARCHAR(40));
