/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  jundy
 * Created: Mar 11, 2017
 */

REPLACE INTO `enrollment_system`.`auth_item` (`name`, `type`, `description`) VALUES ('gii', '2', 'Gii Editor');
REPLACE INTO `enrollment_system`.`auth_item_child` (`parent`, `child`) VALUES ('SuperAdmin', 'gii');
REPLACE INTO `enrollment_system`.`auth_item` (`name`, `type`, `description`) VALUES ('/building/*', '2', '/building/*');
REPLACE INTO `enrollment_system`.`auth_item_child` (`parent`, `child`) VALUES ('SuperAdmin', '/building/*');
UPDATE `enrollment_system`.`auth_item` SET `type`='2' WHERE `name`='gii';
UPDATE `enrollment_system`.`auth_item` SET `type`='2' WHERE `name`='/building/*';
REPLACE INTO `enrollment_system`.`auth_item` (`name`, `type`, `description`) VALUES ('/room/*', '2', '/room/*');
REPLACE INTO `enrollment_system`.`auth_item_child` (`parent`, `child`) VALUES ('SuperAdmin', '/room/*');
REPLACE INTO `enrollment_system`.`auth_item` (`name`, `type`, `description`) VALUES ('/schoolyear/*', '2', '/schoolyear/*');
REPLACE INTO `enrollment_system`.`auth_item_child` (`parent`, `child`) VALUES ('SuperAdmin', '/schoolyear/*');
REPLACE INTO `enrollment_system`.`auth_item` (`name`, `type`, `description`) VALUES ('/semester/*', '2', '/semester/*');
REPLACE INTO `enrollment_system`.`auth_item_child` (`parent`, `child`) VALUES ('SuperAdmin', '/semester/*');
REPLACE INTO `enrollment_system`.`auth_item` (`name`, `type`, `description`) VALUES ('/subjects/*', '2', '/subjects/*');
REPLACE INTO `enrollment_system`.`auth_item_child` (`parent`, `child`) VALUES ('SuperAdmin', '/subjects/*');

