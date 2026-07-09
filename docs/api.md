# API Documentation

## POST /api/integrations/suppliers/demo/sync

Triggers a demo supplier product synchronization.

Response:

```json
{
  "message": "Supplier sync completed.",
  "data": { "created": 2, "updated": 0 }
}
```

## POST /api/orders

Creates a pending order and reserves stock.

Validation rules:

- `customer.name` required
- `customer.email` valid email
- `items` minimum one item
- each item needs `sku` and `quantity`

## POST /api/webhooks/payment/demo

Example payload:

```json
{
  "event": "payment.succeeded",
  "order_number": "ORD-20260101120000-123",
  "payment_id": "PAY-10001"
}
```
