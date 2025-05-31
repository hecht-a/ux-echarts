import { Controller } from "@hotwired/stimulus";
import * as echarts from 'echarts';
let isChartInitialized = false;
class EChartsController extends Controller {
    constructor() {
        super(...arguments);
        this.chart = null;
    }
    connect() {
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
        const themes = payload.themes;
        for (const [themeName, theme] of Object.entries(themes)) {
            echarts.registerTheme(themeName, theme);
        }
        this.dispatchEvent('pre-connect', {
            options: payload.options,
            config: payload
        });
        this.chart = echarts.init(element, payload.currentTheme);
        this.chart.setOption(payload.options);
        this.dispatchEvent('connect', {
            chart: this.chart
        });
    }
    disconnect() {
        this.dispatchEvent('disconnect', {
            chart: this.chart
        });
        if (this.chart) {
            this.chart.clear();
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
