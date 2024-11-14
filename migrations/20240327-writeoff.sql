ALTER TABLE `document_item`
ADD `department_id` int NULL,
ADD FOREIGN KEY (`department_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE;

ALTER TABLE `document`
CHANGE `type` `type` enum('income','income_act','internal','outcome','writeoff') COLLATE 'utf8mb3_general_ci' NULL AFTER `subject_id`;
