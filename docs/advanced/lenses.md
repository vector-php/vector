# Lenses

Lenses are both the most complicated and most powerful tool provided by Vector, offering a potent method of operating on
dense or complex data structures. On this page we'll be going through what they are, how they work,
and how to use them.

Lenses are provided in the Vector\Control\Lens module.

## What is a Lens

In the simplest terms, a lens is a function that acts as both a getter and a setter. It is a partially applied function that encodes a location or path to a
specific part of an object. We describe a lens as "focusing" on a particular section of an object or array, and we operate on the data by applying
a function at the focused point.

Let's consider an example piece of data:

```php
$data = [
    'name' => 'Joseph',
    'code' => [
        'library' => 'Vector'
    ]
];
```

Now let's create a lens that focuses on the `name` index of an array.

```php
$nameLens = Lens::indexLens('name');
```

We now have a lens that is pointed at the `name` index of a key/value array. We can now use it to manipulate our data.

## Using Lenses

### Getting Values with Lenses

Let's see how a lens works as a getter. We already have a lens focusing on the `name` index of a piece of data. To use this lens
to retrieve data, we need to invoke it as a getter. The `Lens` module provides the `viewL` function to do this, short for "View Through Lens":

```php
$name = Lens::viewL($nameLens, $data); // 'Joseph'
```

`viewL` expects a lens as the first argument, and the data set to invoke the lens on as the second argument. We can interpret this function call
as "Viewing the $data object through the $nameLens."

### Setting Values with Lenses

We've seen how lenses act as getters, now let's use them as setters. We'll need to invoke the lens as a setter, and the `Lens` module provides
the `setL` function (short for "Set Through Lens") to do just that.

```php
$result = Lens::setL($nameLens, 'Logan', $data);
```

This call results in `$result` being:

```php
[
    'name' => 'Logan',
    'code' => [
        'library' => 'Vector'
    ]
]
```

`setL` takes the lens as the first argument, the value to set the focused position to as the second argument, and the object to manipulate through the lens
as the third argument.

Unlike setting a property directly through PHP, the `setL` function has an extremely important property: __It is immutable.__ When we call `setL` on the `$data` object
and get the result, the `$data` object is __not__ changed.

### Mutating Values with Lenses

Lenses actually provide a third execution context which is a combination of getting and setting. For example, if we want to modify a value in the original `$data` structure
while simultaneously returning its entire contents, we can use the `overL` function, which is short for "Execute Over Lens." This function executes a lambda expression over
the focus of the lens and returns the modified data structure.

Let's say we want to append my last name to the `name` field in the original data structure:

```php
$addLastName = function($firstName) {
    return $firstName . ' Walker';
};

$result = Lens::overL($nameLens, $addLastName, $data);
```

Which results in:

```php
[
    'name' => 'Joseph Walker',
    'code' => [
        'library' => 'Vector'
    ]
]
```

The `overL` function still takes as lens as its first argument and the object to modify as the last, but now takes a function as the second argument. `overL`
will run this function over whatever the lens is focusing on and return the entirety of the data structure with the changes applied.

Note that just like `setL`, `overL` is __immutable__. The original data is not changed.

## Combining Lenses

Let's say now that we want to pull the `library` field from the `$data` object. Let's write a naive solution to this problem using only what
we've learned so far about lenses:

```php
Lens::viewL(Lens::indexLens('library'), Lens::viewL(Lens::indexLens('code'), $data)); // 'Vector'
```

This certainly works, but let's take it a step further. We know that lenses are functions, we just execute them in special ways.

However, we also know that functions can be composed. This is where lenses really start to shine: __Lenses can be composed.__

```php
$codeLens = Lambda::compose(
    Lens::indexLens('code'),
    Lens::indexLens('library')
);
```

Now we can use this lens to view the `library` property just like before:

```php
Lens::viewL($codeLens, $data); // 'Vector'
```

This composed lens operates _exactly_ like the basic lenses we were working with before. We can use it to set values, and operate over values.

```php
Lens::setL($codeLens, 'PHP', $data);
Lens::overL($codeLens, Strings::append('Lib'), $data);
```

## Advanced Example

Now that we know the basics of lenses, let's see how to use them in a more complex scenario:

```php
$someApiResponse = [
    "meta" => [
        "info" => "An API Request Example"
    ],
    "data" => [
        "users" => [
            [
                "name" => "Joseph",
                "favorites" => [
                    "colors" => [
                        "blue",
                        "green"
                    ],
                    "foods" => [
                        "pho",
                        "fajitas"
                    ]
                ]
            ],
            [
                "name" => "Logan",
                "favorites" => [
                    "colors" => [
                        "red"
                    ],
                    "foods" => [
                        "hamburgers",
                        "curry"
                    ]
                ]
            ]
        ]
    ]
]
```

Let's do some things with this data set using lenses.

#### Can you paint with all the colors of the API?

By combining several `ArrayList` functions and `viewL`, we can gather up all the colors in our data set.

```php
// The Lens::pathLens() function let's us shortcut explicitly composing lenses by doing it for us.
// We just supply an array of index strings.
$colorsLens = Lens::pathLens(['favorites', 'colors']);

$colors = ArrayList::flatten(
    ArrayList::map(Lens::viewL($colorsLens), $someApiResponse['data']['users'])
);
```

#### Everybody likes tacos

Let's use the `overL` function to append "tacos" to everyone's favorite foods.

```php
$usersLens = Lens::pathLens(['data', 'users']);
$foodsLens = Lens::pathLens(['favorites', 'foods']);

$withTacos = Lens::overL(
    $usersLens,
    ArrayList::map(
        Lens::overL($foodLens, ArrayList::cons('tacos'))
    ),
    $someApiResponse
);
```

#### Tag, you're it

Let's say we want to tag a timestamp field of our response in the `meta` block. We're going to use a special type of lens here
called a `safe` lens. This is a lens that can point to properties that technically don't have to exist. You can see the details
for this lens in the Lens API Documentation.

```php
// We're point to meta.timestamp here, which doesn't exist! But that's okay,
// because we're using a safe lens.
$timestampLens = Lens::pathLensSafe(['meta', 'timestamp']);

$withTimestamps = Lens::setL(
    $timestampLens,
    time(),
    $someApiResponse
);
```
