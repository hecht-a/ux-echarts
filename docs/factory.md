# EChartsFactory

For common chart types, use `$builder->factory()` for rapid chart creation with sensible defaults:

```php
$chart = $builder->factory()->line(
    data: [120, 200, 150, 80, 70, 110, 130],
    xAxis: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
);

$chart = $builder->factory()->bar(
    data: [120, 200, 150],
    xAxis: ['Jan', 'Feb', 'Mar'],
);

$chart = $builder->factory()->pie([
    'Email'  => 335,
    'Direct' => 310,
    'Search' => 234,
]);

$chart = $builder->factory()->radar(
    data: ['Team A' => [80, 90, 70], 'Team B' => [60, 75, 85]],
    indicators: ['Speed', 'Strength', 'Stamina'],
);
```

All factory methods accept `$serieOptions` and `$chartOptions` for additional overrides without losing the defaults:

```php
$chart = $builder->factory()->line(
    data: [10, 20, 30],
    xAxis: ['A', 'B', 'C'],
    serieOptions: ['name' => 'Revenue', 'smooth' => true],
    chartOptions: ['title' => ['text' => 'Monthly Revenue']],
);
```

The factory is lazy — a single instance is created per builder on first call to `$builder->factory()`.
