# Laravel Commerce Integration API

Professional demo backend project for **e-commerce, marketplace and supplier integration workflows**.  
This repository is designed as a portfolio-ready example for Laravel/PHP backend roles, Upwork proposals, and remote job applications.

> Built to demonstrate real-world backend thinking: product/catalog management, stock synchronization, order workflows, payment/cargo webhooks, supplier API integration, Redis caching, Dockerized local development and clean service-oriented architecture.

## What this project demonstrates

- Laravel API architecture for commerce backends
- Product, category, stock and order workflow modeling
- Supplier API synchronization with idempotent upserts
- Payment and cargo webhook handling pattern
- Service layer, request validation, DTO-like payload mapping
- Database-first thinking with migrations and indexes
- Redis cache usage for product/catalog reads
- Docker-based local environment
- Postman collection for API review
- Feature-test examples for order creation and sync logic

## Business problem solved

A common e-commerce business needs to integrate product/stock data from suppliers, receive online orders, and communicate with payment/cargo systems. This demo models that flow in a simple but production-minded way:

1. Sync products from supplier API.
2. Cache public product catalog reads.
3. Create orders with stock checks.
4. Record integration logs for traceability.
5. Receive payment and cargo webhook updates.
6. Keep the code easy to maintain through services and clear boundaries.

## Tech stack

- PHP 8.2+
- Laravel 11 style structure
- MySQL / PostgreSQL compatible migrations
- Redis cache
- Docker + Nginx + PHP-FPM
- PHPUnit feature test examples
- Postman collection

## Folder structure

```text
app/
  Http/Controllers/Api/
  Http/Requests/
  Models/
  Services/
  Support/
database/migrations/
docs/
routes/api.php
tests/Feature/
postman/
```

## Quick start

```bash
cp .env.example .env
docker compose up -d --build
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

API base URL:

```text
http://localhost:8080/api
```

## Main API endpoints

| Method | Endpoint | Purpose |
|---|---|---|
| GET | `/api/products` | List products with filters |
| GET | `/api/products/{sku}` | Get product by SKU |
| POST | `/api/orders` | Create order and reserve stock |
| POST | `/api/integrations/suppliers/demo/sync` | Sync supplier products |
| POST | `/api/webhooks/payment/demo` | Receive payment event |
| POST | `/api/webhooks/cargo/demo` | Receive cargo shipment event |

## Example order request

```json
{
  "customer": {
    "name": "Jane Customer",
    "email": "jane@example.com"
  },
  "items": [
    { "sku": "DEMO-TSHIRT-001", "quantity": 2 },
    { "sku": "DEMO-BAG-002", "quantity": 1 }
  ],
  "shipping_address": {
    "country": "TR",
    "city": "Istanbul",
    "line1": "Example Street No: 10"
  }
}
```

## Integration log sample

Every external event is recorded with request/response metadata:

```json
{
  "provider": "demo-supplier",
  "type": "product_sync",
  "status": "success",
  "external_id": "SUP-2026-0001"
}
```

## Why this is useful for clients

This project shows the kind of backend work often needed by e-commerce companies:

- Supplier XML/JSON import
- Marketplace API integration
- Cargo and payment webhooks
- Stock and order consistency
- Legacy code modernization into cleaner Laravel services

## Portfolio note

This is a sanitized demo project. It does not contain client code, secrets, production data or private business logic.
