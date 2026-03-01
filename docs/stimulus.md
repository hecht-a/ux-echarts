# Stimulus events

| Event                 | Detail payload        | Description                                   |
|-----------------------|-----------------------|-----------------------------------------------|
| `echarts:init`        | `{ echarts }`         | Fired once per page — use to register plugins |
| `echarts:pre-connect` | `{ options, config }` | Fired before `echarts.init()`                 |
| `echarts:connect`     | `{ chart, echarts }`  | Fired after the chart is initialized          |
| `echarts:disconnect`  | `{ chart }`           | Fired before `chart.dispose()`                |

```js
document.addEventListener('echarts:connect', ({ detail }) => {
    detail.chart.on('click', (params) => console.log(params));
});
```
