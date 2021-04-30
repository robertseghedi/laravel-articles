# Laravel Articles System
Feature-full Laravel advanced plugin for managing your website's articles, categories, likes and comments with a very easy syntax. Add, move, delete any content from your system, really easy.

## Structure
- Articles
- Categories
- Likes
- Comments
 
 ## Instalation
 First, you have to install the package using composer in your project root folder:
 ```
 composer require robertseghedi/laravel-articles
 ```
 Then, you have to add the provider to your ```config/app.php``` like that:
 ```php
 // your providers

RobertSeghedi\News\NewsProvider::class,
 ```
 Run the migrate command in order to add all the required tables
  ```
  php artisan migrate
   ```
## Information
Below there are some useful essential information about this package, in order for you to know what it's using & how it functions.
### Dependecies
- [Laravel Advanced Security](https://github.com/robertseghedi/laravel-advanced-security) by **Robert Seghedi**;

This package uses **Laravel Advanced Security** to track user actions in the media system in order to know who-what posted & things like that. Educational purposes only / other purposes but on your own liability.

### Commands
 
| Command name | What it does |
| --- | --- |
| News::post($title, $content, $category_id) | Posts a new article, using only 3 essentials required fields|
| News::delete_post($article_id) | Deletes an article & all its likes and comments|
| News::comment($article_id, $text) | Posts a new comment based on the given criteria|
| News::delete_comment($comment_id) | Deletes an comment|
| News::like($article_id) | Auth user drops a like for the mentioned article |
| News::delete_like($like_id) | Deletes a like |
| News::slug($text) | Generates any string-slug |
| News::category($name) | Creates a new category with the given name |
| News::delete_category($name) | Deletes the given category all its details |
| News::move_articles($old, $new) | Moves all the articles from the `$old` category to the `$new` category |
| News::change_article_category($article, $new) | Moves the `$article` to the `$new` category |
   
## Usage

Now you can start using the package.

### 1. Include it in your controller

 ```php
use RobertSeghedi\News\Models\News;
  ```
   
### 2. Start using the tools

```php
public function add_article($title, $content, $category)
{
    $add = News::post($title, $content, $category);
    if($add) return redirect()->back()->with('success', 'Article posted.');
}
```

```php
public function delete_category($id)
{
    $deletion = News::delete_category($id);
    if($deletion) return redirect()->back()->with('success', 'The category and all its articles were deleted.');
}
```
### 3. Extract data

I **highly** recommend you to use [this Laravel Autofetcher Plugin](https://github.com/robertseghedi/laravel-autofetcher) in order to extract fresh data.

Follow this package for future updates
