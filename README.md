# Images


![Static Analysis](https://github.com/bradietilley/faker-imagez/actions/workflows/static.yml/badge.svg)
![Tests](https://github.com/bradietilley/faker-imagez/actions/workflows/tests.yml/badge.svg)


## Introduction

FakerImagez provides an interface for other faker image generators.


## Repositories

[Imagez](https://github.com/bradietilley/faker-imagez) available:

- [Catz](https://github.com/bradietilley/faker-imagez)
- [Dogz](https://github.com/bradietilley/faker-dogz)
- [Foodz](https://github.com/bradietilley/faker-foodz)


## Documentation

It's insanely easy to use.

Define your Imagez class, or use one of the above ^

```php
class Something extends Imagez
{
    public static function basePath(): string
    {
        return '/path/to/images';
    }
}
```

If you're using a package mentioned above, just replace `imagez()` in the examples below with the name of the package, such as `foodz()` or `catz()`.

**Get random paths**

Each invocation will return a new random path.

```php
imagez()->path();                             // string: /path/to/pics/image_0037.jpg
imagez()->path();                             // string: /path/to/pics/image_0101.jpg
```

Once all image images are exhausted, it'll refeed and continue again with another random order.


**Get random contents**

Each invocation will return a new random file's contents.

```php
imagez()->contents();                         // string: <contents of /path/to/pics/image_0087.jpg>
imagez()->contents();                         // string: <contents of /path/to/pics/image_0120.jpg>
```


**Get SplFileInfo objects**

Each invocation will return a new random file as an instance of `SplFileInfo`.

```php
imagez()->fileinfo();                         // \SplInfo: <fileinfo of /path/to/pics/image_0042.jpg>
imagez()->fileinfo();                         // \SplInfo: <fileinfo of /path/to/pics/image_0099.jpg>
```


**Get exact image**

Have a favorite? Get specific ones every time using the `get` method. This will *NOT* remove the image from the pool, it will simply fetch the given image.

```php
imagez()->get(24);                            // string: /path/to/pics/image_0024.jpg
imagez()->get(43);                            // string: /path/to/pics/image_0043.jpg
```


**Get count of images**

If you'd like to determine the number of images available, use the `count` method. This will *NOT* count the pool but all images.

```php
$min = 1;
$max = catz()->count();

$image = catz()->get(mt_rand($min, $max));  // string: /path/to/pics/image_XXXX.jpg
```


**Halt iterating for repeat interactions**

Sometimes you might want to iterate the pool manually and perform multiple queries to fetch the path, contents or splfile info without having it automatically iterate. You can achieve this using the below approach.

```php
imagez()->iterate();                          // Iterates to the next image

imagez()->getCurrentImagePath();              // string: /path/to/pics/image_0046.jpeg                 (won't iterate)
imagez()->getCurrentImagePath();              // string: /path/to/pics/image_0046.jpeg                 (won't iterate)
imagez()->getCurrentImageContents();          // string: <contents of /path/to/pics/image_0046.jpeg>   (won't iterate)
imagez()->getCurrentImageFileinfo();          // \SplFileInfo: /path/to/pics/image_0046.jpeg           (won't iterate)
```


**Get all  images**

Maybe you want to pluck all sample images and do something custom. Easy as. The `all` method will return all images (paths), the `pool` method will return what's remaining in the pool (paths).

```php
imagez()->all();                              // array: <path1, path2, ..., path118, path119, path120>

imagez()->path();                             // this iterates the pool, popping the last path from the pool
imagez()->pool();                             // array: <path1, path2, ..., path118, path119>         (pool contains one less now)

imagez()->path();                             // this iterates the pool, popping the last path from the pool
imagez()->pool();                             // array: <path1, path2, ..., path118>                  (pool contains one less now)
```


**Pool reloading**

These are internal functions but they're also public. Might come in handy if you're doing something custom:

```php
foreach (range(1, 100) as $i) {
    imagez()->path();                         // iterates 100 images
}

imagez()->loadWhenEmpty();                    // Won't do anything here as there's still images in the pool.
imagez()->load();                             // Will reload the pool of images to be the full collection of image images. 
```

**Replace all images in the faker**

You can also replace all images in the faker using the `replaceAll()` method.

```php
$all = imagez()->all();
unset($all[23452]);                           // Say you don't like this one

imagez()->replaceAll($all);

imagez()->path();                             // Will never include image #23452
```

**Combining generators**

Maybe you like catz and dogz and foodz and want your placeholders/avatars to include multiple sources. This can be achieved easily:

```php
$generator = catz()->combine(dogz(), foodz());
// or
$generator = CombineImagez::make(catz(), dogz(), foodz());

// Then interact with it as you otherwise would:
$generator->path();                           // path to a dog image
$generator->path();                           // path to a cat image
$generator->path();                           // path to a food image
```

## Roadmap

- May add customisable filtering like `imagez()->red()->path()` and `imagez()->red()->iterate()->getCurrentImagePath()`
- May add image intervention as an optional dependency for resizing: `imagez()->resize(128)->path()`
- Add more images and packages


## Author

- [Bradie Tilley](https://github.com/bradietilley)