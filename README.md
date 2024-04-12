# Catz

Your one-stop-shop for fake avatars - but cats!

![Static Analysis](https://github.com/bradietilley/faker-catz/actions/workflows/static.yml/badge.svg)
![Tests](https://github.com/bradietilley/faker-catz/actions/workflows/tests.yml/badge.svg)


## Introduction

FakerCatz is a lightweight PHP package designed to generate fake cat images that can be used for a variety of purposes, like avatars and other placeholders for web development *purr*poses.

All images are 1024*1024 60% quality JPEGs, resulting in 50-130KB per image.


## Installation

```
composer require bradietilley/faker-catz
```


## Documentation

It's insanely easy to use. Just run `catz()` to spawn the Catz faker singleton and use a variety of methods from there for fine-tune control:


**Get random paths**

```php
catz()->path();                             // string: /path/to/pics/cat_0037.jpg
catz()->path();                             // string: /path/to/pics/cat_0101.jpg
```

Once all cat images are exhausted, it'll refeed and continue again with another random order.


**Get random contents**

```php
catz()->contents();                         // string: <contents of /path/to/pics/catz_0087.jpg>
catz()->contents();                         // string: <contents of /path/to/pics/catz_0120.jpg>
```


**Get SplFileInfo objects**

```php
catz()->fileinfo();                         // \SplInfo: <fileinfo of /path/to/pics/catz_0042.jpg>
catz()->fileinfo();                         // \SplInfo: <fileinfo of /path/to/pics/catz_0099.jpg>
```


**Get exact cat**

Have a favorite? Get specific ones every time:

```php
catz()->get(24);                            // string: /path/to/pics/cat_0024.jpg
catz()->get(43);                            // string: /path/to/pics/cat_0043.jpg
```

**Get count of cats**

```php
catz()->count();                            // integer: 120                                         (currently there's 120 cats)
```

**Randomisation / Shuffling**

You can customise the shuffling using a seed, and get replicable random cats. Helpful for when you want your seeded user to always get the same avatar.

```php
catz()->seed(1234)->path();                  // string: /path/to/pics/cat_0016.jpg

catz()->seed(1234)->path();                  // string: /path/to/pics/cat_0016.jpg                  (Same again)
catz()->path();                              // string: /path/to/pics/cat_0089.jpg                  (1234's second image is always this - try it yourself)
```


**Halt iterating for repeat interactions**

```php
catz()->iterate();                          // Iterates to the next image

catz()->getCurrentImagePath();              // string: /path/to/pics/catz_0046.jpeg                 (won't iterate)
catz()->getCurrentImagePath();              // string: /path/to/pics/catz_0046.jpeg                 (won't iterate)
catz()->getCurrentImageContents();          // string: <contents of /path/to/pics/catz_0046.jpeg>   (won't iterate)
catz()->getCurrentImageFileinfo();          // \SplFileInfo: /path/to/pics/catz_0046.jpeg           (won't iterate)
```

**Get all  images**

```php
catz()->all();                              // array: <path1, path2, ..., path118, path119, path120>

catz()->path();                             // iterates
catz()->pool();                             // array: <path1, path2, ..., path118, path119>         (pool contains one less now)

catz()->path();                             // iterates
catz()->pool();                             // array: <path1, path2, ..., path118>                  (pool contains one less now)
```

**Pool reloading**

```php
foreach (range(1, 100) as $i) {
    catz()->path();                         // iterates 100 cats
}

catz()->loadWhenEmpty();                    // Won't do anything here as there's still cats in the pool.
catz()->load();                             // Will reload the pool of cats to be the full collection of cat images. 
```

## Roadmap

- May add colour filtering like `catz()->red()->path()` and `catz()->red()->iterate()->getCurrentImagePath()`
- May add image intervention as an optional dependency for resizing: `catz()->resize(128)->path()`
- More catz

## Author

- [Bradie Tilley](https://github.com/bradietilley)
