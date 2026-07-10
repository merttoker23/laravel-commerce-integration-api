# Laravel Commerce Integration API

[![Quality checks](https://github.com/merttoker23/laravel-commerce-integration-api/actions/workflows/tests.yml/badge.svg)](https://github.com/merttoker23/laravel-commerce-integration-api/actions/workflows/tests.yml)

A sanitized Laravel/PHP backend reference implementation for **e-commerce, marketplace and external-system integration workflows**.

The repository focuses on the engineering decisions behind catalog reads, supplier synchronization, order creation, stock consistency, payment/cargo webhooks, Redis caching and integration traceability. Client code, credentials, production data and private business rules are intentionally excluded.

## Engineering scope

- Product catalog reads with filtering and Redis-backed caching
- SKU-based supplier synchronization with idempotent upserts
- Transactional order creation and stock validation
- Payment and cargo webhook processing patterns
- Integration logging for request/response traceability
- Request validation and service-oriented business logic
- Database migrations, indexes and explicit model casts
- Docker development assets and API examples
- Automated static quality checks on every push and pull request

## Architecture

```text
HTTP request
   -> Controller / Form Request
      -> Domain service
         -> Eloquent models / database transaction
         -> External provider client
         -> Integration log
```

The controllers remain thin. Validation is handled at the request boundary, while workflow and integration behavior stays in dedicated services. External payloads are normalized before they reach the domain layer.

More detail: [Architecture and trade-offs](docs/architecture.md)

## Main workflows

### Supplier synchronization

1. Fetch or receive the supplier payload.
2. Normalize provider-specific fields into an internal structure.
3. Match products by SKU/supplier SKU.
4. Upsert price, stock and product metadata idempotently.
5. Record the outcome for operational traceability.
6. Invalidate affected catalog cache entries.

### Order creation

1. Validate customer and line-item input.
2. Resolve products and verify availability.
3. Create the order and its items inside a database transaction.
4. Calculate line totals and order subtotal on the server.
5. Reserve/update stock consistently.
6. Return a stable API response.

### Webhook handling

Payment and cargo events are accepted through isolated endpoints. A production implementation should also enforce provider signatures, replay protection, idempotency keys and strict event schemas.

## API contract

The documented endpoints include:

| Method | Endpoint | Purpose |
|---|---|---|
| GET | `/api/products` | List products with filters |
| GET | `/api/products/{sku}` | Retrieve a product by SKU |
| POST | `/api/orders` | Create an order and reserve stock |
| POST | `/api/integrations/suppliers/demo/sync` | Synchronize supplier products |
| POST | `/api/webhooks/payment/demo` | Accept a payment event |
| POST | `/api/webhooks/cargo/demo` | Accept a cargo event |

Machine-readable contract: [OpenAPI specification](openapi.yaml)

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
    "country": "DE",
    "city": "Hamburg",
    "line1": "Example Street 10"
  }
}
```

## Technology

- PHP 8.2+
- Laravel 11-oriented structure
- MySQL / PostgreSQL-compatible migrations
- Redis
- REST/JSON integrations
- Docker, Nginx and PHP-FPM assets
- PHPUnit-style feature test examples
- GitHub Actions quality checks

## Repository structure

```text
app/
  Http/Controllers/Api/
  Http/Requests/
  Models/
  Services/
  Support/
database/migrations/
docs/
postman/
routes/api.php
tests/Feature/
openapi.yaml
```

## Quality and review approach

The CI workflow validates Composer metadata and checks PHP syntax across the implementation. The repository also documents the review criteria used for human-written and AI-assisted changes:

- [Code review checklist](docs/code-review-checklist.md)
- [Reviewing AI-assisted code](docs/ai-assisted-code-review.md)

The key review priorities are correctness, transaction boundaries, idempotency, security, observability, performance and maintainability. AI-generated code is treated as untrusted input until it is understood, tested and reviewed against the business rules.

## Local inspection

```bash
composer validate --strict
composer install --no-interaction --prefer-dist
find app database routes tests -name '*.php' -print0 | xargs -0 -n1 php -l
```

This is a sanitized reference implementation rather than a copy of a client production application. Provider credentials and organization-specific infrastructure are deliberately omitted.