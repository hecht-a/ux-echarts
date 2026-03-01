# Export

`exportable()` adds the ECharts toolbox to the chart. Without argument it enables PNG export, data view (CSV) and
restore by default:

```php
$chart->exportable();
```

Pass a `Toolbox` object to control exactly which features are enabled:

```php
use HechtA\UX\ECharts\Option\Toolbox;

$chart->exportable(
    (new Toolbox())
        ->saveAsImage('svg', 'Export SVG')   // PNG (default) or SVG
        ->dataView(readOnly: true)            // show raw data, read-only
        ->restore()                           // reset to initial state
        ->dataZoom()                          // region zoom button
        ->magicType(['line', 'bar'])          // switch chart type at runtime
        ->left('right')                       // toolbox position
        ->top('top')
);
```

## `Toolbox` methods

| Method                      | Description                                      |
|-----------------------------|--------------------------------------------------|
| `saveAsImage(type, title)`  | PNG (default) or SVG export button               |
| `dataView(readOnly, title)` | Raw data view, exportable as CSV                 |
| `restore(title)`            | Reset chart to its initial state                 |
| `dataZoom(title)`           | Region selection zoom                            |
| `magicType(types)`          | Switch between `line`, `bar`, `stack` at runtime |
| `left(string)`              | Horizontal position of the toolbox               |
| `top(string)`               | Vertical position of the toolbox                 |
| `show(bool)`                | Show or hide the entire toolbox                  |
