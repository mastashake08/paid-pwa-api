# API Documentation

This API provides endpoints for user authentication and payment intent creation using Stripe. Below is a detailed explanation of the available endpoints, their purpose, and the expected parameters and responses.

## Requirements

- Laravel framework
- Sanctum for API authentication
- Stripe PHP SDK (Install via composer: `composer require stripe/stripe-php`)
- Stripe secret key (Add to `.env` file as `STRIPE_SECRET`)

## Authentication

This API uses Laravel Sanctum for authentication. Ensure that Sanctum is properly configured for your application. To access the `/user` endpoint, the request must be authenticated using Sanctum.

---

## API Endpoints

### 1. **Get Authenticated User**

#### Endpoint: `GET /user`

This endpoint returns the currently authenticated user. It requires the request to be authenticated via Sanctum middleware.

#### Request:

No request body is required, but authentication is necessary via Sanctum tokens.

#### Response:

- 200 OK: Returns the user information if authenticated.
- 401 Unauthorized: If the request is not authenticated.

#### Example Response:
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "johndoe@example.com",
  "created_at": "2023-05-01T12:00:00.000000Z",
  "updated_at": "2023-05-01T12:00:00.000000Z"
}
```

### 2. **Create Payment Intent (POST)**

#### Endpoint: `POST /create-intent`

This endpoint creates a new payment intent using the Stripe API.

#### Request:

| Parameter | Type   | Description                  |
|-----------|--------|------------------------------|
| amount    | int    | The amount to charge (in cents). |
| currency  | string | Currency for the payment (default: `usd`). |

#### Example Request Body:
```json
{
  "amount": 5000
}
```

#### Response:

- 200 OK: Returns the Stripe Payment Intent object.
- 400 Bad Request: If Stripe API key is missing or invalid, or required fields are not provided.

#### Example Response:
```json
{
  "id": "pi_1F2ZyE2eZvKYlo2Cz9h9bYPs",
  "object": "payment_intent",
  "amount": 5000,
  "currency": "usd",
  "status": "requires_payment_method"
}
```

### 3. **Create Payment Intent (GET)**

#### Endpoint: `GET /create-intent`

This endpoint is identical to the `POST /create-intent` endpoint but accepts parameters as query strings in the URL.

#### Request:

| Query Parameter | Type   | Description                  |
|-----------------|--------|------------------------------|
| amount          | int    | The amount to charge (in cents). |
| currency        | string | Currency for the payment (default: `usd`). |

#### Example Request URL:
```
GET /create-intent?amount=5000&currency=usd
```

#### Response:

- 200 OK: Returns the Stripe Payment Intent object.
- 400 Bad Request: If Stripe API key is missing or invalid, or required fields are not provided.

#### Example Response:
```json
{
  "id": "pi_1F2ZyE2eZvKYlo2Cz9h9bYPs",
  "object": "payment_intent",
  "amount": 5000,
  "currency": "usd",
  "status": "requires_payment_method"
}
```

---

## Environment Configuration

To make the Stripe API calls, ensure your `.env` file contains the following configuration:

```env
STRIPE_SECRET=your_stripe_secret_key
```

Replace `your_stripe_secret_key` with your actual Stripe secret key.

---

## Notes

- The API is set to work with the Stripe test environment by default. Remember to switch to live keys when going to production.
- The `amount` parameter should always be provided in cents. For example, $50.00 should be passed as `5000`.
- Both POST and GET methods are available for creating a payment intent, but using POST is recommended for secure transactions.

## Error Handling

In case of an error with the Stripe API or authentication failure, appropriate HTTP status codes (400, 401, etc.) will be returned, along with a descriptive message.