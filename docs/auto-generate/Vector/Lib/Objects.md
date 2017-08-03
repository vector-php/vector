## assign[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Objects.php#L64)

__Assign Properties__ :: array props -> Object objOriginal -> Object objUpdated

Set/Update properties on the object using a key/value array

```
Objects::assign(['value' => 'hi!'], new stdClass);
// object(stdClass)#1 (1) {
//   ["value"]=>
//   string(3) "hi!"
// }
```

---

## getProp[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Objects.php#L95)

__Get Property__ :: String -> Object a -> a

Gets a property on the object

```
$obj = new stdClass();
$obj->value = 'hi!';
Objects::getValue('value', $obj); // 'hi!'
```

---

## invokeMethod[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Objects.php#L123)

__Invoke Method__ :: String -> Obj a -> mixed

Invokes a method on the object

```
$person = new stdObject(array(
 "sayHi" => function() {
     return "hi!";
 }
));
Objects::invokeMethod('sayHi', $person); // 'hi!'
```

---

## isInstanceOf[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Objects.php#L142)

__Is Instance Of__ :: String -> Obj a -> mixed

Checks if the object is an instance of the specified class

```
Objects::isInstanceOf('stdClass', (new stdClass())); // true
```

---

## setProp[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Objects.php#L37)

__Set Property__ :: String -> a -> Object a -> Object a

Sets a property on the object

```
Objects::setValue('value', new stdClass(), 'hi!');
// object(stdClass)#1 (1) {
//   ["value"]=>
//   string(3) "hi!"
// }
```

---

