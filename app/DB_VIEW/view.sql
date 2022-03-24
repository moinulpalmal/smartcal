CREATE VIEW view_last_lpd_po AS
SELECT MAX(lpd_po_no)+1 AS last_lpd_po_no
FROM purchase_order_masters
WHERE STATUS <> 'D'

CREATE VIEW a_sticker_total_value AS
SELECT purchase_order_master_id, SUM(total_price) AS total_value
FROM a_sticker_p_o_details
WHERE STATUS <> 'D'
GROUP BY purchase_order_master_id
ORDER BY purchase_order_master_id ASC

DROP VIEW general_total_value
CREATE VIEW general_total_value AS
SELECT purchase_order_master_id, currency, SUM(total_price) AS total_value
FROM general_p_o_details
WHERE STATUS <> 'D'
GROUP BY purchase_order_master_id, currency

DROP VIEW interlining_total_value
CREATE VIEW interlining_total_value AS
SELECT purchase_order_master_id, currency, SUM(total_price) AS total_value
FROM interlining_p_o_details
WHERE STATUS <> 'D'
GROUP BY purchase_order_master_id, currency
