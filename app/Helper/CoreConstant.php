<?php

#region [Global Constants]
const SOFT_DELETE_YES = 1;
const SOFT_DELETE_NO = 0;
#endregion

#region [Booking table constants]
const BOOKING__STATUS_INACTIVE = 0;
const BOOKING__STATUS_ADVANCE_CASH_RECEIVED = 1;
const BOOKING__STATUS_READY_TO_DELIVER = 2;
const BOOKING__STATUS_DELIVERED = 3;
const BOOKING__STATUS_CANCELED = 4;
#endregion

const TAKE_PRODUCT_FOR_SHOP_PAGE = 8;


#region [Item table constants]
#endregion

#region [Purchase Item Barcode Table Constants]
const PURCHASE_ITEM_BARCODE__SOFT_DELETE_YES = 1;
const PURCHASE_ITEM_BARCODE__SOFT_DELETE_NO = 0;
#endregion

#region [Purchase Detail Table Constants]
const PURCHASE_DETAIL__BARCODE_GENERATED = 1;
const PURCHASE_DETAIL__BARCODE_NOT_GENERATED = 0;

const PURCHASE_DETAIL__SOFT_DELETE_YES = 1;
const PURCHASE_DETAIL__SOFT_DELETE_NO = 0;
#endregion

const IS_APPROVED = 1;
const IS_NOT_APPROVED = 0;
#endregion
