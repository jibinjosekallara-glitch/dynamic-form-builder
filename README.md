# Dynamic Form Builder (Laravel)

## Project Overview
This project is a dynamic form builder built using Laravel. It allows administrators to create forms with various field types and validations, and users can submit responses which are stored in the database. Admins can view submissions with pagination and filters.

---

## Features

- Dynamic form creation
- Multiple field types:
  - Text
  - Email
  - Number
  - Textarea
  - Dropdown
  - Checkbox
- Dynamic validation:
  - Required fields
  - String validation
  - Max length
  - Regex validation
- Custom validation messages
- Store submissions in database
- View submissions with pagination (5 per page)
- Previous submissions display with custom pagination UI
- Users list API

---

## Setup Instructions

### 1. Clone Repository
```
git clone https://github.com/jibinjosekallara-glitch/dynamic-form-builder.git
cd dynamic-form-builder
```

### 2. Install Dependencies
```
composer install
```

### 3. Configure Environment
```
cp .env.example .env
php artisan key:generate
```
Update `.env` with your database credentials:
```
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Run Migrations
```
php artisan migrate
```

### 5. Start the Server
```
php artisan serve
```

---

## URLs

### Form List
```
http://127.0.0.1:8000/forms
```

### Single Form View
```
http://127.0.0.1:8000/forms/{id}
```
Example: `http://127.0.0.1:8000/forms/1`

### Admin Panel
```
http://127.0.0.1:8000/login
```

---

## Admin Credentials

- **Email:** admin@example.com  
- **Password:** password  

*(Update as per your database if changed)*

---

## API Endpoints

### Users List
```
GET /api/users
```
Full URL:
```
http://127.0.0.1:8000/api/users
```

Sample Response:
```json
[
  {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  }
]
```

---

## Database Tables

- `forms`
- `form_fields`
- `submissions`
- `users`

---

## Validation Example

- Name field:
```php
'required|string|max:100|regex:/^[A-Za-z\s]+$/'
```

- Email field:
```php
'required|email'
```

Validation rules are applied dynamically based on the form field configuration.

---

## Author

**Jibin Jose**  
GitHub: [https://github.com/jibinjosekallara-glitch](https://github.com/jibinjosekallara-glitch)

---

## Notes

- Focused on dynamic form handling, validation, and data storage.
- Clean MVC architecture with Blade templates.
- Custom pagination implemented for admin and user submissions.
