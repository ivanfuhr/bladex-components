/**
 * Stencil — composable SVG charts (vanilla JS, no chart libraries).
 */

export const ROOT_SELECTOR = '[data-chart]';
export const TEMPLATE_SELECTOR = 'template[data-chart-template]';

const SVG_NAMESPACE = 'http://www.w3.org/2000/svg';
const SVG_TAGS = new Set(['svg', 'path', 'line', 'circle', 'g', 'text', 'rect']);

const initialized = new WeakSet();

/** @type {WeakMap<HTMLElement, { state: ChartState, plot: { x: number, y: number, width: number, height: number }, scales: ReturnType<typeof createScales>, svg: SVGSVGElement, layer: SVGGElement, setActive: (index: number) => void }>} */
const chartRuntimes = new WeakMap();

/**
 * @param {Element | null | undefined} element
 */
function isChartSvgElement(element) {
    return (
        element instanceof SVGElement ||
        (element instanceof Element && SVG_TAGS.has(element.tagName.toLowerCase()))
    );
}

/**
 * Templates parsed outside an <svg> host use HTML namespaced tag prototypes.
 *
 * @param {Element} element
 * @returns {SVGElement}
 */
function cloneSvgElement(element) {
    if (element instanceof SVGElement) {
        return /** @type {SVGElement} */ (element.cloneNode(true));
    }

    const tag = element.tagName.toLowerCase();
    const svgElement = document.createElementNS(SVG_NAMESPACE, tag);

    for (const attr of element.attributes) {
        svgElement.setAttribute(attr.name, attr.value);
    }

    if (element.textContent) {
        svgElement.textContent = element.textContent;
    }

    return svgElement;
}

/**
 * @param {ParentNode} root
 */
export function initCharts(root = document) {
    root.querySelectorAll(ROOT_SELECTOR).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        const hasRenderedSeries = element.querySelector(
            '[data-chart-series], [data-chart-bar], [data-chart-point]',
        );

        if (initialized.has(element) && hasRenderedSeries) {
            return;
        }

        initialized.add(element);
        bindChart(element);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindChartKeyboard(root) {
    if (root.dataset.chartKeyboardBound === 'true') {
        return;
    }

    root.dataset.chartKeyboardBound = 'true';

    root.addEventListener('keydown', (event) => {
        const runtime = chartRuntimes.get(root);

        if (!runtime) {
            return;
        }

        const { state, setActive } = runtime;
        const current = runtime.activeIndex;
        let next = current;

        switch (event.key) {
            case 'ArrowRight':
            case 'ArrowUp':
                next = current < 0 ? 0 : Math.min(current + 1, state.data.length - 1);
                break;
            case 'ArrowLeft':
            case 'ArrowDown':
                next = current < 0 ? state.data.length - 1 : Math.max(current - 1, 0);
                break;
            case 'Home':
                next = 0;
                break;
            case 'End':
                next = state.data.length - 1;
                break;
            case 'Escape':
                next = -1;
                break;
            default:
                return;
        }

        event.preventDefault();
        setActive(next);
    });
}

/**
 * @param {HTMLElement} root
 */
function bindChart(root) {
    /** @type {ResizeObserver | null} */
    let resizeObserver = null;
    /** @type {MutationObserver | null} */
    let valueObserver = null;
    let activeIndex = -1;

    const render = () => {
        const state = buildChartState(root);

        if (!state) {
            return;
        }

        drawChart(root, state, activeIndex, (index) => {
            activeIndex = index;
        });

        bindChartKeyboard(root);
    };

    render();

    resizeObserver = new ResizeObserver(() => {
        render();
    });

    resizeObserver.observe(root);

    valueObserver = new MutationObserver(() => {
        render();
    });

    valueObserver.observe(root, {
        attributes: true,
        attributeFilter: ['data-chart-value'],
    });
}

/**
 * @param {HTMLElement} root
 * @returns {ChartState | null}
 */
function buildChartState(root) {
    const data = readChartData(root);

    if (data.length < 2) {
        return null;
    }

    const svgTemplate = root.querySelector(`${TEMPLATE_SELECTOR}[data-chart-template="svg"]`);

    if (!(svgTemplate instanceof HTMLTemplateElement)) {
        return null;
    }

    const svgSource = svgTemplate.content.querySelector('svg');

    if (!(svgSource instanceof SVGSVGElement)) {
        return null;
    }

    const gutter = parseGutter(svgTemplate.dataset.gutter);
    const axes = parseAxes(svgTemplate);
    const series = parseSeries(svgTemplate);
    const hasCursor = Boolean(
        svgTemplate.content.querySelector(`${TEMPLATE_SELECTOR}[data-chart-template="cursor"]`),
    );
    const hasZeroLine = Boolean(
        svgTemplate.content.querySelector(`${TEMPLATE_SELECTOR}[data-chart-template="zero-line"]`),
    );
    const xField = axes.x?.field ?? 'index';
    const yFields = collectYFields(series);

    if (yFields.length === 0) {
        yFields.push('value');
    }

    const tooltipEl = mountOverlay(root, 'tooltip');
    const summaryEl = mountOverlay(root, 'summary');

    return {
        data,
        svgTemplate,
        svgSource,
        gutter,
        axes,
        series,
        hasCursor,
        hasZeroLine,
        xField,
        yFields,
        tooltipEl,
        summaryEl,
        cursorConfig: readCursorConfig(svgTemplate),
    };
}

/**
 * @typedef {object} ChartState
 * @property {Array<Record<string, unknown>>} data
 * @property {HTMLTemplateElement} svgTemplate
 * @property {SVGSVGElement} svgSource
 * @property {{ top: number, right: number, bottom: number, left: number }} gutter
 * @property {{ x?: AxisConfig, y?: AxisConfig }} axes
 * @property {SeriesConfig[]} series
 * @property {boolean} hasCursor
 * @property {boolean} hasZeroLine
 * @property {string} xField
 * @property {string[]} yFields
 * @property {HTMLElement | null} tooltipEl
 * @property {HTMLElement | null} summaryEl
 * @property {{ type: string, radius?: number }} cursorConfig
 */

/**
 * @typedef {object} AxisConfig
 * @property {string} field
 * @property {string | null} format
 * @property {string | null} position
 * @property {number[] | null} tickValues
 * @property {number | null} tickCount
 * @property {number | null} tickStart
 * @property {number | null} tickEnd
 * @property {number | null} tickStep
 * @property {string | null} tickPrefix
 * @property {string | null} tickSuffix
 * @property {Record<string, string>} attrs
 */

/**
 * @typedef {object} SeriesConfig
 * @property {'line' | 'area' | 'bar' | 'point'} type
 * @property {string} field
 * @property {string | null} curve
 * @property {string | null} width
 * @property {string | null} radius
 * @property {string | null} minHeight
 * @property {SVGElement} prototype
 * @property {'default' | 'stack' | 'group'} layout
 * @property {string | null} layoutWidth
 * @property {string | null} layoutGap
 */

/**
 * @param {HTMLElement} root
 * @returns {Array<Record<string, unknown>>}
 */
function readChartData(root) {
    const raw = root.getAttribute('data-chart-value') ?? root.getAttribute('value');

    if (!raw) {
        return [];
    }

    try {
        const parsed = JSON.parse(raw);

        return normalizeData(parsed);
    } catch {
        return [];
    }
}

/**
 * @param {unknown} value
 * @returns {Array<Record<string, unknown>>}
 */
function normalizeData(value) {
    if (!Array.isArray(value) || value.length === 0) {
        return [];
    }

    if (typeof value[0] === 'number') {
        return value.map((entry, index) => ({
            value: entry,
            index,
        }));
    }

    return value.map((entry, index) => {
        if (typeof entry !== 'object' || entry === null) {
            return { value: entry, index };
        }

        return {
            ...entry,
            index: entry.index ?? index,
        };
    });
}

/**
 * @param {string | undefined} gutter
 */
function parseGutter(gutter) {
    const parts = (gutter ?? '28 36 32 40')
        .trim()
        .split(/\s+/)
        .map((part) => Number.parseFloat(part))
        .filter((part) => Number.isFinite(part));

    if (parts.length === 1) {
        return { top: parts[0], right: parts[0], bottom: parts[0], left: parts[0] };
    }

    if (parts.length === 2) {
        return { top: parts[0], right: parts[1], bottom: parts[0], left: parts[1] };
    }

    if (parts.length === 3) {
        return { top: parts[0], right: parts[1], bottom: parts[2], left: parts[1] };
    }

    return {
        top: parts[0] ?? 28,
        right: parts[1] ?? 36,
        bottom: parts[2] ?? 32,
        left: parts[3] ?? 40,
    };
}

/**
 * @param {HTMLTemplateElement} svgTemplate
 * @param {'x' | 'y'} axis
 * @returns {HTMLTemplateElement | null}
 */
function findAxisTemplate(svgTemplate, axis) {
    return (
        childChartTemplates(svgTemplate.content).find(
            (node) =>
                node.dataset.chartTemplate === 'axis' &&
                (node.dataset.axis === axis || (axis === 'x' && node.dataset.axis !== 'y')),
        ) ?? null
    );
}

/**
 * @param {HTMLTemplateElement} svgTemplate
 * @param {'x' | 'y'} axis
 * @param {string} part
 * @returns {HTMLTemplateElement | null}
 */
function findAxisPartTemplate(svgTemplate, axis, part) {
    const axisTemplate = findAxisTemplate(svgTemplate, axis);

    if (!axisTemplate) {
        return null;
    }

    return (
        childChartTemplates(axisTemplate.content).find(
            (node) => node.dataset.chartTemplate === part,
        ) ?? null
    );
}

/**
 * @param {HTMLTemplateElement} svgTemplate
 */
function parseAxes(svgTemplate) {
    /** @type {{ x?: AxisConfig, y?: AxisConfig }} */
    const axes = {};

    childChartTemplates(svgTemplate.content)
        .filter((template) => template.dataset.chartTemplate === 'axis')
        .forEach((template) => {
            const axis = template.dataset.axis === 'y' ? 'y' : 'x';
            const tickValues = parseTickValues(template.dataset.tickValues);

            axes[axis] = {
                field: template.dataset.field ?? (axis === 'x' ? 'date' : 'value'),
                format: template.dataset.format ?? null,
                position: template.dataset.position ?? null,
                tickValues,
                tickCount: parseOptionalNumber(template.dataset.tickCount),
                tickStart: parseOptionalNumber(template.dataset.tickStart),
                tickEnd: parseOptionalNumber(template.dataset.tickEnd),
                tickStep: parseOptionalNumber(template.dataset.tickStep),
                tickPrefix: template.dataset.tickPrefix ?? null,
                tickSuffix: template.dataset.tickSuffix ?? null,
                attrs: { ...template.dataset },
            };
        });

    return axes;
}

/**
 * @param {string | undefined} raw
 * @returns {number[] | null}
 */
function parseTickValues(raw) {
    if (!raw) {
        return null;
    }

    try {
        const parsed = JSON.parse(raw);

        return Array.isArray(parsed) ? parsed.map(Number).filter(Number.isFinite) : null;
    } catch {
        return null;
    }
}

/**
 * @param {string | undefined} raw
 */
function parseOptionalNumber(raw) {
    if (!raw) {
        return null;
    }

    const value = Number.parseFloat(raw);

    return Number.isFinite(value) ? value : null;
}

/**
 * @param {ParentNode} parent
 * @returns {HTMLTemplateElement[]}
 */
function childChartTemplates(parent) {
    if (parent instanceof DocumentFragment || parent instanceof Element) {
        return [...parent.children].filter(
            (node) =>
                node instanceof HTMLTemplateElement && node.hasAttribute('data-chart-template'),
        );
    }

    return [];
}

/**
 * @param {HTMLTemplateElement} svgTemplate
 * @returns {SeriesConfig[]}
 */
function parseSeries(svgTemplate) {
    /** @type {SeriesConfig[]} */
    const series = [];

    const walk = (parent, layout = 'default', layoutWidth = null, layoutGap = null) => {
        childChartTemplates(parent).forEach((node) => {
            const type = node.dataset.chartTemplate;

            if (type === 'stack' || type === 'group') {
                walk(node.content, type, node.dataset.width ?? null, node.dataset.gap ?? null);

                return;
            }

            if (!['line', 'area', 'bar', 'point'].includes(type ?? '')) {
                return;
            }

            const prototype = node.content.firstElementChild;

            if (!isChartSvgElement(prototype)) {
                return;
            }

            series.push({
                type: /** @type {'line' | 'area' | 'bar' | 'point'} */ (type),
                field: node.dataset.field ?? 'value',
                curve: node.dataset.curve ?? null,
                width: node.dataset.width ?? null,
                radius: node.dataset.radius ?? null,
                minHeight: node.dataset.minHeight ?? null,
                prototype,
                layout,
                layoutWidth,
                layoutGap,
            });
        });
    };

    walk(svgTemplate.content);

    return series;
}

/**
 * @param {SeriesConfig[]} series
 */
function collectYFields(series) {
    return [...new Set(series.map((entry) => entry.field))];
}

/**
 * @param {HTMLTemplateElement} svgTemplate
 */
function readCursorConfig(svgTemplate) {
    const template = svgTemplate.content.querySelector(
        `${TEMPLATE_SELECTOR}[data-chart-template="cursor"]`,
    );
    const path = template?.content.querySelector('path');

    return {
        type: path?.getAttribute('data-cursor-type') ?? path?.getAttribute('type') ?? 'line',
        radius: Number.parseFloat(path?.getAttribute('r') ?? '0') || undefined,
    };
}

/**
 * @param {HTMLElement} root
 * @param {'tooltip' | 'summary'} kind
 */
function mountOverlay(root, kind) {
    const selector = `${TEMPLATE_SELECTOR}[data-chart-template="${kind}"]`;
    const template = root.querySelector(selector);

    if (!(template instanceof HTMLTemplateElement)) {
        return null;
    }

    const key = `data-chart-mounted-${kind}`;
    let mounted = root.querySelector(`[${key}]`);

    if (!(mounted instanceof HTMLElement)) {
        mounted = template.content.firstElementChild?.cloneNode(true);

        if (!(mounted instanceof HTMLElement)) {
            return null;
        }

        mounted.setAttribute(key, 'true');
        mounted.hidden = true;
        root.appendChild(mounted);
    }

    return mounted;
}

/**
 * @param {HTMLElement} root
 * @param {ChartState} state
 * @param {number} activeIndex
 * @param {(index: number) => void} onActive
 */
function drawChart(root, state, activeIndex, onActive) {
    let canvas = root.querySelector('[data-chart-canvas]');

    if (!(canvas instanceof HTMLElement)) {
        canvas = document.createElement('div');
        canvas.dataset.chartCanvas = 'true';
        canvas.className = 'absolute inset-0';
        root.appendChild(canvas);
    }

    canvas.replaceChildren();

    const width = Math.max(root.clientWidth, 1);
    const height = Math.max(root.clientHeight, 1);
    const plot = {
        x: state.gutter.left,
        y: state.gutter.top,
        width: Math.max(width - state.gutter.left - state.gutter.right, 1),
        height: Math.max(height - state.gutter.top - state.gutter.bottom, 1),
    };

    const svg = state.svgSource.cloneNode(true);
    svg.setAttribute('width', String(width));
    svg.setAttribute('height', String(height));
    svg.setAttribute('viewBox', `0 0 ${width} ${height}`);
    svg.setAttribute('aria-hidden', 'true');
    svg.setAttribute('focusable', 'false');
    svg.classList.add('size-full');

    const scales = createScales(state, plot);
    const layer = document.createElementNS('http://www.w3.org/2000/svg', 'g');
    layer.setAttribute('data-chart-layer', 'true');

    const setActive = (index) => {
        onActive(index);
        redrawActive(root, state, plot, scales, svg, layer, index);
    };

    chartRuntimes.set(root, {
        state,
        plot,
        scales,
        svg,
        layer,
        activeIndex,
        setActive,
    });

    drawGrid(layer, state, plot, scales);
    drawZeroLine(layer, state, plot, scales);
    drawSeries(layer, state, plot, scales, activeIndex);
    drawAxes(layer, state, plot, scales);

    if (state.hasCursor) {
        drawCursor(layer, state, plot, scales, activeIndex);
    }

    svg.appendChild(layer);

    const overlay = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
    overlay.setAttribute('x', String(plot.x));
    overlay.setAttribute('y', String(plot.y));
    overlay.setAttribute('width', String(plot.width));
    overlay.setAttribute('height', String(plot.height));
    overlay.setAttribute('fill', 'transparent');
    overlay.setAttribute('data-chart-overlay', 'true');
    overlay.style.cursor = 'crosshair';

    overlay.addEventListener('mousemove', (event) => {
        const rect = svg.getBoundingClientRect();
        const x = ((event.clientX - rect.left) / rect.width) * width;
        const index = nearestIndex(state, scales, x);
        setActive(index);
    });

    overlay.addEventListener('mouseleave', () => {
        setActive(-1);
    });

    svg.appendChild(overlay);
    canvas.appendChild(svg);

    updateOverlays(root, state, activeIndex, plot, scales);
}

/**
 * @param {ChartState} state
 */
function chartHasBars(state) {
    return state.series.some((entry) => entry.type === 'bar');
}

/**
 * @param {ChartState} state
 * @param {{ x: number, y: number, width: number, height: number }} plot
 */
function createScales(state, plot) {
    const xValues = state.data.map((row) => row[state.xField]);
    const xType = detectScaleType(xValues);
    const bandScale = chartHasBars(state);
    const numericX =
        xType === 'time'
            ? xValues.map((value) => new Date(String(value)).getTime())
            : xType === 'linear'
              ? xValues.map(Number)
              : xValues.map((_, index) => index);

    const yNumbers = [];

    state.yFields.forEach((field) => {
        state.data.forEach((row) => {
            const value = Number(row[field]);

            if (Number.isFinite(value)) {
                yNumbers.push(value);
            }
        });
    });

    const yMin = state.axes.y?.tickStart ?? Math.min(0, ...yNumbers);
    const yMax = state.axes.y?.tickEnd ?? Math.max(...yNumbers, yMin + 1);
    const yTicks = state.axes.y?.tickValues ?? niceTicks(yMin, yMax, state.axes.y?.tickCount ?? 5);

    return {
        xType,
        plot,
        xValues,
        numericX,
        bandScale,
        xScale: (index) => {
            if (state.data.length === 1) {
                return plot.x + plot.width / 2;
            }

            if (bandScale) {
                const slotWidth = plot.width / state.data.length;

                return plot.x + (index + 0.5) * slotWidth;
            }

            return plot.x + (index / (state.data.length - 1)) * plot.width;
        },
        yScale: (value) => {
            const range = yMax - yMin || 1;

            return plot.y + plot.height - ((value - yMin) / range) * plot.height;
        },
        yMin,
        yMax,
        yTicks,
    };
}

/**
 * @param {unknown[]} values
 */
function detectScaleType(values) {
    if (values.every((value) => isDateLike(value))) {
        return 'time';
    }

    if (
        values.every(
            (value) =>
                typeof value === 'number' ||
                (typeof value === 'string' && value !== '' && !Number.isNaN(Number(value))),
        )
    ) {
        return 'linear';
    }

    return 'categorical';
}

/**
 * @param {unknown} value
 */
function isDateLike(value) {
    if (value instanceof Date) {
        return true;
    }

    if (typeof value !== 'string') {
        return false;
    }

    return !Number.isNaN(Date.parse(value));
}

/**
 * @param {number} min
 * @param {number} max
 * @param {number} count
 */
function niceTicks(min, max, count) {
    if (count <= 1) {
        return [min, max];
    }

    const span = max - min || 1;
    const rawStep = span / Math.max(count - 1, 1);
    const step = niceTickStep(rawStep);
    const start = Math.floor(min / step) * step;
    const end = Math.ceil(max / step) * step;
    const ticks = [];

    for (let tick = start; tick <= end + step * 0.001; tick += step) {
        ticks.push(Number(tick.toFixed(6)));

        if (ticks.length > count + 2) {
            break;
        }
    }

    if (ticks.length < 2) {
        return [min, max];
    }

    return ticks;
}

/**
 * @param {number} value
 */
function niceTickStep(value) {
    if (!Number.isFinite(value) || value <= 0) {
        return 1;
    }

    const exponent = Math.floor(Math.log10(value));
    const fraction = value / 10 ** exponent;
    let niceFraction = 10;

    if (fraction <= 1) {
        niceFraction = 1;
    } else if (fraction <= 2) {
        niceFraction = 2;
    } else if (fraction <= 5) {
        niceFraction = 5;
    }

    return niceFraction * 10 ** exponent;
}

/**
 * @param {SVGGElement} layer
 * @param {ChartState} state
 * @param {{ x: number, y: number, width: number, height: number }} plot
 * @param {ReturnType<typeof createScales>} scales
 */
function drawGrid(layer, state, plot, scales) {
    const yAxis = state.axes.y;
    const template = findAxisPartTemplate(state.svgTemplate, 'y', 'grid-line');

    if (!yAxis || !(template instanceof HTMLTemplateElement)) {
        return;
    }

    scales.yTicks.forEach((tick) => {
        const y = scales.yScale(tick);
        const line = cloneSvgElement(template.content.querySelector('line'));

        if (!(line instanceof SVGLineElement)) {
            return;
        }

        line.setAttribute('x1', String(plot.x));
        line.setAttribute('x2', String(plot.x + plot.width));
        line.setAttribute('y1', String(y));
        line.setAttribute('y2', String(y));
        layer.appendChild(line);
    });
}

/**
 * @param {SVGGElement} layer
 * @param {ChartState} state
 * @param {{ x: number, y: number, width: number, height: number }} plot
 * @param {ReturnType<typeof createScales>} scales
 */
function drawZeroLine(layer, state, plot, scales) {
    if (!state.hasZeroLine || scales.yMin > 0 || scales.yMax < 0) {
        return;
    }

    const template = state.svgTemplate.content.querySelector(
        `${TEMPLATE_SELECTOR}[data-chart-template="zero-line"]`,
    );
    const source = template?.content.querySelector('line');

    if (!isChartSvgElement(source)) {
        return;
    }

    const line = cloneSvgElement(source);
    const y = scales.yScale(0);

    if (line instanceof SVGLineElement) {
        line.setAttribute('x1', String(plot.x));
        line.setAttribute('x2', String(plot.x + plot.width));
        line.setAttribute('y1', String(y));
        line.setAttribute('y2', String(y));
        layer.appendChild(line);
    }
}

/**
 * @param {SVGGElement} layer
 * @param {ChartState} state
 * @param {{ x: number, y: number, width: number, height: number }} plot
 * @param {ReturnType<typeof createScales>} scales
 * @param {number} activeIndex
 */
function drawSeries(layer, state, plot, scales, activeIndex) {
    const barSeries = state.series.filter((entry) => entry.type === 'bar');

    state.series.forEach((series) => {
        if (series.type === 'bar') {
            return;
        }

        if (series.type === 'point') {
            drawPoints(layer, state, series, scales, activeIndex);

            return;
        }

        drawPathSeries(layer, state, series, scales);
    });

    drawBars(layer, state, barSeries, scales, activeIndex);
}

/**
 * @param {SVGGElement} layer
 * @param {ChartState} state
 * @param {SeriesConfig} series
 * @param {ReturnType<typeof createScales>} scales
 */
function drawPathSeries(layer, state, series, scales) {
    const points = state.data
        .map((row, index) => {
            const value = Number(row[series.field]);

            if (!Number.isFinite(value)) {
                return null;
            }

            return {
                x: scales.xScale(index),
                y: scales.yScale(value),
                index,
            };
        })
        .filter((point) => point !== null);

    if (points.length < 2 && series.type !== 'point') {
        return;
    }

    const smooth = series.curve !== 'none';
    const pathData =
        series.type === 'area' ? areaPath(points, scales, smooth) : linePath(points, smooth);

    if (series.type === 'line' || series.type === 'area') {
        const path = cloneSvgElement(series.prototype);

        if (path instanceof SVGPathElement && pathData) {
            path.setAttribute('d', pathData);
            path.setAttribute('data-chart-series', series.field);
            layer.appendChild(path);
        }
    }
}

/**
 * @param {SVGGElement} layer
 * @param {ChartState} state
 * @param {SeriesConfig} series
 * @param {ReturnType<typeof createScales>} scales
 * @param {number} activeIndex
 */
function drawPoints(layer, state, series, scales, activeIndex) {
    state.data.forEach((row, index) => {
        const value = Number(row[series.field]);

        if (!Number.isFinite(value)) {
            return;
        }

        const circle = cloneSvgElement(series.prototype);

        if (!(circle instanceof SVGCircleElement)) {
            return;
        }

        circle.setAttribute('cx', String(scales.xScale(index)));
        circle.setAttribute('cy', String(scales.yScale(value)));
        circle.setAttribute('data-chart-point', series.field);

        if (index === activeIndex) {
            circle.setAttribute('data-active', 'true');
        }

        layer.appendChild(circle);
    });
}

/**
 * @param {Array<{ x: number, y: number, index: number }>} points
 * @param {boolean} smooth
 */
function linePath(points, smooth) {
    if (points.length === 0) {
        return '';
    }

    if (points.length === 1) {
        return `M ${points[0].x} ${points[0].y}`;
    }

    if (!smooth) {
        return `M ${points.map((point) => `${point.x} ${point.y}`).join(' L ')}`;
    }

    let path = `M ${points[0].x} ${points[0].y}`;

    for (let index = 1; index < points.length; index += 1) {
        const previous = points[index - 1];
        const current = points[index];
        const cx = (previous.x + current.x) / 2;

        path += ` C ${cx} ${previous.y}, ${cx} ${current.y}, ${current.x} ${current.y}`;
    }

    return path;
}

/**
 * @param {Array<{ x: number, y: number, index: number }>} points
 * @param {ReturnType<typeof createScales>} scales
 * @param {boolean} smooth
 */
function areaPath(points, scales, smooth) {
    const baseline = scales.yScale(scales.yMin);
    const top = linePath(points, smooth);

    if (!top) {
        return '';
    }

    const first = points[0];
    const last = points[points.length - 1];

    return `${top} L ${last.x} ${baseline} L ${first.x} ${baseline} Z`;
}

/**
 * @param {SVGGElement} layer
 * @param {ChartState} state
 * @param {SeriesConfig[]} barSeries
 * @param {ReturnType<typeof createScales>} scales
 * @param {number} activeIndex
 */
function drawBars(layer, state, barSeries, scales, activeIndex) {
    if (barSeries.length === 0) {
        return;
    }

    const grouped = barSeries.some((series) => series.layout === 'group');
    const stacked = barSeries.some((series) => series.layout === 'stack');
    const count = state.data.length;
    const slotWidth = count > 0 ? scales.plot.width / count : scales.plot.width;
    const groupWidth = parsePercent(barSeries[0]?.layoutWidth, slotWidth * 0.7);
    const gap = parsePercent(barSeries[0]?.layoutGap, 4);

    state.data.forEach((row, dataIndex) => {
        const centerX = scales.xScale(dataIndex);
        const slotX = centerX - slotWidth / 2;

        if (stacked) {
            let accumulator = 0;

            barSeries.forEach((series) => {
                const value = Number(row[series.field]) || 0;
                const y0 = scales.yScale(accumulator);
                accumulator += value;
                const y1 = scales.yScale(accumulator);
                appendBar(
                    layer,
                    series,
                    slotX,
                    Math.min(y0, y1),
                    groupWidth,
                    Math.abs(y1 - y0),
                    dataIndex,
                    activeIndex,
                );
            });

            return;
        }

        barSeries.forEach((series, seriesIndex) => {
            const barWidth = grouped
                ? (groupWidth - gap * (barSeries.length - 1)) / barSeries.length
                : parsePercent(seriesWidth(series), slotWidth);
            const value = Number(row[series.field]) || 0;
            const y = scales.yScale(value);
            const baseline = scales.yScale(Math.min(0, scales.yMin));
            const x = grouped
                ? slotX + (slotWidth - groupWidth) / 2 + seriesIndex * (barWidth + gap)
                : slotX + (slotWidth - barWidth) / 2;
            const height = Math.max(Math.abs(baseline - y), parseLength(series.minHeight, 2));

            appendBar(
                layer,
                series,
                x,
                Math.min(y, baseline),
                barWidth,
                height,
                dataIndex,
                activeIndex,
            );
        });
    });
}

/**
 * @param {SeriesConfig} series
 */
function seriesWidth(series) {
    return series.width;
}

/**
 * @param {string | null | undefined} raw
 * @param {number} fallback
 */
function parsePercent(raw, fallback) {
    if (!raw) {
        return fallback;
    }

    if (raw.endsWith('%')) {
        return fallback * (Number.parseFloat(raw) / 100);
    }

    const value = Number.parseFloat(raw);

    return Number.isFinite(value) ? value : fallback;
}

/**
 * @param {string | null | undefined} raw
 * @param {number} fallback
 */
function parseLength(raw, fallback) {
    const value = Number.parseFloat(raw ?? '');

    return Number.isFinite(value) ? value : fallback;
}

/**
 * @param {SVGGElement} layer
 * @param {SeriesConfig} series
 * @param {number} x
 * @param {number} y
 * @param {number} width
 * @param {number} height
 * @param {number} dataIndex
 * @param {number} activeIndex
 */
function appendBar(layer, series, x, y, width, height, dataIndex, activeIndex) {
    const path = cloneSvgElement(series.prototype);

    if (!(path instanceof SVGPathElement)) {
        return;
    }

    const radius = parseLength(series.radius, 4);
    path.setAttribute('d', roundedRect(x, y, width, height, radius));
    path.setAttribute('data-chart-bar', series.field);

    if (dataIndex === activeIndex) {
        path.setAttribute('data-active', 'true');
    }

    layer.appendChild(path);
}

/**
 * @param {number} x
 * @param {number} y
 * @param {number} width
 * @param {number} height
 * @param {number} radius
 */
function roundedRect(x, y, width, height, radius) {
    const r = Math.min(radius, width / 2, height / 2);

    return [
        `M ${x + r} ${y}`,
        `H ${x + width - r}`,
        `Q ${x + width} ${y} ${x + width} ${y + r}`,
        `V ${y + height}`,
        `H ${x}`,
        `V ${y + r}`,
        `Q ${x} ${y} ${x + r} ${y}`,
        'Z',
    ].join(' ');
}

/**
 * @param {SVGGElement} layer
 * @param {ChartState} state
 * @param {{ x: number, y: number, width: number, height: number }} plot
 * @param {ReturnType<typeof createScales>} scales
 */
function drawAxes(layer, state, plot, scales) {
    drawAxisLine(layer, state, plot, 'x');
    drawAxisLine(layer, state, plot, 'y');
    drawTickLabels(layer, state, plot, scales, 'x');
    drawTickLabels(layer, state, plot, scales, 'y');
}

/**
 * @param {SVGGElement} layer
 * @param {ChartState} state
 * @param {{ x: number, y: number, width: number, height: number }} plot
 * @param {'x' | 'y'} axis
 */
function drawAxisLine(layer, state, plot, axis) {
    const template = findAxisPartTemplate(state.svgTemplate, axis, 'axis-line');

    if (!(template instanceof HTMLTemplateElement)) {
        return;
    }

    const source = template.content.querySelector('line');

    if (!isChartSvgElement(source)) {
        return;
    }

    const line = cloneSvgElement(source);

    if (!(line instanceof SVGLineElement)) {
        return;
    }

    if (axis === 'x') {
        const y = plot.y + plot.height;
        line.setAttribute('x1', String(plot.x));
        line.setAttribute('x2', String(plot.x + plot.width));
        line.setAttribute('y1', String(y));
        line.setAttribute('y2', String(y));
    } else {
        const x = plot.x;
        line.setAttribute('x1', String(x));
        line.setAttribute('x2', String(x));
        line.setAttribute('y1', String(plot.y));
        line.setAttribute('y2', String(plot.y + plot.height));
    }

    layer.appendChild(line);
}

/**
 * @param {SVGGElement} layer
 * @param {ChartState} state
 * @param {{ x: number, y: number, width: number, height: number }} plot
 * @param {ReturnType<typeof createScales>} scales
 * @param {'x' | 'y'} axis
 */
function drawTickLabels(layer, state, plot, scales, axis) {
    const config = state.axes[axis];
    const template = findAxisPartTemplate(state.svgTemplate, axis, 'tick-label');

    if (!config || !(template instanceof HTMLTemplateElement)) {
        return;
    }

    const xTicks = computeXTicks(state, config);

    const ticks = axis === 'y' ? scales.yTicks : xTicks;

    ticks.forEach((tick, index) => {
        const labelGroup = cloneSvgElement(template.content.querySelector('text'));

        if (!(labelGroup instanceof SVGTextElement)) {
            return;
        }

        const rawValue =
            axis === 'x'
                ? state.data[typeof tick === 'number' ? tick : index]?.[config.field]
                : tick;
        const formatted = formatValue(
            rawValue ?? tick,
            config.format,
            config.tickPrefix,
            config.tickSuffix,
        );

        if (axis === 'x') {
            const dataIndex = typeof tick === 'number' ? tick : index;
            const x = scales.xScale(dataIndex);
            const y = plot.y + plot.height;
            labelGroup.setAttribute('x', String(x));
            labelGroup.setAttribute('y', String(y));
        } else {
            const x = plot.x;
            const y = scales.yScale(Number(tick));
            labelGroup.setAttribute('x', String(x));
            labelGroup.setAttribute('y', String(y));
        }

        labelGroup.textContent = formatted;
        layer.appendChild(labelGroup);
    });
}

/**
 * @param {ChartState} state
 * @param {AxisConfig} config
 */
function computeXTicks(state, config) {
    if (config.tickValues) {
        return config.tickValues;
    }

    if (chartHasBars(state)) {
        return state.data.map((_, index) => index);
    }

    const count = config.tickCount ?? Math.min(state.data.length, 6);
    const maxIndex = Math.max(state.data.length - 1, 1);

    return Array.from({ length: count }, (_, index) =>
        Math.round((index / Math.max(count - 1, 1)) * maxIndex),
    );
}

/**
 * @param {unknown} value
 * @param {string | null} format
 * @param {string | null} prefix
 * @param {string | null} suffix
 */
function formatValue(value, format, prefix = null, suffix = null) {
    const options = parseFormat(format);
    let formatted = String(value);

    if (options) {
        if (options.style === 'percent') {
            formatted = new Intl.NumberFormat(undefined, options).format(Number(value));
        } else if (isDateLike(value)) {
            formatted = new Intl.DateTimeFormat(undefined, options).format(new Date(String(value)));
        } else {
            formatted = new Intl.NumberFormat(undefined, options).format(Number(value));
        }
    }

    return `${prefix ?? ''}${formatted}${suffix ?? ''}`;
}

/**
 * @param {string | null} format
 */
function parseFormat(format) {
    if (!format) {
        return null;
    }

    try {
        return JSON.parse(format);
    } catch {
        return null;
    }
}

/**
 * @param {SVGGElement} layer
 * @param {ChartState} state
 * @param {{ x: number, y: number, width: number, height: number }} plot
 * @param {ReturnType<typeof createScales>} scales
 * @param {number} activeIndex
 */
function drawCursor(layer, state, plot, scales, activeIndex) {
    if (activeIndex < 0) {
        return;
    }

    const template = state.svgTemplate.content.querySelector(
        `${TEMPLATE_SELECTOR}[data-chart-template="cursor"]`,
    );
    const source = template?.content.querySelector('path');

    if (!isChartSvgElement(source)) {
        return;
    }

    const path = cloneSvgElement(source);

    if (!(path instanceof SVGPathElement)) {
        return;
    }

    const x = scales.xScale(activeIndex);

    if (state.cursorConfig.type === 'area') {
        const slotWidth =
            state.data.length > 0 ? plot.width / state.data.length : plot.width;
        path.setAttribute(
            'd',
            `M ${x - slotWidth / 2} ${plot.y} H ${x + slotWidth / 2} V ${plot.y + plot.height} H ${x - slotWidth / 2} Z`,
        );
        path.setAttribute('fill', 'currentColor');
        path.setAttribute('opacity', '0.12');
        path.removeAttribute('stroke');
    } else {
        path.setAttribute('d', `M ${x} ${plot.y} V ${plot.y + plot.height}`);
    }

    path.setAttribute('data-chart-cursor', 'true');
    layer.appendChild(path);
}

/**
 * @param {ChartState} state
 * @param {ReturnType<typeof createScales>} scales
 * @param {number} x
 */
function nearestIndex(state, scales, x) {
    let closest = 0;
    let distance = Number.POSITIVE_INFINITY;

    state.data.forEach((_, index) => {
        const pointX = scales.xScale(index);
        const delta = Math.abs(pointX - x);

        if (delta < distance) {
            distance = delta;
            closest = index;
        }
    });

    return closest;
}

/**
 * @param {HTMLElement} root
 * @param {ChartState} state
 * @param {{ x: number, y: number, width: number, height: number }} plot
 * @param {ReturnType<typeof createScales>} scales
 * @param {SVGSVGElement} svg
 * @param {SVGGElement} layer
 * @param {number} activeIndex
 */
function redrawActive(root, state, plot, scales, svg, layer, activeIndex) {
    const runtime = chartRuntimes.get(root);

    if (runtime) {
        runtime.activeIndex = activeIndex;
    }

    layer.querySelectorAll('[data-active]').forEach((node) => node.removeAttribute('data-active'));
    layer.querySelectorAll('[data-chart-cursor]').forEach((node) => node.remove());

    state.series
        .filter((entry) => entry.type === 'point')
        .forEach((series) => {
            const row = state.data[activeIndex];

            if (!row) {
                return;
            }

            const value = Number(row[series.field]);

            if (!Number.isFinite(value)) {
                return;
            }

            const circle = cloneSvgElement(series.prototype);

            if (circle instanceof SVGCircleElement) {
                circle.setAttribute('cx', String(scales.xScale(activeIndex)));
                circle.setAttribute('cy', String(scales.yScale(value)));
                circle.setAttribute('data-chart-point', series.field);
                circle.setAttribute('data-active', 'true');
                layer.appendChild(circle);
            }
        });

    if (state.hasCursor && activeIndex >= 0) {
        drawCursor(layer, state, plot, scales, activeIndex);
    }

    updateOverlays(root, state, activeIndex, plot, scales);
}

/**
 * @param {HTMLElement} root
 * @param {ChartState} state
 * @param {number} activeIndex
 * @param {{ x: number, y: number, width: number, height: number }} plot
 * @param {ReturnType<typeof createScales>} scales
 */
function updateOverlays(root, state, activeIndex, plot, scales) {
    const row = activeIndex >= 0 ? state.data[activeIndex] : null;

    [state.tooltipEl, state.summaryEl].forEach((overlay) => {
        if (!(overlay instanceof HTMLElement)) {
            return;
        }

        const isTooltip = overlay.hasAttribute('data-chart-mounted-tooltip');

        if (!row) {
            overlay.hidden = true;
            overlay.removeAttribute('data-active');
            overlay.style.opacity = '0';
            overlay.style.removeProperty('left');
            overlay.style.removeProperty('top');
            overlay.style.removeProperty('transform');

            return;
        }

        overlay.hidden = false;
        overlay.dataset.active = 'true';
        overlay.style.opacity = '1';

        overlay.querySelectorAll('[data-chart-slot]').forEach((slot) => {
            if (!(slot instanceof HTMLElement)) {
                return;
            }

            const field = slot.dataset.field;
            const fallback = slot.dataset.fallback ?? '';
            const raw = field ? row[field] : '';
            const formatted =
                raw === undefined || raw === null || raw === ''
                    ? fallback
                    : formatValue(
                          raw,
                          slot.dataset.format ?? null,
                          slot.dataset.prefix ?? null,
                          slot.dataset.suffix ?? null,
                      );

            slot.textContent = String(formatted);
        });

        if (isTooltip && plot && scales) {
            positionTooltip(root, overlay, plot, scales, state, activeIndex);
        }
    });

    updateChartAnnouncer(root, state, activeIndex);
}

/**
 * @param {HTMLElement} root
 * @param {ChartState} state
 * @param {number} activeIndex
 */
function updateChartAnnouncer(root, state, activeIndex) {
    const announcer = root.querySelector('[data-chart-announcer]');

    if (!(announcer instanceof HTMLElement)) {
        return;
    }

    const row = activeIndex >= 0 ? state.data[activeIndex] : null;

    if (!row) {
        announcer.textContent = '';

        return;
    }

    const parts = [];

    root.querySelectorAll('[data-chart-mounted-tooltip] [data-chart-slot], [data-chart-mounted-summary] [data-chart-slot]').forEach((slot) => {
        if (!(slot instanceof HTMLElement)) {
            return;
        }

        const field = slot.dataset.field;
        const fallback = slot.dataset.fallback ?? '';
        const raw = field ? row[field] : '';
        const formatted =
            raw === undefined || raw === null || raw === ''
                ? fallback
                : formatValue(
                      raw,
                      slot.dataset.format ?? null,
                      slot.dataset.prefix ?? null,
                      slot.dataset.suffix ?? null,
                  );

        if (formatted) {
            parts.push(String(formatted));
        }
    });

    announcer.textContent = parts.join(', ');
}

/**
 * @param {HTMLElement} root
 * @param {HTMLElement} overlay
 * @param {{ x: number, y: number, width: number, height: number }} plot
 * @param {ReturnType<typeof createScales>} scales
 * @param {ChartState} state
 * @param {number} activeIndex
 */
function positionTooltip(root, overlay, plot, scales, state, activeIndex) {
    const x = scales.xScale(activeIndex);
    const row = state.data[activeIndex];
    let anchorY = plot.y + plot.height;

    if (scales.bandScale) {
        anchorY = plot.y;
    } else {
        state.yFields.forEach((field) => {
            const value = Number(row?.[field]);

            if (Number.isFinite(value)) {
                anchorY = Math.min(anchorY, scales.yScale(value));
            }
        });
    }

    const gap = 10;
    overlay.style.left = `${x}px`;
    overlay.style.top = `${anchorY}px`;

    const tooltipWidth = overlay.offsetWidth || 120;
    const plotLeft = plot.x;
    const plotRight = plot.x + plot.width;
    let translateX = -tooltipWidth / 2;

    if (x + translateX < plotLeft) {
        translateX = plotLeft - x;
    } else if (x + translateX + tooltipWidth > plotRight) {
        translateX = plotRight - x - tooltipWidth;
    }

    overlay.style.transform = `translate(${translateX}px, calc(-100% - ${gap}px))`;
}

document.addEventListener('stencil:mount', (event) => {
    if (!(event instanceof CustomEvent)) {
        return;
    }

    const mountRoot = event.detail?.root;

    if (!(mountRoot instanceof HTMLElement)) {
        return;
    }

    initCharts(mountRoot);
});

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initCharts());
    } else {
        initCharts();
    }
}
