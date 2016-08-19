## assign

This function is currently missing documentation.

---

## getProp

__Get Property__ :: String -> Object a -> a

Gets a property on the object

```
$obj = new stdClass();
$obj->value = 'hi!';
Object::getValue('value', $obj); // 'hi!'
```

---

## invokeMethod

__Invoke Method__ :: String -> Obj a -> mixed

Invokes a method on the object

```
$person = new stdObject(array(
 "sayHi" => function() {
     return "hi!";
 }
));
Object::invokeMethod('sayHi', $person); // 'hi!'
```

---

## isInstanceOf

__Is Instance Of__ :: String -> Obj a -> mixed

Checks if the object is an instance of the specified class

```
Object::isInstanceOf('stdClass', (new stdClass())); // true
```

---

## setProp

__Set Property__ :: String -> a -> Obj a -> Obj a

Sets a property on the object

```
Object::setValue('value', new stdClass(), 'hi!');
// object(stdClass)#1 (1) {
//   ["value"]=>
//   string(3) "hi!"
// }
```

---

