# Phase-1 Feature Gap Matrix (2.2, 2.3, 2.5)

## 2.2 Advanced Promotion Management

| Requirement | Status Before | Status After | Evidence |
|---|---|---|---|
| Discounts/Coupons for product/category/full purchase | Partial | Implemented | `app/Http/Controllers/PromotionController.php`, `app/Utils/PromotionUtil.php`, `resources/views/promotion/index.blade.php`, `routes/web.php` |
| Rule-based engine (BOGO, bundle, percentage) | Missing | Implemented | `app/Utils/PromotionUtil.php` (`bogo`, `bundle`, `coupon_percentage`, `coupon_fixed`) |
| Tiered discounts by volume/customer type | Partial | Implemented | `app/Utils/PromotionUtil.php` (`tiered_volume`, `target_scope=customer_group`) |

## 2.3 Loyalty Program

| Requirement | Status Before | Status After | Evidence |
|---|---|---|---|
| Point-based rewards | Implemented | Enhanced | `app/Utils/TransactionUtil.php` (ledger entries, tier bonus multiplier), `database/migrations/2026_04_22_140500_create_loyalty_point_ledgers_table.php` |
| Tiered membership | Missing | Implemented | `database/migrations/2026_04_22_140300_create_loyalty_tiers_table.php`, `app/Http/Controllers/LoyaltyTierController.php`, `resources/views/loyalty_tier/index.blade.php` |
| Loyalty analytics | Partial | Implemented | `app/Http/Controllers/LoyaltyAnalyticsController.php`, `resources/views/report/loyalty_analytics.blade.php`, `routes/web.php` |

## 2.5 Customer Facing Screen for Promotions

| Requirement | Status Before | Status After | Evidence |
|---|---|---|---|
| Display promotions at checkout | Partial | Implemented | `resources/views/sale_pos/display.blade.php`, `public/js/pos.js` |
| Real-time transaction details | Partial | Enhanced | `public/js/pos.js` (`saveFormDataToLocalStorage` payload), `resources/views/sale_pos/display.blade.php` |
| Show loyalty balance context | Partial | Implemented | `app/Http/Controllers/SellPosController.php` (`getRewardDetails`), `public/js/pos.js`, `resources/views/sale_pos/display.blade.php` |
| Customizable customer display UI | Partial | Retained + Extended | Existing `business` settings + added promo/loyalty data presentation in display view |

## Notes

- `3.2 ESL` and `3.3 Weighing Scale hardware vendor integration` are intentionally deferred to Phase-2 as agreed.
- SQL sync scripts for Phase-1 are included under `database/sql/`.
