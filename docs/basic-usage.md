# Basic usage

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

## PHP API reference

| Method                       | Description                                                              |
|------------------------------|--------------------------------------------------------------------------|
| `createECharts(?string $id)` | Creates a new chart instance                                             |
| `factory()`                  | Returns the `EChartsFactory` for shorthand chart creation                |
| `setOptions(Options)`        | Merges options from an `Options` object                                  |
| `setRawOptions(array)`       | Merges raw array options — for options not covered by the fluent API     |
| `addSerie(Serie\|array)`     | Appends a serie — accepts a `Serie` object or a raw array                |
| `setSeries(array)`           | Replaces all series                                                      |
| `addTheme(string, array)`    | Registers a custom ECharts theme                                         |
| `useTheme(string)`           | Sets the active theme                                                    |
| `setWidth(int)`              | Fixed width in px (ignored when resizable)                               |
| `setHeight(int)`             | Height in px                                                             |
| `setResizable(bool)`         | Enables/disables responsive resize — enabled by default                  |
| `exportable(?Toolbox)`       | Adds the toolbox — defaults to PNG, data view and restore if no argument |
| `setAttributes(array)`       | Merges HTML attributes on the container `<div>`                          |
| `createView()`               | Returns the full payload injected into Stimulus                          |
