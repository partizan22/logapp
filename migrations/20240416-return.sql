ALTER TABLE `document`
CHANGE `type` `type` enum('income','income_act','internal','outcome','writeoff','internal_return') COLLATE 'utf8mb3_general_ci' NULL AFTER `subject_id`;