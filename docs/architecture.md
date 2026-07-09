# Architecture Notes

## Design approach

This demo separates API controllers from business logic. Controllers are thin and delegate to service classes. Services own use-case logic such as supplier sync, order creation and webhook processing.

## Key decisions

- **Service layer:** Keeps controllers readable and testable.
- **Database transaction:** Order creation and stock reservation happen atomically.
- **Integration logs:** Every external interaction is auditable.
- **Cache boundary:** Catalog reads can be cached without affecting write workflows.
- **Idempotent supplier sync:** Products are upserted by SKU so repeated syncs are safe.

## Production improvements

- Add queue workers for large supplier imports.
- Add rate-limited API authentication.
- Add webhook signature verification.
- Add OpenAPI specification generation.
- Add monitoring, retry strategy and dead-letter logging for external providers.
