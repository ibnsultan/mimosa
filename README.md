# Mimosa

A minimalist php + reactJS framework

It is designed to seamlessly integrate PHP and ReactJS without the need for complete separation between frontend and backend layers.

```
composer create-project ibnsultan/mimosa YOUR_PROJECT_NAME
```

## Structure

```
📁 project/
├── 📁 app/
|   ├── 📁 console/
|   |	├── 🐘 Engine.php
|   |	├── 🐘 Helpers.php
|   |	├── 🐘 Model.php
|   |	└── 🐘 Screen.php
│   ├── 📁 controllers/
│   ├── 📁 lib/
|   |	├── 🐘 Database.php
│   │   └── 🐘 Functions.php
│   ├── 📁 routes/
│   │   ├── 🐘 app.php
│   │   ├── 🐘 web.php
│   │   └── 🐘 api.php
│   ├── 📁 views/
│   │   ├── 📁 Screen/
│   │   │   ├── 🐘 Main.blade.php
│   │   │   └── ⚛️ Components.blade.jsx
│   │   └── 📁 Layouts/
│   │       ├── 🐘 app.blade.php
│   │       └── 📁 components/
│   │           └── ⚛️ global.blade.jsx
│   └── 🐘 Controller.php
├── 📁 config/
|   ├── 📁 database/
|   |	└── 🐘 <databaseDriver>.php
|   └── 🐘 app.php
├── 📁 public/
│   ├── 📁 assets/
│   ├── ⚙️ .htaccess
│   └── 📄 index.php
├── 📁 vendor/
├── ⚙️ .env
├── ⚙️ .htaccess
├── 📎 composer.json
├── 🐘 index.php
└── 📄 mimic
```

## Features

- [X] Exceptions and Error Handler
- [X] HTTP Utils (Routing, Response, Requests)
- [X] Autoloading
- [ ] Authorization & Authentication
- [ ] Database
  - [X] Models
  - [X] Migrations

## Basic Usage

Mimosa is insanely easy to use due to its simplistic and minimalistic design, it already comes in with some basic components implemented in it like routing, a way handle and render requests and responses respectively

## Routing

All routes are preload in the `app/routes` directory thefore any file defined in routes would automatically be loaded into your application

Basic Routing

```php
app->get('/', function(){
  echo 'hello world!';
});
```

Routing with a Class

```php
app->get('/', 'MyController@index');
```

## Response

**Markup**

```php
response()->markup('<h1>Hello</h1>');
```

**Json**

```php
response()->json([
  'status' => 'success',
  'data' => 'Hello',
]);
```

**With Header**

```php
response()->withHeader('key', 'value')->json([
  'status' => 'success',
  'data' => 'Hello',
]);
```

**Other Methods**

Responce comes with other methods like `plain`, `xml`, `page`, `download` [etc](https://github.com/ibnsultan/mimosa/wiki)

## Request

The request object provides an interface for accessing and manipulating the current HTTP request being handled by your application, as well as retrieving input, cookies, and files that were submitted with the request.

```php
request()->get('key');
```

The request method in request works with all request methods, whether it's get, post or file, it can even get multiple values at once or even suplements a defualt when the value is null.

Multiple

```php
$data = request()->get(['username', 'password']);

// results: array( 'username' => 'value', 'password' => 'value' )
```

Some other request methods include `file`, `param`, `try`, `rawData` etc

## Documentation

More will be covered in the Documentation section which is still in preparation, keep your eyes on the [wiki section](https://github.com/ibnsultan/mimosa/wiki)

## Contributions

Opinions, suggestion, pull requests, and anything of value
