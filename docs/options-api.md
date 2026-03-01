# Options API

Instead of passing raw arrays, use the fluent `Options` class and its typed companions.

## `Options` — the main aggregator

```php
use HechtA\UX\ECharts\Option\Grid;
use HechtA\UX\ECharts\Option\Legend;
use HechtA\UX\ECharts\Option\Option;
use HechtA\UX\ECharts\Option\Options;
use HechtA\UX\ECharts\Option\Title;
use HechtA\UX\ECharts\Option\Tooltip;
use HechtA\UX\ECharts\Option\XAxis;
use HechtA\UX\ECharts\Option\YAxis;

$chart->setOptions(
    (new Options())
        ->title(new Title('Revenue'))
        ->tooltip(new Tooltip('axis'))
        ->legend(new Legend(['Email', 'Direct', 'Search']))
        ->grid(new Grid(left: '3%', right: '4%', containLabel: true))
        ->xAxis(new XAxis(data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']))
        ->yAxis(new YAxis())
        ->set('backgroundColor', '#fafafa')
        ->set('animation', false)
        ->set('textStyle', new Option(['fontSize' => 13]))
);
```

`set()` accepts any scalar or an `Option` instance (automatically converted to array).

For options not covered by `Options`, use `setRawOptions(array)`:

```php
$chart->setRawOptions([
    'dataZoom' => [['type' => 'inside'], ['type' => 'slider']],
]);
```

| Method               | Description                                |
|----------------------|--------------------------------------------|
| `title(Title)`       | Sets the chart title                       |
| `tooltip(Tooltip)`   | Sets the tooltip                           |
| `legend(Legend)`     | Sets the legend                            |
| `grid(Grid)`         | Sets the grid                              |
| `xAxis(XAxis)`       | Sets the X axis                            |
| `yAxis(YAxis)`       | Sets the Y axis                            |
| `set(string, mixed)` | Sets any option without a dedicated method |

---

## `Title`

```php
new Title('My chart')
(new Title())
    ->text('Revenue')
    ->subtext('Fiscal year 2026')
    ->left('center')
    ->top('5%')
    ->backgroundColor('#f8f8f8')
    ->borderWidth(1)
    ->borderRadius(4)
    ->padding([5, 10])
    ->itemGap(8)
    ->textStyle(['color' => '#333', 'fontSize' => 18])
    ->subtextStyle(['color' => '#aaa', 'fontSize' => 12])
    ->link('https://example.com')->target('blank')
    ->show(false)
```

---

## `Tooltip`

```php
new Tooltip()               // trigger: item (default)
new Tooltip('axis')         // trigger: axis
(new Tooltip('axis'))
    ->formatter('{b}: {c}')
    ->axisPointer('shadow')
```

---

## `Legend`

```php
new Legend(['Email', 'Direct'])
(new Legend())
    ->data(['Email', 'Direct', 'Search'])
    ->orient('vertical')
    ->left('left')
    ->top('middle')
```

---

## `Grid`

```php
new Grid()                                              // defaults: left/right 10%, top/bottom 60px
new Grid(left: '3%', right: '4%', containLabel: true)
(new Grid())
    ->left('3%')->right('4%')
    ->top('80')->bottom('30')
    ->containLabel()
```

---

## `XAxis` / `YAxis`

```php
new XAxis(data: ['Mon', 'Tue', 'Wed'])      // type: category (default)
new XAxis(type: 'time')
(new XAxis())
    ->type('category')
    ->data(['Mon', 'Tue', 'Wed'])
    ->name('Week')
    ->boundaryGap(false)

new YAxis()                                 // type: value (default)
new YAxis('log')
(new YAxis())
    ->type('value')
    ->name('Amount')
    ->min(0)->max(1000)
```
