# Simple Safelink

A lightweight PHP safelink and URL shortener with a modern dark, gradient UI. Links are turned into an intermediate article page with a countdown before the visitor is sent to the destination.

No database, no frontend framework, just PHP files and a folder of articles.

## Features

- **Link Converter**: paste many links at once (one per line) and turn each into a safelink. Copy results one by one or all at once.
- **URL Shortener**: create 7-character short links (`/s/abc1234`) that redirect instantly, with no countdown. Stored in a simple JSON file.
- **Two-step countdown page**: visitors land on a random article, wait for the countdown, click, then wait for a final countdown before the destination link opens.
- **Auto Safelink Script**: a JavaScript snippet you can paste into any website to convert its links into safelinks automatically.
- **Automatic article list**: every file in `resources/posts/` becomes an article, no admin panel needed.
- **Custom 404 page** for missing articles and short links.
- **Responsive design** with no extra CSS or JS framework.

## Requirements

- PHP 7.4 or newer (8.x recommended)
- Apache with `mod_rewrite` enabled (XAMPP, Laragon, or any shared hosting)
- Composer, only if you need to reinstall dependencies

## Installation

1. Clone the repository into your web root (for example `htdocs` in XAMPP):

   ```bash
   git clone https://github.com/alvici/simple-safelink.git
   ```

2. Make sure `mod_rewrite` is enabled and `.htaccess` files are allowed.
3. Open the project in your browser. The base URL is detected automatically.
4. If the `vendor/` folder is missing, install dependencies:

   ```bash
   composer install
   ```

The `resources/` folder must be writable by PHP so the shortener can save `shortlinks.json`. The file is created automatically when the first short link is made.

## Configuration

All settings live in `config/app.php`:

```php
$config['app_name']    = 'Simple Safelink';
$config['slogan']      = 'Fast, clean safelinks without the hassle.';
$config['post_author'] = 'admin';   // name shown on article pages
$config['post_ext']    = 'xhtm';    // file extension for articles
$config['countdown']   = 5;         // countdown length in seconds
```

## Pages

| URL | Description |
| --- | --- |
| `/` | Home page with the list of articles |
| `/convert` | Link Converter and URL Shortener |
| `/script` | Auto Safelink Script generator |
| `/s/{code}` | Short link redirect |
| `/{slug}` | Article page (shows the countdown when opened with `?go=`) |

## Adding Articles

Create an HTML file inside `resources/posts/`. The file name becomes the slug and the title:

```
resources/posts/how-to-create-a-safelink.xhtm
```

It will be available at:

```
https://your-domain.com/how-to-create-a-safelink
```

and displayed with the title **How To Create A Safelink**.

## Auto Safelink Script

Open `/script` on your site to get a ready-to-copy snippet. There are two modes (use only one):

- **Selected domains only**: convert links that point to the domains you list in `shorts`.
- **All links except selected domains**: convert every link except the domains listed in `exclude_domains`.

## Project Structure

```
app/Controllers    Application controllers
app/Views          Page templates and layouts
bootstrap          Application bootstrap
config             Configuration
public/assets      CSS, JavaScript, images
resources/posts    Article content
routes             Route definitions
system             Base controller and helpers
vendor             Dependencies (Flight framework)
```

## License

Free to use and modify.
