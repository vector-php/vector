## indexLens

This function is currently missing documentation.

---

## indexLensSafe

This function is currently missing documentation.

---

## keLens

This function is currently missing documentation.

---

## overL[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Control/Lens.php#L76)

__Over__ :: No type given for this function.

Perform an operation over the focus of a lens. Returns the entire object
as passed in, but with the given function run over a portion of it. Is similar to composing
a set and a get operation all at once.

```
$myLens = Lens::indexLens('a');
Lens::overL($myLens, Math::add(1), ['a' => 1]; // ['a' => 2]
```

---

## pathLens

This function is currently missing documentation.

---

## pathLensSafe

This function is currently missing documentation.

---

## pathPropLens

This function is currently missing documentation.

---

## pathPropLensSafe

This function is currently missing documentation.

---

## propLens

This function is currently missing documentation.

---

## propLensSafe

This function is currently missing documentation.

---

## setL

This function is currently missing documentation.

---

## viewL[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Control/Lens.php#L47)

__View__ :: No type given for this function.

View an object or array through a lens. Simply applies your lens - the
behavior of this function will vary slightly depending on the particular
lens that you're using.

```
$myLens = Lens::indexLens('a');
Lens::viewL($myLens, ['a' => 'b']); // b
```

---

