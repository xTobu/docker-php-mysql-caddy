SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `db_Event`;
USE db_Event;

--
-- Table structure for table `session`
--

create table if not exists `session`
(
    `pkid`       int auto_increment                 primary key,
    `session`    varchar(255)                       null,
    `limit`      int                                null,
    `status`     int      default 1                 null,
    `deleted_at` datetime                           null,
    `updated_at` datetime    on update current_timestamp,
    `created_at` datetime      default current_timestamp
);


-- ----------------------------
-- Records of session
-- ----------------------------
BEGIN;
INSERT INTO `session` (`session`) VALUES ("總論壇(葷)");
INSERT INTO `session` (`session`) VALUES ("總論壇(素)");
COMMIT;