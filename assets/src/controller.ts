import {Controller} from "@hotwired/stimulus";
import * as echarts from 'echarts'
import {ThemeOption} from "echarts/types/src/util/types";

let isChartInitialized = false;

type Payload = {
  attributes: Partial<HTMLElementTagNameMap['div']>
  currentTheme: string|null
  options: echarts.EChartsCoreOption
  themes: ThemeOption
}

export default class EChartsController extends Controller {
  declare readonly viewValue: Payload

  static values = {
    view: Object,
  };

  private chart: echarts.EChartsType | null = null;

  connect() {
    if (!isChartInitialized) {
      isChartInitialized = true;
      this.dispatchEvent('init', {
        echarts
      })
    }

    const {element} = this

    if (!(element instanceof HTMLDivElement)) {
      throw new Error('Invalid element');
    }

    const payload = this.viewValue

    const themes = payload.themes;
    for (const [themeName, theme] of Object.entries(themes)) {
      echarts.registerTheme(themeName, theme)
    }

    this.dispatchEvent('pre-connect', {
      options: payload.options,
      config: payload
    })

    this.chart = echarts.init(element, payload.currentTheme)
    this.chart.setOption(payload.options)

    this.dispatchEvent('connect', {
      chart: this.chart
    })
  }

  disconnect() {
    this.dispatchEvent('disconnect', {
      chart: this.chart
    })

    if (this.chart) {
      this.chart.clear()
      this.chart = null
    }
  }

  private dispatchEvent(eventName: string, payload: any) {
    this.dispatch(eventName, {detail: payload, prefix: 'echarts'})
  }
}
