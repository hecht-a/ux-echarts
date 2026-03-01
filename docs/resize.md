# Responsive resize

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
