/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  jundy
 * Created: Mar 11, 2017
 */

INSERT INTO `enrollment_system`.`auth_item` (`name`, `type`, `description`) VALUES ('gii', '1', 'Gii Editor');
INSERT INTO `enrollment_system`.`auth_item_child` (`parent`, `child`) VALUES ('SuperAdmin', 'gii');
INSERT INTO `enrollment_system`.`auth_item` (`name`, `type`, `description`) VALUES ('/building/*', '1', '/building/*');
INSERT INTO `enrollment_system`.`auth_item_child` (`parent`, `child`) VALUES ('SuperAdmin', '/building/*');
UPDATE `enrollment_system`.`auth_item` SET `type`='2' WHERE `name`='gii';
UPDATE `enrollment_system`.`auth_item` SET `type`='2' WHERE `name`='/building/*';
INSERT INTO `enrollment_system`.`auth_item` (`name`, `type`, `description`) VALUES ('/room/*', '1', '/room/*');
INSERT INTO `enrollment_system`.`auth_item_child` (`parent`, `child`) VALUES ('SuperAdmin', '/room/*');
INSERT INTO `enrollment_system`.`auth_item` (`name`, `type`, `description`) VALUES ('/schoolyear/*', '1', '/schoolyear/*');
INSERT INTO `enrollment_system`.`auth_item_child` (`parent`, `child`) VALUES ('SuperAdmin', '/schoolyear/*');
INSERT INTO `enrollment_system`.`auth_item` (`name`, `type`, `description`) VALUES ('/semester/*', '1', '/semester/*');
INSERT INTO `enrollment_system`.`auth_item_child` (`parent`, `child`) VALUES ('SuperAdmin', '/semester/*');

