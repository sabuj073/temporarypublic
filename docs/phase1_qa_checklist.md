# Phase-1 QA and UAT Checklist

## 1) DB Sync
- Apply SQL files:
  - `database/sql/2026_04_22_gift_card_system.sql`
  - `database/sql/2026_04_22_phase1_promotions_loyalty.sql`
- Verify tables/columns:
  - `promotions`, `promotion_usages`, `loyalty_tiers`, `loyalty_point_ledgers`
  - `transactions.promotion_code`, `transactions.promotion_discount_amount`
  - `contacts.loyalty_tier_id`, `contacts.lifetime_sale_total`

## 2) Promotion Engine
- Create promotions:
  - Coupon fixed
  - Coupon percentage
  - BOGO
  - Bundle
  - Tiered volume
- In POS:
  - Add products and apply promotion code from discount modal.
  - Confirm total discount increases and final payable changes.
- On save:
  - Confirm `transactions.promotion_discount_amount` populated.
  - Confirm `promotion_usages` rows inserted for final sales.

## 3) Loyalty Tiers
- Create at least 3 tiers (Silver/Gold/Platinum) using `/loyalty-tiers`.
- Make sales for a test customer and verify:
  - `contacts.total_rp` updates
  - `contacts.lifetime_sale_total` updates
  - `contacts.loyalty_tier_id` is assigned/upgraded by threshold

## 4) Loyalty Analytics
- Open `/reports/loyalty-analytics`.
- Verify:
  - points earned/redeemed summary
  - members by tier
  - tier-wise sales contribution

## 5) Customer Display Upgrade
- Open POS and customer display tab.
- Add/remove products, apply promotion code, redeem points.
- Verify display screen updates:
  - promotion code
  - promotion discount
  - loyalty redeemed amount
  - current payable/balance sections

## 6) Regression Checks
- Cash/card/advance/gift-card payments still finalize correctly.
- Edit sale updates payment status and reward points correctly.
- Draft/proforma saves do not create promotion usage entries.
- Reward expiry command still runs without errors.
