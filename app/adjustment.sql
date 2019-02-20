CREATE TABLE `collection_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `entry_datetime` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
ALTER TABLE `citytrust`.`sold_transactions` 
ADD COLUMN `collection_type_id` INT(11) NULL DEFAULT NULL AFTER `owner_account_id`;
ALTER TABLE `citytrust`.`stock_transfer_transactions` 
ADD COLUMN `type` INT(5) NOT NULL AFTER `user_id`;

ALTER TABLE `citytrust`.`stock_transfer_transactions` 
DROP FOREIGN KEY `fk_stt_to_branches`;
ALTER TABLE `citytrust`.`stock_transfer_transactions` 
CHANGE COLUMN `to_branch_id` `to_branch_id` INT(11) NULL ,
ADD COLUMN `service_account_id` INT(11) NULL AFTER `type`;
ALTER TABLE `citytrust`.`stock_transfer_transactions` 
ADD CONSTRAINT `fk_stt_to_branches`
  FOREIGN KEY (`to_branch_id`)
  REFERENCES `citytrust`.`branches` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `citytrust`.`items` 
ADD COLUMN `repair_on_account_id` INT(11) NULL AFTER `user_id`,
ADD COLUMN `repair_datetime` DATETIME NULL AFTER `repair_on_account_id`;

ALTER TABLE `citytrust`.`items` 
ADD COLUMN `is_repair` TINYINT(1) NULL DEFAULT 0 AFTER `repair_datetime`;

ALTER TABLE `citytrust`.`stock_transfer_transactions` 
ADD COLUMN `customer_account_id` INT(11) NULL AFTER `service_account_id`;
