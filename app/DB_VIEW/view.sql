CREATE VIEW view_last_lpd_po AS 
SELECT MAX(lpd_po_no)+1 AS last_lpd_po_no
FROM purchase_order_masters
WHERE STATUS <> 'D'
