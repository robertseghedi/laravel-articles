<?php

namespace RobertSeghedi\News\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model, Illuminate\Http\Request, Auth;
use RobertSeghedi\LAS\Models\LAS;
use RobertSeghedi\News\Models\Article;
use RobertSeghedi\News\Models\Category;
use RobertSeghedi\News\Models\Comment;
use RobertSeghedi\News\Models\Like;
use Illuminate\Support\Facades\Crypt, Illuminate\Contracts\Encryption\DecryptException;

class News extends Model
{
    public static function post($title, $content, $category = 1)
    {
        if(Category::count() == 0) return json_encode(['error' => 'There are no categories.']);

        if(Category::count() > 0)
        {
            $author = Auth::user()->id;
            $author_ip = Crypt::encrypt(LAS::ip());
            $author_os = Crypt::encrypt(LAS::os());
            $author_browser = Crypt::encrypt(LAS::browser());

            $article = new Article();
            $article->title = $title;
            $article->content = $content;
            $article->category = $category;
            $article->author = $author;
            $article->author_ip = $author_ip;
            $article->author_os = $author_os;
            $article->author_browser = $author_browser;

            $save = $article->save();
            return $save;
        }
    }
    public static function delete_post($id)
    {
        $deletion = Article::where('id', $id)->delete();
        $delete_likes = Like::where('article_id', $id)->delete();
        $delete_comments = Comment::where('article_id', $id)->delete();
        return $deletion;
        return $delete_likes;
        return $delete_comments;
    }
    public static function comment($article, $text)
    {
        $comment = new Comment();
        $comment->text = $text;
        $comment->article_id = $article;
        $comment->created_by = Auth::user()->id;
        $comment->created_by_ip = Crypt::encrypt(LAS::ip());
        $comment->created_by_os = Crypt::encrypt(LAS::os());
        $comment->created_by_browser = Crypt::encrypt(LAS::browser());

        $save = $comment->save();

        $article_comments = Article::where('id', $article)->first()->comment_count + 1;
        $update_comments = Article::where('id', $article)->update(['comment_count' => $article_comments]);

        return $save;
        return $update_comments;
    }
    public static function delete_comment($id)
    {
        $article_comments = Article::where('id', $id)->first()->comment_count - 1;
        $update_comments = Article::where('id', $id)->update(['comment_count' => $article_comments]);

        $deletion = Comment::where('id', $id)->delete();
        return $deletion;
        return $update_comments;
    }
    public static function like($article)
    {
        if(Like::where('article_id', $article)->where('user', Auth::user()->id)->exists())
        {
            return json_encode(['error' => 'You already liked this article.']);
        }
        else {
            $like = new Like();
            $like->article_id = $article;
            $like->user = Auth::user()->id;

            $save = $like->save();

            $article_likes = Article::where('id', $article)->first()->like_count + 1;
            $update_likes = Article::where('id', $article)->update(['like_count' => $article_likes]);

            return $save;
            return $update_likes;
        }
    }
    public static function delete_like($id)
    {
        $article_likes = Article::where('id', $id)->first()->like_count - 1;
        $update_likes = Article::where('id', $id)->update(['like_count' => $article_likes]);
        $deletion = Like::where('id', $id)->delete();
        return $deletion;
        return $update_likes;
    }
    public static function slug($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
    public static function category($name)
    {
        if(Category::where('name', $name)->exists())
        {
            return json_encode(['error' => 'A category with that name already exists.']);
        }
        else {
            $category = new Category();
            $category->name = $name;
            $category->slug = News::slug($name);
            $category->created_by = Auth::user()->id;
            $category->created_by_ip = Crypt::encrypt(LAS::ip());
            $category->created_by_browser = Crypt::encrypt(LAS::browser());
            $category->created_by_os = Crypt::encrypt(LAS::os());

            $save = $category->save();
            return $save;
        }
    }
    public static function delete_category($id)
    {
        if(Article::where('category', $id)->exists())
        {
            $delete_articles = Article::where('category', $id)->delete();
            $category_deletion = Category::where('id', $id)->delete();

            return $delete_articles;
            return $category_deletion;
        }
        elseif(!Article::where('category', $id)->exists())
        {
            $category_deletion = Category::where('id', $id)->delete();

            return $category_deletion;
        }
    }
    public static function move_articles($old, $new)
    {
        $change = Article::where('category', $old)->update(['category' => $new]);

        return $change;
    }
    public static function change_article_category($article, $new_category)
    {
        $change = Article::where('id', $article)->update(['category' => $new_category]);

        return $change;
    }
}
