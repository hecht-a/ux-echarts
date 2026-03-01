import { Controller } from "@hotwired/stimulus";
import * as echarts from 'echarts';
let isChartInitialized = false;
const registeredThemes = new Set();
class EChartsController extends Controller {
    constructor() {
        super(...arguments);
        this.chart = null;
        this.resizeObserver = null;
    }
    connect() {
        var _a;
        if (!isChartInitialized) {
            isChartInitialized = true;
            this.dispatchEvent('init', {
                echarts
            });
        }
        const { element } = this;
        if (!(element instanceof HTMLDivElement)) {
            throw new Error('Invalid element');
        }
        const payload = this.viewValue;
        const themes = (_a = payload.themes) !== null && _a !== void 0 ? _a : {};
        for (const [themeName, theme] of Object.entries(themes)) {
            if (!registeredThemes.has(themeName)) {
                echarts.registerTheme(themeName, theme);
                registeredThemes.add(themeName);
            }
        }
        this.dispatchEvent('pre-connect', {
            options: payload.options,
            config: payload
        });
        this.chart = echarts.init(element, payload.currentTheme);
        this.chart.setOption(payload.options);
        if (payload.resizable) {
            this.resizeObserver = new ResizeObserver(() => {
                var _a;
                (_a = this.chart) === null || _a === void 0 ? void 0 : _a.resize();
            });
            this.resizeObserver.observe(element);
        }
        this.dispatchEvent('connect', {
            chart: this.chart,
            echarts
        });
    }
    disconnect() {
        var _a;
        this.dispatchEvent('disconnect', {
            chart: this.chart
        });
        (_a = this.resizeObserver) === null || _a === void 0 ? void 0 : _a.disconnect();
        this.resizeObserver = null;
        if (this.chart) {
            this.chart.dispose();
            this.chart = null;
        }
    }
    dispatchEvent(eventName, payload) {
        this.dispatch(eventName, { detail: payload, prefix: 'echarts' });
    }
}
EChartsController.values = {
    view: Object,
};
export default EChartsController;
