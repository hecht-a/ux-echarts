# Series API

Use typed serie classes instead of raw arrays.

All series share `name()`, `data()`, `set()` from the base `Serie` class.

## `LineSerie`

```php
use HechtA\UX\ECharts\Serie\LineSerie;

$chart->addSerie(
    LineSerie::new('Email')
        ->data([120, 132, 101, 134, 90, 230, 210])
        ->smooth()
        ->stack('Total')
        ->areaStyle()
);
```

| Method               | Description                          |
|----------------------|--------------------------------------|
| `smooth(bool)`       | Smooth curve — enabled by default    |
| `stack(string)`      | Stack group name                     |
| `areaStyle()`        | Fills the area under the line        |
| `step(string\|bool)` | Step line (`start`, `middle`, `end`) |

---

## `BarSerie`

```php
use HechtA\UX\ECharts\Serie\BarSerie;

$chart->addSerie(
    BarSerie::new('Sales')
        ->data([120, 200, 150, 80])
        ->stack('Total')
        ->barWidth('60%')
);
```

| Method                     | Description                |
|----------------------------|----------------------------|
| `stack(string)`            | Stack group name           |
| `barWidth(string\|int)`    | Bar width in px or percent |
| `barMaxWidth(string\|int)` | Maximum bar width          |

---

## `PieSerie`

`data()` accepts a `label => value` associative array and formats it automatically:

```php
use HechtA\UX\ECharts\Serie\PieSerie;

$chart->addSerie(
    PieSerie::new('Traffic')
        ->data(['Email' => 335, 'Direct' => 310, 'Search' => 234])
        ->radius('40%', '70%')
        ->center('50%', '50%')
);
```

| Method                 | Description                             |
|------------------------|-----------------------------------------|
| `data(label => value)` | Associative array, auto-formatted       |
| `radius(inner, outer)` | Inner and outer radius — use for donuts |
| `center(x, y)`         | Center position                         |
| `roseType(string)`     | `area` or `radius` rose chart           |

---

## `RadarSerie`

`data()` accepts a `serie name => values` associative array:

```php
use HechtA\UX\ECharts\Serie\RadarSerie;

$chart->addSerie(
    RadarSerie::new()
        ->data([
            'Team A' => [80, 90, 70, 85, 60],
            'Team B' => [60, 75, 85, 70, 90],
        ])
);
```

| Method                 | Description                       |
|------------------------|-----------------------------------|
| `data(name => values)` | Associative array, auto-formatted |

---

## Raw arrays

All serie classes and `addSerie()` / `setSeries()` still accept raw arrays for backwards compatibility:

```php
$chart->addSerie(['type' => 'line', 'data' => [1, 2, 3]]);
```
