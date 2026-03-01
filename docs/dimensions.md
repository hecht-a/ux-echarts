# Dimensions

```php
$chart->setWidth(800);   // px — ignored when resizable (see Responsive resize)
$chart->setHeight(400);  // px — always applied
```

Both methods throw `InvalidArgumentException` for zero or negative values.
