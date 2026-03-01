# 📊 Symfony UX ECharts

Symfony UX ECharts is a bundle for integrating [Apache ECharts](https://echarts.apache.org/) into your Twig templates,
combining PHP, Twig and Stimulus.

## Installation

```bash
composer require hecht-a/ux-echarts
npm install --force
```

## Usage

### Basic chart

Inject `EChartsBuilderInterface` in your controller, build a chart and pass it to the template:

```php
use HechtA\UX\ECharts\Builder\EChartsBuilderInterface;
use HechtA\UX\ECharts\Model\ECharts;

public function index(EChartsBuilderInterface $builder): Response
{
    $chart = $builder->createECharts('weekly_chart')
        ->setOptions([
            'xAxis' => ['type' => 'category', 'data' => ['Mon', 'Tue', 'Wed']],
            'yAxis' => ['type' => 'value'],
        ])
        ->addSerie([
            'type' => ECharts::TYPE_LINE,
            'data' => [150, 230, 224],
        ]);

    return $this->render('chart/index.html.twig', ['chart' => $chart]);
}
```

```twig
{{ render_echarts(chart) }}
```

---

## EChartsFactory

For common chart types, use `$builder->factory()` instead of manually writing ECharts options:

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
    'Email'    => 335,
    'Direct'   => 310,
    'Search'   => 234,
]);

$chart = $builder->factory()->radar(
    data: [
        'Team A' => [80, 90, 70, 85, 60],
        'Team B' => [60, 75, 85, 70, 90],
    ],
    indicators: ['Speed', 'Strength', 'Stamina', 'Agility', 'Endurance'],
);
```

All factory methods accept additional `$serieOptions` and `$chartOptions` to merge extra ECharts options without losing
the defaults:

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
$chart->setWidth(800);   // px, ignored when resizable (see below)
$chart->setHeight(400);  // px, always required
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

## PHP API reference

| Method                       | Description                                                                          |
|------------------------------|--------------------------------------------------------------------------------------|
| `createECharts(?string $id)` | Creates a new chart instance                                                         |
| `factory()`                  | Returns the `EChartsFactory` for shorthand chart creation                            |
| `setOptions(array)`          | Merges ECharts options — [full reference](https://echarts.apache.org/en/option.html) |
| `addSerie(array)`            | Appends a serie                                                                      |
| `setSeries(array)`           | Replaces all series                                                                  |
| `addTheme(string, array)`    | Registers a custom ECharts theme                                                     |
| `useTheme(string)`           | Sets the active theme                                                                |
| `setWidth(int)`              | Fixed width in px (ignored when resizable)                                           |
| `setHeight(int)`             | Height in px                                                                         |
| `setResizable(bool)`         | Enables/disables responsive resize — enabled by default                              |
| `exportable(array)`          | Adds the toolbox with PNG, data view and restore                                     |
| `setAttributes(array)`       | Merges HTML attributes on the container `<div>`                                      |
| `createView()`               | Returns the full payload injected into Stimulus                                      |

---

## Pre-configured charts with `#[AsEChart]`

For charts reused across multiple controllers, define them as dedicated classes instead of building them inline.

Create a class that extends `AbstractEChart` and implements `configure()`:

```php
use HechtA\UX\ECharts\Attribute\AsEChart;
use HechtA\UX\ECharts\Chart\AbstractEChart;
use HechtA\UX\ECharts\Model\ECharts;

#[AsEChart(id: 'weekly_sales')]
class WeeklySalesChart extends AbstractEChart
{
    public function configure(ECharts $chart): void
    {
        $chart
            ->setHeight(400)
            ->setOptions([
                'xAxis' => ['type' => 'category', 'data' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']],
                'yAxis' => ['type' => 'value'],
            ])
            ->addSerie([
                'type' => ECharts::TYPE_LINE,
                'data' => [150, 230, 224, 218, 135, 147, 260],
            ]);
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