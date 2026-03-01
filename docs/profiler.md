# Symfony Profiler

When the Symfony Profiler is enabled, an **ECharts panel** is added automatically to the toolbar. No configuration
needed.

## Panel contents

For each chart rendered on the request, the panel shows:

- **ID** — the chart identifier passed to `createECharts()`
- **Series** — number of series
- **Theme** — active theme, or _default_ if none set
- **Dimensions** — width × height, with a _resizable_ badge when applicable
- **Export toolbox** — whether `exportable()` was called
- **Options JSON** — the full ECharts config, expandable per chart

## Production

The collector is injected as an optional dependency in `ChartExtension`. If the profiler is disabled (e.g. in `prod`),
it is never instantiated and has no runtime cost.
