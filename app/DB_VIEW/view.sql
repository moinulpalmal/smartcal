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
