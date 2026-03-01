# 📊 Symfony UX ECharts

Symfony UX ECharts is a bundle for integrating [Apache ECharts](https://echarts.apache.org/) into your Twig templates,
combining PHP, Twig and Stimulus.

## Installation

```bash
composer require hecht-a/ux-echarts
npm install --force
```

---

## Usage

### Basic chart

Inject `EChartsBuilderInterface` in your controller, build a chart and pass it to the template:

```php
use HechtA\UX\ECharts\Builder\EChartsBuilderInterface;
use HechtA\UX\ECharts\Option\Options;
use HechtA\UX\ECharts\Option\Title;
use HechtA\UX\ECharts\Option\Tooltip;
use HechtA\UX\ECharts\Option\XAxis;
use HechtA\UX\ECharts\Option\YAxis;
use HechtA\UX\ECharts\Serie\LineSerie;

public function index(EChartsBuilderInterface $builder): Response
{
    $chart = $builder->createECharts('weekly_chart')
        ->setOptions(
            (new Options())
                ->title(new Title('Weekly sales'))
                ->tooltip(new Tooltip('axis'))
                ->xAxis(new XAxis(data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']))
                ->yAxis(new YAxis())
        )
        ->addSerie(LineSerie::new('Revenue')->data([150, 230, 224, 218, 135, 147, 260]));

    return $this->render('chart/index.html.twig', ['chart' => $chart]);
}
```

```twig
{{ render_echarts(chart) }}
```

---

## Options API

Instead of passing raw arrays, use the fluent `Options` class and its typed companions.

### `Options` — the main aggregator

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

### `Title`

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

### `Tooltip`

```php
new Tooltip()                     
new Tooltip('axis')                
(new Tooltip('axis'))
    ->formatter('{b}: {c}')
    ->axisPointer('shadow')
```

### `Legend`

```php
new Legend(['Email', 'Direct'])
(new Legend())
    ->data(['Email', 'Direct', 'Search'])
    ->orient('vertical')
    ->left('left')
    ->top('middle')
```

### `Grid`

```php
new Grid()
new Grid(left: '3%', right: '4%', containLabel: true)
(new Grid())
    ->left('3%')->right('4%')
    ->top('80')->bottom('30')
    ->containLabel()
```

### `XAxis` / `YAxis`

```php
new XAxis(data: ['Mon', 'Tue', 'Wed'])
new XAxis(type: 'time')
(new XAxis())
    ->type('category')
    ->data(['Mon', 'Tue', 'Wed'])
    ->name('Week')
    ->boundaryGap(false)

new YAxis()
new YAxis('log')
(new YAxis())
    ->type('value')
    ->name('Amount')
    ->min(0)->max(1000)
```

---

## Series API

Use typed serie classes instead of raw arrays.

### `LineSerie`

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

### `BarSerie`

```php
use HechtA\UX\ECharts\Serie\BarSerie;

$chart->addSerie(
    BarSerie::new('Sales')
        ->data([120, 200, 150, 80])
        ->stack('Total')
        ->barWidth('60%')
);
```

### `PieSerie`

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

### `RadarSerie`

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

### Raw arrays

All serie classes and `addSerie()` / `setSeries()` still accept raw arrays for backwards compatibility:

```php
$chart->addSerie(['type' => 'line', 'data' => [1, 2, 3]]);
```

---

## EChartsFactory

For common chart types, use `$builder->factory()` for even faster setup:

```php
$chart = $builder->factory()->line(
    data: [120, 200, 150, 80, 70, 110, 130],
    xAxis: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
);

$chart = $builder->factory()->bar(
    data: [120, 200, 150],
    xAxis: ['Jan', 'Feb', 'Mar'],
);

$chart = $builder->factory()->pie(['Email' => 335, 'Direct' => 310, 'Search' => 234]);

$chart = $builder->factory()->radar(
    data: ['Team A' => [80, 90, 70], 'Team B' => [60, 75, 85]],
    indicators: ['Speed', 'Strength', 'Stamina'],
);
```

All factory methods accept `$serieOptions` and `$chartOptions` for additional overrides:

```php
$chart = $builder->factory()->line(
    data: [10, 20, 30],
    xAxis: ['A', 'B', 'C'],
    serieOptions: ['name' => 'Revenue', 'smooth' => true],
    chartOptions: ['title' => ['text' => 'Monthly Revenue']],
);
```

---

## Dimensions

```php
$chart->setWidth(800);
$chart->setHeight(400);
```

Both methods throw `InvalidArgumentException` for zero or negative values.

---

## Responsive resize

Charts are **resizable by default**: the rendered `<div>` uses `width: 100%` and a `ResizeObserver` automatically calls
`chart.resize()` when the container changes size.

Make sure the parent element has a defined width:

```twig
<div class="my-container"> {# must have a CSS width #}
    {{ render_echarts(chart) }}
</div>
```

To opt out and render with a fixed pixel width instead:

```php
$chart->setResizable(false)->setWidth(800);
```

---

## Export

`exportable()` adds the ECharts toolbox with PNG export, data view (CSV), and a restore button:

```php
$chart->exportable();
```

You can override any toolbox option — unspecified defaults are preserved:

```php
$chart->exportable([
    'feature' => [
        'saveAsImage' => ['type' => 'svg', 'title' => 'Export SVG'],
        'dataView'    => ['readOnly' => true],
    ],
]);
```

---

## Themes

```php
$chart
    ->addTheme('dark', [...])
    ->addTheme('vintage', [...])
    ->useTheme('dark');
```

Themes are registered once globally via `echarts.registerTheme`, even when multiple charts on the same page share the
same theme.

---

## HTML attributes

```php
$chart->setAttributes([
    'id'    => 'my-chart',
    'class' => 'mb-4',
]);
```

Boolean attributes (`true` renders as `attribute="attribute"`, `false` omits the attribute):

```php
$chart->setAttributes(['data-turbo-permanent' => true]);
```

To compose with another Stimulus controller:

```php
$chart->setAttributes(['data-controller' => 'my-controller']);
```

The `@hecht-a/ux-echarts/echarts` controller is always injected automatically alongside it.

---

## Stimulus events

| Event                 | Detail payload        | Description                                   |
|-----------------------|-----------------------|-----------------------------------------------|
| `echarts:init`        | `{ echarts }`         | Fired once per page — use to register plugins |
| `echarts:pre-connect` | `{ options, config }` | Fired before `echarts.init()`                 |
| `echarts:connect`     | `{ chart, echarts }`  | Fired after the chart is initialized          |
| `echarts:disconnect`  | `{ chart }`           | Fired before `chart.dispose()`                |

```js
document.addEventListener('echarts:connect', ({detail}) => {
    detail.chart.on('click', (params) => console.log(params));
});
```

---

## Pre-configured charts with `#[AsEChart]`

For charts reused across multiple controllers, define them as dedicated classes instead of building them inline.

Create a class that extends `AbstractEChart` and implements `configure()`:

```php
use HechtA\UX\ECharts\Attribute\AsEChart;
use HechtA\UX\ECharts\Chart\AbstractEChart;
use HechtA\UX\ECharts\Model\ECharts;
use HechtA\UX\ECharts\Option\Options;
use HechtA\UX\ECharts\Option\XAxis;
use HechtA\UX\ECharts\Option\YAxis;
use HechtA\UX\ECharts\Serie\LineSerie;

#[AsEChart(id: 'weekly_sales')]
class WeeklySalesChart extends AbstractEChart
{
    public function configure(ECharts $chart): void
    {
        $chart
            ->setHeight(400)
            ->setOptions(
                (new Options())
                    ->xAxis(new XAxis(data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']))
                    ->yAxis(new YAxis())
            )
            ->addSerie(LineSerie::new()->data([150, 230, 224, 218, 135, 147, 260]));
    }
}
```

The class is automatically discovered by the container and can be injected directly into any controller action:

```php
public function index(WeeklySalesChart $chart): Response
{
    return $this->render('index.html.twig', ['chart' => $chart->get()]);
}
```

```twig
{{ render_echarts(chart) }}
```

The chart instance is lazy — `configure()` is called only when `get()` is first invoked.

---

## Symfony Profiler

When the Symfony Profiler is enabled, an **ECharts panel** is added automatically to the toolbar. No configuration
needed.

For each chart rendered on the request, the panel shows:

- **ID** — the chart identifier passed to `createECharts()`
- **Series** — number of series
- **Theme** — active theme, or _default_ if none set
- **Dimensions** — width × height, with a _resizable_ badge when applicable
- **Export toolbox** — whether `exportable()` was called
- **Options JSON** — the full ECharts config, expandable per chart

The collector is injected as an optional dependency in `ChartExtension` — if the profiler is disabled (e.g. in `prod`),
it is never instantiated and has no runtime cost.

---

## PHP API reference

### `ECharts`

| Method                       | Description                                                          |
|------------------------------|----------------------------------------------------------------------|
| `createECharts(?string $id)` | Creates a new chart instance                                         |
| `factory()`                  | Returns the `EChartsFactory` for shorthand chart creation            |
| `setOptions(Options)`        | Merges options from an `Options` object                              |
| `setRawOptions(array)`       | Merges raw array options — for options not covered by the fluent API |
| `addSerie(Serie\|array)`     | Appends a serie — accepts a `Serie` object or a raw array            |
| `setSeries(array)`           | Replaces all series                                                  |
| `addTheme(string, array)`    | Registers a custom ECharts theme                                     |
| `useTheme(string)`           | Sets the active theme                                                |
| `setWidth(int)`              | Fixed width in px (ignored when resizable)                           |
| `setHeight(int)`             | Height in px                                                         |
| `setResizable(bool)`         | Enables/disables responsive resize — enabled by default              |
| `exportable(array)`          | Adds the toolbox with PNG, data view and restore                     |
| `setAttributes(array)`       | Merges HTML attributes on the container `<div>`                      |
| `createView()`               | Returns the full payload injected into Stimulus                      |

### `Options`

| Method               | Description                                |
|----------------------|--------------------------------------------|
| `title(Title)`       | Sets the chart title                       |
| `tooltip(Tooltip)`   | Sets the tooltip                           |
| `legend(Legend)`     | Sets the legend                            |
| `grid(Grid)`         | Sets the grid                              |
| `xAxis(XAxis)`       | Sets the X axis                            |
| `yAxis(YAxis)`       | Sets the Y axis                            |
| `set(string, mixed)` | Sets any option without a dedicated method |

### Series

| Class        | Specific methods                                           |
|--------------|------------------------------------------------------------|
| `LineSerie`  | `smooth()`, `stack()`, `areaStyle()`, `step()`             |
| `BarSerie`   | `stack()`, `barWidth()`, `barMaxWidth()`                   |
| `PieSerie`   | `data(label=>value)`, `radius()`, `center()`, `roseType()` |
| `RadarSerie` | `data(name=>values)`                                       |

All series share `name()`, `data()`, `set()` from the base `Serie` class.