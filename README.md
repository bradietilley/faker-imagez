# Images


![Static Analysis](https://github.com/bradietilley/faker-imagez/actions/workflows/static.yml/badge.svg)
![Tests](https://github.com/bradietilley/faker-imagez/actions/workflows/tests.yml/badge.svg)


## Introduction

FakerImagez provides an interface for other faker image generators.


## Repositories

[Imagez](https://github.com/bradietilley/faker-imagez) available:

- [Catz](https://github.com/bradietilley/faker-catz)
- [Dogz](https://github.com/bradietilley/faker-dogz)


## Documentation

It's insanely easy to use.

Define your Imagez class.

```php
class Something extends Imagez
{
    public static function basePath(): string
    {
        return '/path/to/images';
    }
}
```

Just run `Something::instance()` to spawn the imagez faker singleton and use a variety of methods from there for fine-tune control:


**Get random paths**

```php
Something::instance()->path();                             // string: /path/to/pics/cat_0037.jpg
Something::instance()->path();                             // string: /path/to/pics/cat_0101.jpg
```

Once all cat images are exhausted, it'll refeed and continue again with another random order.


**Get random contents**

```php
Something::instance()->contents();                         // string: <contents of /path/to/pics/imagez_0087.jpg>
Something::instance()->contents();                         // string: <contents of /path/to/pics/imagez_0120.jpg>
```


**Get SplFileInfo objects**

```php
Something::instance()->fileinfo();                         // \SplInfo: <fileinfo of /path/to/pics/imagez_0042.jpg>
Something::instance()->fileinfo();                         // \SplInfo: <fileinfo of /path/to/pics/imagez_0099.jpg>
```


**Get exact cat**

Have a favorite? Get specific ones every time:

```php
Something::instance()->get(24);                            // string: /path/to/pics/cat_0024.jpg
Something::instance()->get(43);                            // string: /path/to/pics/cat_0043.jpg
```

**Get count of cats**

```php
Something::instance()->count();                            // integer: 120                                         (currently there's 120 cats)
```

**Halt iterating for repeat interactions**

```php
Something::instance()->iterate();                          // Iterates to the next image

Something::instance()->getCurrentImagePath();              // string: /path/to/pics/imagez_0046.jpeg                 (won't iterate)
Something::instance()->getCurrentImagePath();              // string: /path/to/pics/imagez_0046.jpeg                 (won't iterate)
Something::instance()->getCurrentImageContents();          // string: <contents of /path/to/pics/imagez_0046.jpeg>   (won't iterate)
Something::instance()->getCurrentImageFileinfo();          // \SplFileInfo: /path/to/pics/imagez_0046.jpeg           (won't iterate)
```

**Get all  images**

```php
Something::instance()->all();                              // array: <path1, path2, ..., path118, path119, path120>

Something::instance()->path();                             // iterates
Something::instance()->pool();                             // array: <path1, path2, ..., path118, path119>         (pool contains one less now)

Something::instance()->path();                             // iterates
Something::instance()->pool();                             // array: <path1, path2, ..., path118>                  (pool contains one less now)
```

**Pool reloading**

```php
foreach (range(1, 100) as $i) {
    Something::instance()->path();                         // iterates 100 cats
}

Something::instance()->loadWhenEmpty();                    // Won't do anything here as there's still cats in the pool.
Something::instance()->load();                             // Will reload the pool of cats to be the full collection of cat images. 
```

## Roadmap

- May add customisable filtering like `Something::instance()->red()->path()` and `Something::instance()->red()->iterate()->getCurrentImagePath()`
- May add image intervention as an optional dependency for resizing: `Something::instance()->resize(128)->path()`

## Author

- [Bradie Tilley](https://github.com/bradietilley)
