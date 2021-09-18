CREATE PROCEDURE `LOGS_GetList`(
    fromDate datetime,
    toDate datetime,
    pageSize int,
    startRow int
) BEGIN
SELECT
    DATE(l.log_created) AS log_created,
    c.cnt_title AS cnt_title,
    u.usr_name AS usr_name,
    SUM(log_success = 1) AS success,
    SUM(log_success = 0) AS failed
FROM
    logs l
    LEFT JOIN users u ON l.usr_id = u.usr_id
    LEFT JOIN numbers n ON l.num_id = n.num_id
    LEFT JOIN countries c on n.cnt_id = c.cnt_id
WHERE
    l.log_created BETWEEN fromDate
    AND toDate
GROUP BY
    DATE(l.log_created)
LIMIT
    pageSize OFFSET startRow;

END