
## constant

__No Summary Given__ :: No Type Signature Provided



No Description Given. Make an issue referencing this function's lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.



---

## identity

__No Summary Given__ :: No Type Signature Provided



No Description Given. Make an issue referencing this function's lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.



---

## indexLens

__No Summary Given__ :: No Type Signature Provided



No Description Given. Make an issue referencing this function's lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.



---

## indexLensSafe

__No Summary Given__ :: No Type Signature Provided



No Description Given. Make an issue referencing this function's lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.



---

## makeLens

__No Summary Given__ :: No Type Signature Provided



No Description Given. Make an issue referencing this function's lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.



---

## over

__No Summary Given__ :: No Type Signature Provided



No Description Given. Make an issue referencing this function's lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.



---

## pathLens

__No Summary Given__ :: No Type Signature Provided



No Description Given. Make an issue referencing this function's lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.



---

## pathLensSafe

__No Summary Given__ :: No Type Signature Provided



No Description Given. Make an issue referencing this function's lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.



---

## propLens

__No Summary Given__ :: No Type Signature Provided



No Description Given. Make an issue referencing this function's lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.



---

## set

__No Summary Given__ :: No Type Signature Provided



No Description Given. Make an issue referencing this function's lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.



---

## view

__View__ :: No Type Signature Provided



View an object or array through a lens. Simply applies your lens - the
behavior of this function will vary slightly depending on the particular
lens that you're using.

```
$myLens = $indexLens('a');
$view($myLens, ['a' => 'b']); // b
```

!!! Note
    Depending on which lens you use, this method might throw an exception.
    Refer to the indivual lenses to see if they're safe to use or not.

Parameter | Type | Description
-|-|-
$lens | \Lens | Lens to use when viewing an object
$x | Mixed | Object or array to view
return | Mixed | The property that the lens focused on


---
