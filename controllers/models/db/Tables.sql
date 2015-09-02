CREATE TABLE Privilege
(
	privilege_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	description VARCHAR(255),

	PRIMARY KEY (privilege_id)
);

INSERT INTO Privilege (privilege_id, description) VALUES (0, 'root');
INSERT INTO Privilege (privilege_id, description) VALUES (1, 'administrator');
INSERT INTO Privilege (privilege_id, description) VALUES (2, 'moderator');
INSERT INTO Privilege (privilege_id, description) VALUES (3, 'user');
INSERT INTO Privilege (privilege_id, description) VALUES (4, 'viewer');
INSERT INTO Privilege (privilege_id, description) VALUES (5, 'banned');

CREATE TABLE User
(
	user_ID BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	username VARCHAR(26) UNIQUE,
	email VARCHAR(255),
	user_since DATETIME,
	privilege BIGINT UNSIGNED DEFAULT 3,
	password_hash VARCHAR(255),

	PRIMARY KEY (user_ID),
	FOREIGN KEY (privilege) REFERENCES Privilege(privilege_id)
);

CREATE TRIGGER user_since_creation BEFORE INSERT ON User
FOR EACH ROW
SET NEW.user_since = NOW();

INSERT INTO User (user_ID, username, privilege) VALUES (0, 'root', 0);

CREATE TABLE Media
(
	media_ID BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	filename VARCHAR(18) UNIQUE,
	description VARCHAR(1024),
	upload_date DATETIME,
	uploader BIGINT UNSIGNED,

	PRIMARY KEY (media_ID),
	FOREIGN KEY (uploader) REFERENCES User(user_ID)

);

ALTER TABLE User ADD profile_media_ID BIGINT UNSIGNED;
ALTER TABLE User ADD FOREIGN KEY (profile_media_ID) REFERENCES Media(media_ID);

CREATE TRIGGER media_creation BEFORE INSERT ON Media
FOR EACH ROW
SET NEW.upload_date = NOW();

CREATE TABLE Tag
(
	tag_ID BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	description VARCHAR(255) UNIQUE,

	PRIMARY KEY (tag_ID)
);

INSERT INTO Tag (tag_ID, description) VALUES (0, 'sfw');
INSERT INTO Tag (tag_ID, description) VALUES (1, 'qsfw');
INSERT INTO Tag (tag_ID, description) VALUES (2, 'nsfw');

CREATE TABLE MediaTag
(
	tag_ID BIGINT UNSIGNED NOT NULL,
	media_ID BIGINT UNSIGNED NOT NULL,
	placing INT UNSIGNED NOT NULL,

	PRIMARY KEY (tag_ID, media_ID),
	FOREIGN KEY (tag_ID) REFERENCES Tag(tag_ID),
	FOREIGN KEY (media_ID) REFERENCES Media(media_ID) ON DELETE CASCADE
);

CREATE TABLE UserFeedback
(
	user_ID BIGINT UNSIGNED NOT NULL,
	media_ID BIGINT UNSIGNED NOT NULL,
	upvote BOOLEAN DEFAULT FALSE,
	downvote BOOLEAN DEFAULT FALSE,
	favorite BOOLEAN DEFAULT FALSE,

	PRIMARY KEY (user_ID, media_ID),
	FOREIGN KEY (user_ID) REFERENCES User(user_ID),
	FOREIGN KEY (media_ID) REFERENCES Media(media_ID) ON DELETE CASCADE
);

ALTER TABLE UserFeedback ADD CONSTRAINT userfeedback_unique_key UNIQUE (media_ID, user_ID);

CREATE TABLE Comment
(
	comment_ID BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	user_ID BIGINT UNSIGNED,
	media_ID BIGINT UNSIGNED,
	comment VARCHAR(1024),
	comm_date DATETIME,

	PRIMARY KEY (comment_ID),
	FOREIGN KEY (user_ID) REFERENCES User(user_ID),
	FOREIGN KEY (media_ID) REFERENCES Media(media_ID) ON DELETE CASCADE
);

CREATE TRIGGER comment_creation BEFORE INSERT ON Comment
FOR EACH ROW
SET NEW.comm_date = NOW();

CREATE TABLE MediaLink
(
	from_id BIGINT UNSIGNED UNIQUE,
	to_id BIGINT UNSIGNED UNIQUE,

	PRIMARY KEY (from_id),
	FOREIGN KEY (from_id) REFERENCES Media(media_ID) ON DELETE CASCADE,
	FOREIGN KEY (to_id) REFERENCES Media(media_ID) ON DELETE CASCADE
);
