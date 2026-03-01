# Symfony UX ECharts

Symfony UX ECharts is a bundle for integrating [Apache ECharts](https://echarts.apache.org/) into your Twig templates,
combining PHP, Twig and Stimulus.

## Features

- Fluent PHP API — `Options`, `Serie`, `Toolbox` classes instead of raw arrays
- Typed serie classes — `LineSerie`, `BarSerie`, `PieSerie`, `RadarSerie`
- `EChartsFactory` — shorthand for the most common chart types
- Responsive resize via `ResizeObserver` — enabled by default
- Export toolbox — PNG/SVG, data view, restore, zoom, magic type
- `#[AsEChart]` attribute — pre-configured charts injected into controllers
- Symfony Profiler integration — ECharts panel in the toolbar
- Theme support

## Installation

```bash
composer require hecht-a/ux-echarts
npm install --force
```

## Documentation

- [Basic usage](docs/basic-usage.md)
- [Options API](docs/options-api.md)
- [Series API](docs/series-api.md)
- [EChartsFactory](docs/factory.md)
- [Dimensions](docs/dimensions.md)
- [Responsive resize](docs/resize.md)
- [Export & Toolbox](docs/export.md)
- [Themes](docs/themes.md)
- [HTML attributes](docs/attributes.md)
- [Stimulus events](docs/stimulus.md)
- [Pre-configured charts — `#[AsEChart]`](docs/as-echart.md)
- [Symfony Profiler](docs/profiler.md)