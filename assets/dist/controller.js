import { Controller } from "@hotwired/stimulus";
import * as echarts from 'echarts';
let isChartInitialized = false;
const registeredThemes = new Set();
class EChartsController extends Controller {
    constructor() {
        super(...arguments);
        this.chart = null;
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
        this.dispatchEvent('connect', {
            chart: this.chart,
            echarts
        });
    }
    disconnect() {
        this.dispatchEvent('disconnect', {
            chart: this.chart
        });
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
