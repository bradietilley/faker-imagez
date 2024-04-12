# imagez

Your one-stop shop for fake avatars - but cats!

![Static Analysis](https://github.com/bradietilley/faker-imagez/actions/workflows/static.yml/badge.svg)
![Tests](https://github.com/bradietilley/faker-imagez/actions/workflows/tests.yml/badge.svg)


## Introduction

FakerImagez is a lightweight PHP package designed to generate fake cat images that can be used for a variety of purposes, like avatars and other placeholders for web development *purr*poses.

All images are 1024*1024 60% quality JPEGs, resulting in 50-130KB per image.

![example](docs/example.png)


## Installation

```
composer require bradietilley/faker-imagez
```


## Documentation

It's insanely easy to use. Just run `imagez()` to spawn the imagez faker singleton and use a variety of methods from there for fine-tune control:


**Get random paths**

```php
imagez()->path();                             // string: /path/to/pics/cat_0037.jpg
imagez()->path();                             // string: /path/to/pics/cat_0101.jpg
```

Once all cat images are exhausted, it'll refeed and continue again with another random order.


**Get random contents**

```php
imagez()->contents();                         // string: <contents of /path/to/pics/imagez_0087.jpg>
imagez()->contents();                         // string: <contents of /path/to/pics/imagez_0120.jpg>
```


**Get SplFileInfo objects**

```php
imagez()->fileinfo();                         // \SplInfo: <fileinfo of /path/to/pics/imagez_0042.jpg>
imagez()->fileinfo();                         // \SplInfo: <fileinfo of /path/to/pics/imagez_0099.jpg>
```


**Get exact cat**

Have a favorite? Get specific ones every time:

```php
imagez()->get(24);                            // string: /path/to/pics/cat_0024.jpg
imagez()->get(43);                            // string: /path/to/pics/cat_0043.jpg
```

**Get count of cats**

```php
imagez()->count();                            // integer: 120                                         (currently there's 120 cats)
```

**Halt iterating for repeat interactions**

```php
imagez()->iterate();                          // Iterates to the next image

imagez()->getCurrentImagePath();              // string: /path/to/pics/imagez_0046.jpeg                 (won't iterate)
imagez()->getCurrentImagePath();              // string: /path/to/pics/imagez_0046.jpeg                 (won't iterate)
imagez()->getCurrentImageContents();          // string: <contents of /path/to/pics/imagez_0046.jpeg>   (won't iterate)
imagez()->getCurrentImageFileinfo();          // \SplFileInfo: /path/to/pics/imagez_0046.jpeg           (won't iterate)
```

**Get all  images**

```php
imagez()->all();                              // array: <path1, path2, ..., path118, path119, path120>

imagez()->path();                             // iterates
imagez()->pool();                             // array: <path1, path2, ..., path118, path119>         (pool contains one less now)

imagez()->path();                             // iterates
imagez()->pool();                             // array: <path1, path2, ..., path118>                  (pool contains one less now)
```

**Pool reloading**

```php
foreach (range(1, 100) as $i) {
    imagez()->path();                         // iterates 100 cats
}

imagez()->loadWhenEmpty();                    // Won't do anything here as there's still cats in the pool.
imagez()->load();                             // Will reload the pool of cats to be the full collection of cat images. 
```

## Roadmap

- May add colour filtering like `imagez()->red()->path()` and `imagez()->red()->iterate()->getCurrentImagePath()`
- May add image intervention as an optional dependency for resizing: `imagez()->resize(128)->path()`
- More imagez

## Author

- [Bradie Tilley](https://github.com/bradietilley)
