# Phase-2 ESL + Weighing Scale Guide

## What is implemented

- Real integration tracks for:
  - ESL price sync endpoint bridge
  - Live scale read via API or TCP socket
- Database audit trails:
  - ESL sync logs
  - Scale read logs
- POS live action:
  - `Read From Scale` button in weighing modal
- Product update auto-sync:
  - On product create/update, if ESL integration is enabled

## Configuration Steps

1. Go to `Business Settings -> Weighing Scale`.
2. Configure **Live Weighing Scale Integration**:
   - `Enable live scale read`
   - set either:
     - `Scale API URL` (+ optional API key), or
     - `Scale TCP Host` + `Scale TCP Port`
3. Configure **ESL Integration**:
   - `Enable ESL integration`
   - `ESL Vendor`
   - `ESL API URL`
   - `ESL API Key`
4. Click `Test ESL Connection`.

## API contract expected by this implementation

### Scale API response
`GET common_settings[scale_api_url]`

Expected JSON:
```json
{
  "weight": 0.845,
  "unit": "kg",
  "barcode": "211234500845"
}
```

### ESL adapter endpoint
`POST common_settings[esl_api_url]`

Payload:
```json
{
  "vendor": "generic",
  "product_id": 10,
  "sku": "P0001",
  "name": "Apple",
  "selling_price": 120,
  "currency": 1,
  "location": null
}
```

Any 2xx response is treated as sync success.

## Runtime routes

- `POST /integrations/esl/test`
- `POST /integrations/esl/sync-product/{id}`
- `GET /integrations/scale/read`

## Notes

- This is vendor-ready architecture: connect your vendor gateway/adapter URL and credentials.
- For pure serial/USB native drivers, a small local adapter service is recommended to expose API/TCP bridge for POS.
