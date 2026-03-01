# HTML attributes

```php
$chart->setAttributes([
    'id'    => 'my-chart',
    'class' => 'mb-4',
]);
```

Boolean attributes — `true` renders as `attribute="attribute"`, `false` omits the attribute:

```php
$chart->setAttributes(['data-turbo-permanent' => true]);
```

To compose with another Stimulus controller:

```php
$chart->setAttributes(['data-controller' => 'my-controller']);
```

The `@hecht-a/ux-echarts/echarts` controller is always injected automatically alongside it.
