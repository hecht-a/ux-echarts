# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [2.1.0] — 2026-03-01

### Added

- `Toolbox` option class — fluent API for the ECharts toolbox with `saveAsImage()`, `dataView()`, `restore()`, `dataZoom()`, `magicType()`, `left()`, `top()`, `show()` (`edebf86`)
- `Toolbox::default()` static constructor — activates PNG export, data view and restore in one call (`edebf86`)

### Changed

- `ECharts::exportable()` now accepts `?Toolbox` instead of `array` — pass a `Toolbox` object to customize features, or no argument to use the defaults (`edebf86`)
- `EChartsFactory` migrated internally to use `LineSerie`, `BarSerie`, `PieSerie`, `RadarSerie`, `Options`, `XAxis` and `YAxis` instead of raw arrays (`edebf86`)
- README updated with `Toolbox` usage and methods table (`edebf86`)

---

## [2.0.0] — 2026-03-01

### Breaking changes

- `ECharts::setOptions(array)` removed — replaced by `setOptions(Options)` which accepts an `Options` object (`367c785`)
- `ECharts::addSerie(array)` and `setSeries(array)` still accept raw arrays but now also accept `Serie` objects — no action needed unless you relied on the exact method signature for static analysis
- `PieSerie::data()` and `RadarSerie::data()` now expect an associative array (`label => value` and `name => values` respectively) instead of a pre-formatted ECharts array

### Added

#### Options fluent API (`367c785`)
- `Options` — fluent aggregator for all chart-level options, replaces raw arrays passed to `setOptions()`
- `Title` — full ECharts title option with `text()`, `subtext()`, `link()`, `left()`, `top()`, `backgroundColor()`, `borderWidth()`, `padding()`, `itemGap()`, `textStyle()`, `subtextStyle()`, `show()`, and more
- `Tooltip` — `trigger()`, `formatter()`, `axisPointer()`
- `Legend` — `data()`, `orient()`, `left()`, `top()`
- `Grid` — `left()`, `right()`, `top()`, `bottom()`, `containLabel()`
- `XAxis` — `type()`, `data()`, `name()`, `boundaryGap()`
- `YAxis` — `type()`, `name()`, `min()`, `max()`
- `Option` — base class usable directly for options without a dedicated class; accepted by `Options::set()`

#### Series fluent API (`367c785`)
- `LineSerie` — `smooth()`, `stack()`, `areaStyle()`, `step()`
- `BarSerie` — `stack()`, `barWidth()`, `barMaxWidth()`
- `PieSerie` — `data(label => value)`, `radius()`, `center()`, `roseType()`
- `RadarSerie` — `data(name => values)`
- All series share `name()`, `data()`, `set()` from the base `Serie` class

### Changed

- `ECharts::setRawOptions(array)` added as the explicit escape hatch for raw array options (`367c785`)
- `ECharts::addSerie()` and `setSeries()` now accept `Serie|array` — `Serie` objects are automatically converted via `toArray()` (`367c785`)
- Test suite extended with 66 new cases covering all `Option` and `Serie` classes (`367c785`)
- README updated with full Options and Series API documentation (`367c785`)

---

## [1.5.0] — 2026-03-01

### Added

#### `#[AsEChart]` attribute (`bc1e10a`)
- `#[AsEChart(id: '...')]` marks a class as a pre-configured chart, auto-discovered by the container
- `EChartInterface` — contract with `configure(ECharts $chart)` and `get()`
- `AbstractEChart` — base class with lazy init, extend and implement `configure()` to define the chart
- `EChartsRegistry` — holds all registered charts, accessible by id or class name
- `EChartValueResolver` — injects `#[AsEChart]` classes directly into controller action arguments by type-hint

#### Symfony Profiler (`7689891`)
- `EChartsDataCollector` added — collects data for every chart rendered via `render_echarts()` on the request
- Profiler panel shows per chart: id, number of series, active theme, dimensions, export toolbox status, and full options JSON
- Collector injected as optional dependency in `ChartExtension` — no runtime cost when profiler is disabled

### Changed

- `ECharts::getSeries()` getter added to expose series without going through `createView()` (`7689891`)
- `ECharts::getTheme()` getter added (`7689891`)
- Test suite extended with 34 new cases covering `AsEChart`, `AbstractEChart`, `EChartsRegistry`, `EChartValueResolver` and `EChartsDataCollector` (`bc1e10a`, `7689891`)
- README updated with `#[AsEChart]` usage and Profiler panel documentation (`bc1e10a`, `7689891`)

---

## [1.4.0] — 2026-03-01

### Added

#### EChartsFactory (`c17dffd`)
- `$builder->factory()` returns an `EChartsFactory` instance (lazy, single instance per builder)
- `factory()->line(data, xAxis, serieOptions, chartOptions)` — creates a line chart
- `factory()->bar(data, xAxis, serieOptions, chartOptions)` — creates a bar chart
- `factory()->pie(data, serieOptions, chartOptions)` — creates a pie chart, accepts `label => value` array
- `factory()->radar(data, indicators, serieOptions, chartOptions)` — creates a radar chart
- `EChartsFactoryInterface` added for custom implementations

#### Responsive resize (`2ecf806`)
- Charts resize automatically when their container changes size via `ResizeObserver`
- Enabled by default — rendered `<div>` uses `width: 100%` to adapt to the parent
- `setResizable(false)` opts out and renders with a fixed pixel width instead

#### Export toolbox (`7fea1b7`)
- `exportable(array $toolboxOptions = [])` adds the ECharts toolbox with PNG export, data view (CSV) and restore button
- Toolbox options are deeply merged with defaults via `array_replace_recursive`, unspecified defaults are preserved

### Changed

- Test suite extended from 11 to 25 cases, organized by feature section (`2510016`)
- README rewritten in English with usage examples for all features (`6dd1cb7`)

---

## [1.3.0] — 2026-02-28

### Added

#### QA tooling (`9c1a2ce`)
- PHP CS Fixer configured via `.php-cs-fixer.php` and exposed as Castor tasks (`qa:cs:check`, `qa:cs:fix`)
- PHPStan at max level configured via `phpstan.neon` and exposed as Castor task (`qa:phpstan`)

#### Stimulus controller
- `registeredThemes` set to skip redundant `echarts.registerTheme()` calls when multiple charts share the same theme (`606c107`)

### Changed

- `setAttributes()` now merges with existing attributes instead of replacing them, consistent with `setOptions()` (`9c1a2ce`)
- `dispose()` replaces `clear()` in the Stimulus controller to fully release ECharts resources (DOM listeners, canvas) on disconnect (`606c107`)
- PHPDoc types tightened: `$series` typed as `list<array<string, mixed>>`, `$attributes` as `array<string, string|bool|int|float>` (`9c1a2ce`)
- Test suite refactored: shared static kernel via `setUpBeforeClass` / `tearDownAfterClass`, coverage extended from 1 to 11 cases (`9c1a2ce`)

### Fixed

- `setWidth()` and `setHeight()` now throw `InvalidArgumentException` for zero or negative values (`c698e2f`)
- Theme registration applied to all chart instances on a page, not just the first (`606c107`)
