# Themes

```php
$chart
    ->addTheme('dark', [...])
    ->addTheme('vintage', [...])
    ->useTheme('dark');
```

Themes are registered once globally via `echarts.registerTheme`, even when multiple charts on the same page share the
same theme.
