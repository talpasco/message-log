CREATE PROCEDURE `LOGS_GetList`(
    fromDate datetime,
    toDate datetime
) BEGIN
SELECT
    DATE(l.log_created),
    c.cnt_title AS Country,
    u.usr_name AS User,
    SUM(log_success = 1) AS Success,
    SUM(log_success = 0) AS Failed
FROM
    logs l
    LEFT JOIN users u ON l.usr_id = u.usr_id
    LEFT JOIN numbers n ON l.num_id = n.num_id
    LEFT JOIN countries c on n.cnt_id = c.cnt_id
WHERE
    l.log_created BETWEEN fromDate
    AND toDate
GROUP BY
    DATE(l.log_created);

END