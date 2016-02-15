SET @report_id_old=39, @report_id_new=37;
UPDATE `Report` SET `id`=@report_id_new WHERE `Report`.`id`=@report_id_old;
UPDATE `ReportGroups` SET `reportId`=@report_id_new WHERE `ReportGroups`.`reportId`=@report_id_old;
UPDATE `ReportParameters` SET `reportId`=@report_id_new WHERE `ReportParameters`.`reportId`=@report_id_old;
UPDATE `ReportRows` SET `reportId`=@report_id_new WHERE `ReportRows`.`reportId`=@report_id_old;
UPDATE `ReportUserLastUsedParams` SET `reportId`=@report_id_new WHERE `ReportUserLastUsedParams`.`reportId`=@report_id_old;