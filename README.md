# Puf - PHP Ultralight Framework

Puf is a **minimalist PHP framework** designed for simplicity, speed, and ease of use. It eliminates the bloat of traditional frameworks by using **flat JSON files instead of databases**, **magic link authentication instead of passwords**, and **straightforward routing and templating**.

This base project includes a **fully functional Todo app** as an example of how to use Puf.

## 🚀 Features

### 1. **Simple Routing**
Puf includes an intuitive **router** that allows you to define clean, RESTful routes with minimal setup. Example:
```php
$router->addRoute('GET', '/hello', function () {
    echo "Hello, World!";
});
```

It also supports dynamic parameters for handling things like user IDs:
```php
$router->addRoute('GET', '/user/{id}', function ($id) {
    echo "User ID: $id";
});
```

## Handlebars-Based Templating

Puf uses Handlebars-style templating for rendering HTML views. Example:

```html
<h1>{{title}}</h1>
<p>{{description}}</p>
```

This keeps logic separate from presentation while allowing for dynamic content rendering.

## Flat-File JSON Storage (No Database!)

Instead of using a database, Puf stores all data as JSON files inside src/data/.
Example structure:

``` bash
src/data/
├── todo-abc123.json
├── todo-xyz789.json
└── users.json
```

Each Todo, user, or other entity is a separate JSON file, making it: ✅ Easy to edit manually
✅ Fast, lightweight, and portable
✅ Ideal for small apps and personal projects

Example JSON file:
``` json
{
    "id": "abc123",
    "title": "Buy groceries",
    "description": "Milk, eggs, and bread",
    "completed": false
}
```

## Magic Link Authentication (No Passwords!)

Instead of passwords, Puf exclusively uses magic links for authentication.
Users enter their email, and Puf generates a one-time-use login link that logs them in instantly.
🔑 Why Magic Links?

    More secure than passwords (No risk of leaks or weak passwords)
    User-friendly (No need to remember login details)
    Simplifies authentication (No complex hashing or database management)

Example magic link:

https://yourapp.com/magic-link?token=abcd1234

## 📂 Project Structure

``` bash
puf/
├── src/
│   ├── app.php         # Main application logic
│   ├── index.php       # Entry point
│   ├── puf/
│   │   ├── Router.php  # Routing system
│   │   ├── Auth.php    # Magic link authentication
│   │   ├── Storage.php # Flat-file JSON storage
│   │   ├── Templating.php # Handlebars-style templating
│   ├── templates/
│   │   ├── index.hbs   # Home page
│   │   ├── todo.hbs    # Todo view
│   ├── data/           # JSON-based storage
│   ├── public/         # Frontend assets (JS, CSS)
└── README.md
```

## 🎯 The Base Todo App

To help you get started, Puf includes a simple Todo app that showcases:

    Dynamic routing (GET /todos/{id})
    JSON file storage (Each Todo is a separate file)
    Basic CRUD operations (Create, update, delete Todos)
    Bootstrap-based UI

# 🔧 Getting Started

1️⃣ Clone the Repository

```bash
git clone https://github.com/fufroom/puf.git
cd puf
```

2️⃣ Start the PHP Server

```bash
php -S localhost:8000 -t src
```

3️⃣ Open in Browser

Go to:
➡️ http://localhost:8000/
4️⃣ Try the Todo App

    Add a Todo
    Edit a Todo
    Delete a Todo


# 💡 Why Use Puf?

✅ Zero config – No databases, no migrations, just PHP.
✅ Flat-file JSON storage – Fast, lightweight, and easy to work with.
✅ Secure authentication – No passwords, only magic links.
✅ Perfect for small projects & personal apps.


# ⚡️ Future Plans

    📧 Magic Link Email Sending (Currently returns token as text)
    📜 Middleware Support (For request handling)
    📁 More Examples (User authentication, settings)


# 👾 Contributing

Puf is open-source and welcomes contributions! Fork, modify, and submit a pull request.

🏗 Built by fufroom