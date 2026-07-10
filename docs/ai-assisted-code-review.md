# Reviewing AI-Assisted Code

AI-assisted output is treated as an untrusted draft, not as an approved implementation.

## Review process

1. Restate the business rule independently of the generated code.
2. Trace the complete data flow from request to persistence and response.
3. Verify framework APIs and package behavior against the installed version.
4. Check transaction boundaries, concurrency and idempotency.
5. Review validation, authorization, secret handling and log output.
6. Challenge failure paths: duplicate events, provider timeouts, partial writes and retries.
7. Simplify unnecessary abstractions and remove invented requirements.
8. Add or update tests and examples before merge.

## Frequent issues found in generated PHP/Laravel code

- trusting client-provided totals or status values;
- missing authorization despite having validation;
- database transactions that do not include every related write;
- race conditions around stock and duplicate webhook events;
- broad exception handling that hides operational failures;
- logging full payloads containing credentials or personal data;
- N+1 queries and unbounded result sets;
- incorrect Laravel method names or behavior from another framework version;
- abstractions that increase complexity without supporting a business need;
- tests that only verify the happy path.

## Acceptance standard

A change is accepted only when the reviewer can explain why it is correct, how it fails, how it is observed in production and how repeated execution affects the data. The same standard applies whether the first draft was written manually or with an AI tool.