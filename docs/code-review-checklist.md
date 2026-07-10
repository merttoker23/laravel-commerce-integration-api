# Backend Code Review Checklist

This checklist is used for PHP/Laravel changes before they are merged.

## Correctness

- Does the implementation match the stated business rule?
- Are invalid and partial inputs handled explicitly?
- Are totals, status changes and stock updates calculated on the server?
- Are null, duplicate, timeout and retry scenarios covered?

## Architecture

- Are controllers limited to HTTP concerns?
- Is reusable business logic located in a service or domain component?
- Are provider-specific payloads normalized at the integration boundary?
- Does the change avoid unnecessary coupling to framework or vendor details?

## Data integrity

- Are related writes protected by a database transaction?
- Can concurrent requests oversell stock or create duplicate records?
- Are unique constraints and indexes aligned with application assumptions?
- Is the operation idempotent where retries are possible?

## Security and privacy

- Is authorization enforced at the correct boundary?
- Are inputs validated and output fields intentionally selected?
- Are webhook signatures and replay risks considered?
- Are secrets, tokens, headers or personal data excluded from logs?
- Is raw SQL parameterized?

## Performance

- Are queries bounded and paginated?
- Is there an N+1 query risk?
- Are indexes available for common filters and joins?
- Is cache invalidation handled when data changes?
- Should long-running work move to a queue or chunked process?

## Reliability and operations

- Are external calls protected by timeouts and meaningful error handling?
- Can failed operations be retried safely?
- Are logs structured and useful for diagnosis?
- Is enough context recorded without leaking sensitive data?

## Maintainability

- Are names clear and business-oriented?
- Is control flow simpler than the code it replaces?
- Are edge cases explained where the reason is not obvious?
- Are tests or executable examples updated with the behavior?

## Final reviewer question

Could another developer safely modify this workflow six months from now without relying on undocumented assumptions?