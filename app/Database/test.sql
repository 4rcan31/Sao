use testingmigrations;
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS followers;
SET FOREIGN_KEY_CHECKS = 0;
CREATE TABLE followers (
    follwer_id INT NOT NULL,
    following_id INT NOT NULL,
    FOREIGN KEY(follwer_id) REFERENCES users(user_id),
    FOREIGN KEY(following_id) REFERENCES users(user_id),
    PRIMARY KEY(follwer_id, following_id)
);
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS tweets;
SET FOREIGN_KEY_CHECKS = 0;
CREATE TABLE tweets (
    tweet_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    tweet_text VARCHAR(280) NOT NULL,
    num_likes INT DEFAULT(0),
    num_retweets INT DEFAULT(0),
    num_coments VARCHAR(255) DEFAULT(0),
    create_at TIMESTAMP NOT NULL DEFAULT(NOW()),
    FOREIGN KEY(user_id) REFERENCES users(user_id),
    PRIMARY KEY(tweet_id)
);
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 0;
CREATE TABLE users (
    user_id INT NOT NULL AUTO_INCREMENT,
    user_handle VARCHAR(50) NOT NULL UNIQUE,
    email_address VARCHAR(50) NOT NULL UNIQUE,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    phonenumber CHAR(10) UNIQUE,
    create_at TIMESTAMP NOT NULL DEFAULT(NOW()),
    PRIMARY KEY(user_id)
);