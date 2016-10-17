## assign

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Object.php#L64)

__Assign Properties__ :: array props -> Object objOriginal -> Object objUpdated

Set/Update properties on the object using a key/value array

```
Object::assign(['value' => 'hi!'], new stdClass);
// object(stdClass)#1 (1) {
//   ["value"]=>
//   string(3) "hi!"
// }
```

---

## getProp

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Object.php#L95)

__Get Property__ :: String -> Object a -> a

Gets a property on the object

```
$obj = new stdClass();
$obj->value = 'hi!';
Object::getValue('value', $obj); // 'hi!'
```

---

## invokeMethod

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Object.php#L123)

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

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Object.php#L142)

__Is Instance Of__ :: String -> Obj a -> mixed

Checks if the object is an instance of the specified class

```
Object::isInstanceOf('stdClass', (new stdClass())); // true
```

---

## setProp

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Object.php#L37)

__Set Property__ :: String -> a -> Object a -> Object a

Sets a property on the object

```
Object::setValue('value', new stdClass(), 'hi!');
// object(stdClass)#1 (1) {
//   ["value"]=>
//   string(3) "hi!"
// }
```

---

