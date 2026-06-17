# API

The plugin ships with a ready-to-use [API Platform](https://api-platform.com/) integration on top of
the Sylius REST API. The mapping is registered automatically by the plugin — no extra configuration
is required.

## Endpoints

### Shop (read-only)

| Method | Path | Description |
|---|---|---|
| `GET` | `/api/v2/shop/vendors` | List enabled vendors |
| `GET` | `/api/v2/shop/vendors/{slug}` | Show a single vendor |

### Admin

| Method | Path | Description |
|---|---|---|
| `GET` | `/api/v2/admin/vendors` | List vendors |
| `GET` | `/api/v2/admin/vendors/{slug}` | Show a vendor |
| `POST` | `/api/v2/admin/vendors` | Create a vendor |
| `PUT` | `/api/v2/admin/vendors/{slug}` | Update a vendor |
| `DELETE` | `/api/v2/admin/vendors/{slug}` | Delete a vendor |
| `POST` | `/api/v2/admin/vendors/{slug}/logo` | Upload the vendor logo (`multipart/form-data`) |

Admin endpoints require an authenticated administrator with API access, following the standard
Sylius API authentication flow.

## Vendor fields

On top of the shop fields (`slug`, `name`, `email`, `logoPath`, `enabled`, `translations`,
`products`, `channels`), the admin write operations (`POST` / `PUT`) also accept:

- `extraEmails` — embedded collection of additional emails (see below);
- `position` — integer used to order vendors.

The logo binary itself is not set through these JSON operations; use the dedicated logo upload
endpoint below.

## Managing extra emails

The admin `POST`/`PUT` operations accept an embedded, writable `extraEmails` collection:

```json
{
    "name": "Acme",
    "slug": "acme",
    "email": "contact@acme.com",
    "extraEmails": [
        { "value": "sales@acme.com" },
        { "value": "support@acme.com" }
    ]
}
```

Items without an IRI are created, omitted items are removed (the relation uses orphan removal).

## Uploading a logo

The logo is uploaded as `multipart/form-data` using the `file` field:

```bash
curl -X POST "https://your-store/api/v2/admin/vendors/acme/logo" \
    -H "Authorization: Bearer <token>" \
    -F "file=@logo.png"
```

The file is validated (JPEG, PNG or WebP, max 2 MB) and stored through the same uploader used by the
admin UI.
