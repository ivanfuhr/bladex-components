import { existsSync } from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { chromium } from 'playwright-core';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.join(__dirname, '..');
const outDir = path.join(root, 'docs/images');
const baseUrl = process.env.STENCIL_SCREENSHOT_URL ?? 'http://127.0.0.1:8001';
const components = ['buttons', 'input', 'select', 'typography', 'icons', 'label', 'field', 'textarea', 'checkbox', 'radio', 'switch'];

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

if (! executablePath) {
    console.error('No Chromium/Chrome binary found. Set STENCIL_CHROMIUM_PATH or install chromium-browser.');
    process.exit(1);
}

const deviceScaleFactor = Number(process.env.STENCIL_SCREENSHOT_SCALE ?? 2);

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

        const target = path.join(outDir, `${component}-${suffix}.png`);

        await page.locator('#readme-media').screenshot({
            path: target,
            type: 'png',
            animations: 'disabled',
        });
        console.log(`Wrote ${path.relative(root, target)}`);
    }
}

await browser.close();
