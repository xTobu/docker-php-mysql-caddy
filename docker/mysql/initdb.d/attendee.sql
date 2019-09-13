SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `db_Event`;
USE db_Event;

--
-- Table structure for table `attendee`
--

create table if not exists `attendee`
(
    `pkid`       int auto_increment
        primary key,
    `event`      varchar(50)                        null,
    `session`    varchar(20)                        null,
    `name`       varchar(20)                        null,
    `phone`      varchar(20)                        null,
    `email`      varchar(50)                        null,
    `status`     int      default 1                 null,
    `deleted_at` datetime                           null,
    `updated_at` datetime default CURRENT_TIMESTAMP null
);


-- ----------------------------
-- Records of attendee
-- ----------------------------
BEGIN;
INSERT INTO `attendee` (`event`, `session`, `name`, `phone`, `email`) VALUES ("下午茶大會", "胡椒餅", "俊翔", "0988123456", "jx@domain.tw");
INSERT INTO `attendee` (`event`, `session`, `name`, `phone`, `email`) VALUES ("下午茶大會", "泡菜煎餅", "Shirlin", "0988123456", "lee@domain.tw");
COMMIT;