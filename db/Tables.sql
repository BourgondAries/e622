CREATE TABLE User
(
	user_ID 	int 			NOT NULL AUTO_INCREMENT,
	username 	varchar(255)	UNIQUE,
	uploads		int,
	user_since	datetime,

	PRIMARY KEY (user_ID)

);

CREATE TABLE Image
(
	image_ID		int 			NOT NULL AUTO_INCREMENT,
	filename		varchar(255)	UNIQUE,
	upload_date 	datetime		DEFAULT NOW(),
	uploader 		int,

	PRIMARY KEY (image_ID),
	FOREIGN KEY (uploader) REFERENCES User(user_ID)

);

CREATE TABLE Tag
(
	tag_ID		int 			NOT NULL AUTO_INCREMENT,
	description	varchar(255),

	PRIMARY KEY (tag_ID)
);

CREATE TABLE PictureTag
(
	tag_ID		int				NOT NULL,
	image_ID	int 			NOT NULL,

	PRIMARY KEY (tag_ID, image_ID),
	FOREIGN KEY (tag_ID) REFERENCES Tag(tag_ID),
	FOREIGN KEY (image_ID) REFERENCES Image(image_ID)
);