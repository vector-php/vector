## constant

____ :: 



```
```

---

## identity

____ :: 



```
```

---

## indexLens

This function is currently missing documentation.

---

## indexLensSafe

This function is currently missing documentation.

---

## keLens

This function is currently missing documentation.

---

## overL

This function is currently missing documentation.

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

## viewL

__View__ :: 

View an object or array through a lens. Simply applies your lens - the
behavior of this function will vary slightly depending on the particular
lens that you're using.

```
$myLens = Lens::indexLens('a');
Lens::viewL($myLens, ['a' => 'b']); // b
```

---

