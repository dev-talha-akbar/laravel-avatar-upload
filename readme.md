## Installation
###Step 1 The Routes
Add the following routes to your `app/routes.php`:
```php
// The following route is used to show the avatar upload form
Route::get('avatar/upload', 'AvatarController@create');

// The following route is used to store the avatar
Route::post('avatar/upload', 'AvatarController@store');

// The following route fetches the avatar of current logged in user
Route::get('avatar/image/{size}', 'AvatarController@fetch');

// The following route fetches the avatar of given user
Route::get('avatar/image/{id}/{size}', 'AvatarController@fetchGiven');
```

###Step 2 The Migration
Run the following command: `php artisan migrate`
And add the following to `User.php` model:
```php
public function avatar()
{
	return $this->hasOne('App\Avatar');
}
```

###Step 3 Setting up Intervention Image
You need to require `intervention/image` package.
For that, run the following command in your laravel project root: `composer require intervention/image`
Open your Laravel config file `config/app.php` and add the following lines:

In the `$providers` array, add:
`Intervention\Image\ImageServiceProvider::class`
In the `$aliases` array, add:
`'Image' => Intervention\Image\Facades\Image::class`

###Step 4 The Options
Although, there are not much options but you may want to change some of the behaviour.

####AVATAR_UPLOAD_PATH
The path to upload avatars relative to public folder. Default is `uploads/avatars`
####AVATAR_UPLOAD_SIZE
Maximum size of uploaded avatar to save. Default is `180`
####AVATAR_UPLOAD_EXTENSION
The extension of uploaded avatar. Default is `jpg`
####AVATAR_DEFAULT_PATH
The path to default avatar relative to public folder to show if the user does not have one. Providing this will disable Gravatar.
###GRAVATAR_DEFAULT</strong>
The default avatar to show if the user does not have one on gravatar.com. Default is `identicon`. You can see all of the possible defaults [here](https://en.gravatar.com/site/implement/images/#default-image)
