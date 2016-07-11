
## _get

__Get Property__ :: String -> Obj a -> mixed



Gets a property on the object

```
$obj = new stdClass();
$obj->value = 'hi!';
$get('value', $obj); // 'hi!'
```

Parameter | Type | Description
-|-|-
$prop | String | Property to get
$obj | Object | Object
return | mixed | $val value


---

## _invoke

__Invoke Method__ :: String -> Obj a -> mixed



Invokes a method on the object

```
$person = new stdObject(array(
 "sayHi" => function() {
     return "hi!";
 }
));

$invoke('sayHi', $person); // 'hi!'
```

Parameter | Type | Description
-|-|-
$method | String | Method to call
$obj | Object | Object
return | mixed | $val value


---

## _isInstanceOf

__Is Instance Of__ :: String -> Obj a -> mixed



Checks if the object is an instance of the specified class

```
$isInstanceOf('stdClass', (new stdClass())); // true
```

Parameter | Type | Description
-|-|-
$expected | String | Class
$given | Object | Object
return | mixed | $val value


---

## _set

__Set Property__ :: String -> Obj a -> Obj a



Sets a property on the object

```
$set('value', new stdClass(), 'hi!');
// object(stdClass)#1 (1) {
//   ["value"]=>
//   string(3) "hi!"
// }
```

Parameter | Type | Description
-|-|-
$key | String | Property to set
$obj | Object | Object
$val | mixed | Value
return | Object | $obj Object


---
