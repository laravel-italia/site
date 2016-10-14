<?php

namespace Tests\Integration\Repositories\Support;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use LaravelItalia\Domain\Article;
use LaravelItalia\Domain\Category;
use LaravelItalia\Domain\Media;
use LaravelItalia\Domain\Role;
use LaravelItalia\Domain\Series;
use LaravelItalia\Domain\Template;
use LaravelItalia\Domain\User;

trait EntitiesPreparer
{
    public function prepareTestArticle($published = false, $visible = false)
    {
        $article = new Article();

        $article->title = 'Test title';
        $article->slug = \Illuminate\Support\Str::slug($article->title);

        $article->digest = 'digest test...';
        $article->body = 'body test...';

        $article->metadescription = '...';

        if ($published) {
            if($visible) {
                $article->publish(Carbon::now());
            } else {
                $article->publish(Carbon::now()->addDays(1));
            }
        } else {
            $article->unpublish();
        }

        return $article;
    }

    public function saveTestArticle($published = false, $visible = false, User $user = null, Category $category = null)
    {
        $article = $this->prepareTestArticle($published, $visible);

        if($user) {
            $article->setUser($user);
        } else {
            $article->user_id = 0;
        }

        $article->save();

        if($category) {
            $article->syncCategories(new Collection([$category]));
        }

        return $article;
    }

    public function assignTestSeriesToArticle(Series $series, Article $article)
    {
        $article->series()->associate($series);
        $article->save();
    }

    public function prepareTestCategory($name)
    {
        $category = Category::createFromName($name);
        return $category;
    }

    public function saveTestCategory($name = 'Test Category')
    {
        $testCategory = $this->prepareTestCategory($name);
        $testCategory->save();

        return $testCategory;
    }

    public function prepareTestMedia()
    {
        $media = new Media();

        $media->url = 'test_url_lmao.jpg';
        $media->user_id = 1;

        return $media;
    }

    public function saveTestMedia()
    {
        $media = $this->prepareTestMedia();
        $media->save();

        return $media;
    }

    public function saveTestPasswordReset()
    {
        \DB::table('password_resets')->insert([
            'email' => 'test@test.com',
            'token' => 'test_token_yo',
            'created_at' => Carbon::now(),
        ]);
    }

    public function prepareTestRole()
    {
        $role = new Role();
        $role->name = 'administrator';
        return $role;
    }

    public function saveTestRole()
    {
        $role = $this->prepareTestRole();
        $role->save();
        return $role;
    }

    public function prepareTestSeries($published = false)
    {
        $series = Series::createFromTitleAndDescriptionAndMetaDescription(
            'Title',
            '',
            ''
        );

        $series->is_published = $published;
        $series->is_completed = true;

        return $series;
    }

    public function saveTestSeries($published = false)
    {
        $testSeries = $this->prepareTestSeries($published);
        $testSeries->save();

        return $testSeries;
    }

    public function prepareTestTemplate()
    {
        return Template::fromNameAndBody(
            'my test template',
            'my test template body'
        );
    }

    public function saveTestTemplate()
    {
        $template = $this->prepareTestTemplate();
        $template->save();

        return $template;
    }

    public function prepareTestUser()
    {
        $role = new Role();
        $role->name = 'administrator';
        $role->save();

        $user = User::fromNameAndEmailAndPassword(
            'Francesco',
            'hey@hellofrancesco.com',
            '123456'
        );

        $user->confirm();
        $user->role()->associate($role);

        return $user;
    }

    public function saveTestUser()
    {
        $user = $this->prepareTestUser();
        $user->save();
        return $user;
    }
}
