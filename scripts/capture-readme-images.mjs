import { existsSync } from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { chromium } from 'playwright-core';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.join(__dirname, '..');
const outDir = path.join(root, 'docs/images');
const baseUrl = process.env.STENCIL_SCREENSHOT_URL ?? 'http://127.0.0.1:8001';

/** Media slugs under /playbook/media/{slug} (light + dark). */
const components = [
    'button',
    'input',
    'input-currency',
    'select',
    'dialog',
    'typography',
    'icons',
    'label',
    'field',
    'textarea',
    'checkbox',
    'radio',
    'switch',
    'combobox',
    'file-upload',
    'repeater',
    'pillbox',
    'rating',
    'color-picker',
    'input-otp',
    'slider',
    'accordion',
    'collapsible',
    'avatar',
    'badge',
    'breadcrumb',
    'card',
    'dropdown-menu',
    'popover',
    'separator',
    'skeleton',
    'tabs',
    'tooltip',
    'toast',
    'progress',
    'alert',
    'table',
    'pagination',
    'calendar',
    'date-picker',
    'time-picker',
    'datetime-picker',
];

/** Open overlay triggers before capture (panels stay inside #readme-media). */
const openTriggerSelectors = {
    'date-picker': '[data-date-picker-trigger]',
    'time-picker': '[data-time-picker-trigger]',
    'datetime-picker': '[data-datetime-picker-trigger]',
    'color-picker': '[data-color-picker-swatch-trigger]',
};

const listOnly = process.argv.includes('--list');

if (listOnly) {
    for (const component of components) {
        console.log(component);
    }

    process.exit(0);
}

function resolveChromiumExecutable() {
    const candidates = [
        process.env.STENCIL_CHROMIUM_PATH,
        '/usr/bin/chromium',
        '/usr/bin/chromium-browser',
        '/usr/bin/google-chrome',
        '/usr/bin/google-chrome-stable',
    ].filter((value) => typeof value === 'string' && value !== '');

    return candidates.find((candidate) => existsSync(candidate));
}

const executablePath = resolveChromiumExecutable();

if (!executablePath) {
    console.error(
        'No Chromium/Chrome binary found. Set STENCIL_CHROMIUM_PATH or install chromium-browser.',
    );
    process.exit(1);
}

const deviceScaleFactor = Number(process.env.STENCIL_SCREENSHOT_SCALE ?? 3);
/** Logical width of #readme-media (`56rem` at 16px root). */
const readmeMediaWidthPx = Number(process.env.STENCIL_README_MEDIA_WIDTH ?? 896);
const expectedScreenshotWidth = readmeMediaWidthPx * deviceScaleFactor;

const browser = await chromium.launch({
    executablePath,
    headless: true,
});

const context = await browser.newContext({
    deviceScaleFactor,
    viewport: {
        width: Number(process.env.STENCIL_SCREENSHOT_WIDTH ?? 1400),
        height: Number(process.env.STENCIL_SCREENSHOT_HEIGHT ?? 900),
    },
});

const page = await context.newPage();

for (const component of components) {
    for (const [suffix, query] of [
        ['light', ''],
        ['dark', '?dark=1'],
    ]) {
        const url = `${baseUrl}/playbook/media/${component}${query}`;

        await page.goto(url, { waitUntil: 'networkidle' });
        await page.waitForSelector('#readme-media');
        await page.waitForTimeout(400);

        const openSelector = openTriggerSelectors[component];

        if (openSelector) {
            const trigger = page.locator(`#readme-media ${openSelector}`).first();

            if ((await trigger.count()) > 0) {
                await trigger.click({ force: true });
                await page.waitForTimeout(300);
            }
        }

        const target = path.join(outDir, `${component}-${suffix}.png`);

        await page.locator('#readme-media').screenshot({
            path: target,
            type: 'png',
            animations: 'disabled',
            omitBackground: true,
        });

        const { width } = await page.locator('#readme-media').boundingBox();

        if (width !== null && Math.round(width * deviceScaleFactor) !== expectedScreenshotWidth) {
            console.warn(
                `Warning: ${path.basename(target)} width ${Math.round(width * deviceScaleFactor)}px ` +
                    `!= expected ${expectedScreenshotWidth}px`,
            );
        }

        console.log(`Wrote ${path.relative(root, target)}`);
    }
}

await browser.close();
