import {Controller} from "@hotwired/stimulus";
import * as echarts from 'echarts'
import {ThemeOption} from "echarts/types/src/util/types";

let isChartInitialized = false;

const registeredThemes = new Set<string>();

type Themes = Record<string, ThemeOption>;

type Payload = {
  attributes: Partial<HTMLElementTagNameMap['div']>
  currentTheme: string|null
  options: echarts.EChartsCoreOption
  themes: Themes
  resizable: boolean
}

export default class EChartsController extends Controller {
  declare readonly viewValue: Payload

  static values = {
    view: Object,
  };

  private chart: echarts.EChartsType | null = null;
  private resizeObserver: ResizeObserver | null = null;

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

    const themes = payload.themes ?? {};
    for (const [themeName, theme] of Object.entries(themes)) {
      if (!registeredThemes.has(themeName)) {
        echarts.registerTheme(themeName, theme)
        registeredThemes.add(themeName)
      }
    }

    this.dispatchEvent('pre-connect', {
      options: payload.options,
      config: payload
    })

    this.chart = echarts.init(element, payload.currentTheme)
    this.chart.setOption(payload.options)

    if (payload.resizable) {
      this.resizeObserver = new ResizeObserver(() => {
        this.chart?.resize()
      })
      this.resizeObserver.observe(element)
    }

    this.dispatchEvent('connect', {
      chart: this.chart,
      echarts
    })
  }

  disconnect() {
    this.dispatchEvent('disconnect', {
      chart: this.chart
    })

    this.resizeObserver?.disconnect()
    this.resizeObserver = null

    if (this.chart) {
      this.chart.dispose()
      this.chart = null
    }
  }

  private dispatchEvent(eventName: string, payload: any) {
    this.dispatch(eventName, {detail: payload, prefix: 'echarts'})
  }
}
