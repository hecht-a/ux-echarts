# Pre-configured charts with `#[AsEChart]`

For charts reused across multiple controllers, define them as dedicated classes instead of building them inline.

## Create a chart class

Extend `AbstractEChart` and implement `configure()`:

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

## Inject in a controller

The class is automatically discovered by the container and can be injected directly into any controller action by
type-hint:

```php
public function index(WeeklySalesChart $chart): Response
{
    return $this->render('index.html.twig', ['chart' => $chart->get()]);
}
```

```twig
{{ render_echarts(chart) }}
```

## How it works

- `#[AsEChart(id: '...')]` tags the class for auto-discovery
- The container registers it in `EChartsRegistry`
- `EChartValueResolver` injects it by matching the controller argument type
- `configure()` is called lazily — only when `get()` is first invoked
