
CREATE TABLE IF NOT EXISTS `AccountCustomerAssignment`
(
  `accountId` Int(11) NOT NULL,
  `customerId` Int(11) NOT NULL,
 PRIMARY KEY (`accountId`,`customerId`)
) ENGINE = InnoDB
;

ALTER TABLE Account ENGINE = InnoDB;
ALTER TABLE AccountType ENGINE = InnoDB;
ALTER TABLE Company ENGINE = InnoDB;
ALTER TABLE CompanyUser ENGINE = InnoDB;
ALTER TABLE Customer ENGINE = InnoDB;
ALTER TABLE Donor ENGINE = InnoDB;
ALTER TABLE Report ENGINE = InnoDB;
ALTER TABLE ReportRows ENGINE = InnoDB;
ALTER TABLE TempTrans ENGINE = InnoDB;
ALTER TABLE Trans ENGINE = InnoDB;
ALTER TABLE TransRow ENGINE = InnoDB;
ALTER TABLE User ENGINE = InnoDB;

ALTER TABLE `AccountCustomerAssignment` ADD CONSTRAINT `FK_account_customer` FOREIGN KEY (`accountId`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
ALTER TABLE `AccountCustomerAssignment` ADD CONSTRAINT `FK_customer_account` FOREIGN KEY (`customerId`) REFERENCES `Customer` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `Customer` DROP `accountId`;