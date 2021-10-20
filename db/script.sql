CREATE DATABASE `sistemasdb`;
use `sistemasdb`;

CREATE TABLE IF NOT EXISTS `user`(
`id` INT UNSIGNED AUTO_INCREMENT,
`email` VARCHAR(50) NOT NULL,
`nombre` VARCHAR(100) NULL,
`apellido` VARCHAR(100) NULL,
`password` VARCHAR(50) NOT NULL,
`image` MEDIUMBLOB NULL,
`created_at` TIMESTAMP NOT NULL  DEFAULT CURRENT_TIMESTAMP,
`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY(`id`)
);

CREATE TABLE IF NOT EXISTS `review`(
`id` INT UNSIGNED AUTO_INCREMENT,
`titulo` VARCHAR(100) NULL,
`subtitulo` VARCHAR(250) NULL,
`contenido` VARCHAR(250) NULL,
`id_user` INT UNSIGNED NOT NULL,
`created_at` TIMESTAMP NOT NULL  DEFAULT CURRENT_TIMESTAMP,
`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
FOREIGN KEY (`id_user`) REFERENCES `user`(`id`),
PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `images`(
`id` INT UNSIGNED AUTO_INCREMENT,
`image` MEDIUMBLOB NOT NULL,
`id_review` INT UNSIGNED NOT NULL,
FOREIGN KEY (`id_review`) REFERENCES `review`(`id`),
PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `comentarios`(
`id` INT UNSIGNED AUTO_INCREMENT,
`id_review` INT UNSIGNED NOT NULL,
`id_user` INT UNSIGNED NOT NULL,
`comment` VARCHAR(250) NOT NULL,
`created_at` TIMESTAMP NOT NULL  DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (`id_user`) REFERENCES `user`(`id`),
FOREIGN KEY (`id_review`) REFERENCES `review`(`id`),
PRIMARy KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `votosReview`(
`id_user` INT UNSIGNED NOT NULL,
`id_review` INT UNSIGNED NOT NULL,
`voto` BOOL NOT NULL,
FOREIGN KEY (`id_user`) REFERENCES `user`(`id`),
FOREIGN KEY (`id_review`) REFERENCES `review`(`id`),
PRIMARy KEY (`id_user`,`id_review`)
);
CREATE TABLE IF NOT EXISTS `favoritos`(
`id` INT UNSIGNED AUTO_INCREMENT,
`check` BOOL DEFAULT FALSE,
`id_user` INT UNSIGNED NOT NULL,
`id_review` INT UNSIGNED NOT NULL,
`created_at` TIMESTAMP NOT NULL  DEFAULT CURRENT_TIMESTAMP,
`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
FOREIGN KEY (`id_user`) REFERENCES `user`(`id`),
FOREIGN KEY (`id_review`) REFERENCES `review`(`id`),
PRIMARy KEY (`id`)
);

DELIMITER //
	CREATE  PROCEDURE `SP_AddUser`(
	IN _nombre TEXT(100),
	IN _apellido TEXT(50),
	IN _email TEXT(50),
	IN _password TEXT(50)
	 )
	BEGIN 
    IF (SELECT count(`id`) FROM `user` WHERE `email` = _email)>0 THEN
    BEGIN
		Select "exists" as "status";
    END;
    ELSE 
    BEGIN
   INSERT INTO `user`(`nombre`,`apellido`,`email`,`password`) 
	VALUES (_nombre,_apellido,_email,_password);
    SELECT  * FROM `user` WHERE `id` = (SELECT MAX(`id`) FROM `user`);
    END;
    END IF;
	
	END//
    
	DELIMITER //
	CREATE PROCEDURE `SP_FindUserByAuth`(
	IN _email TEXT(100), 
	IN _password TEXT(50)
	 )
	BEGIN
	SELECT * FROM `user`
	 WHERE `email` = _email AND `password` = _password   Limit 1 ;
	 
	END//
    
    DELIMITER //
	CREATE PROCEDURE `SP_UpdateImageProfile`(
	IN _user INT UNSIGNED, 
	IN _image MEDIUMBLOB
	 )
	BEGIN
    UPDATE `user` SET `image` = _image WHERE `id` = _user;
	SELECT * from `user` WHERE `id` = _user;
	 
	END//
    
    DELIMITER //
	CREATE PROCEDURE `SP_SaveReview`(
	IN _title TEXT(100), 
	IN _subtitle TEXT(100),
    IN _content TEXT(250),
    IN _id_user INT UNSIGNED
	 )
	BEGIN
    INSERT INTO `review`(`titulo`,`subtitulo`,`contenido`,`id_user`) 
    VALUES(_title,_subtitle,_content,_id_user);
	SELECT * FROM `review` WHERE `id` = (SELECT MAX(`id`) FROM `review`);
	 
	END //
    
        DELIMITER //
	CREATE PROCEDURE `SP_SaveImagesReview`(
    IN _image MEDIUMBLOB,
    IN _id_review INT UNSIGNED
	 )
	BEGIN
    INSERT INTO `images`(`image`,`id_review`) 
    VALUES(_image,_id_review);
	SELECT true as 'estatus';
	 
	END //
    
DELIMITER //
	CREATE PROCEDURE `SP_GetAllPreview`(
	 )
	BEGIN
	SELECT Distinct `review`.titulo,`review`.subtitulo,`review`.contenido,  `review`.id ,(select image from images where id_review = `review`.id Limit 1)as 'image'
    from `review` INNER JOIN `images` 
    ON `review`.id = `images`.id_review ORDER BY `review`.created_at DESC ;
	END //
    
DELIMITER //
CREATE PROCEDURE `SP_GetReviewById`(
IN _id_review INT unsigned,
IN _id INt unsigned
)
BEGIN
SELECT `review`.created_at ,`review`.titulo,`review`.subtitulo,`review`.contenido, `user`.nombre,`user`.email,`user`.apellido , `user`.image,
(SELECT COUNT(`voto`) FROM `votosreview` WHERE `id_review` = `review`.id AND `voto` IS true) as 'votos',
(SELECT `voto` FROM `votosreview` WHERE `id_user` = _id AND `id_review`=_id_review ) as 'isVoted'
from `review` INNER JOIN `user` 
ON `review`.id_user = `user`.id 
WHERE `review`.id = _id_review ;
END //
    
DELIMITER //
CREATE PROCEDURE `SP_GetComentarios`(
IN _id_review INT unsigned
)
BEGIN
SELECT A.`comment`,A.`created_at`,B.`nombre`,B.`apellido`,B.`email`,B.`image` 
FROM `comentarios` A INNER JOIN `user` B 
ON A.id_user = B.id WHERE A.id_review = _id_review ORDER BY A.`created_at`;
END //