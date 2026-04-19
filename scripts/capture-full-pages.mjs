import fs from "node:fs";
import path from "node:path";
import { chromium } from "playwright";

const baseUrl = process.env.BASE_URL ?? "http://127.0.0.1:8000";
const outputDir = process.env.OUTPUT_DIR ?? "screenshots/full-pages";

const adminCreds = {
  nip: process.env.ADMIN_NIP ?? "12345",
  password: process.env.ADMIN_PASSWORD ?? "password123",
};

const siswaCreds = {
  nis: process.env.SISWA_NIS ?? "1",
  password: process.env.SISWA_PASSWORD ?? "password123",
};

const pagesPublic = [
  { url: "/", file: "public-landing.png" },
  { url: "/login", file: "public-login.png" },
];

const pagesAdmin = [
  { url: "/admin/dashboard", file: "admin-dashboard.png" },
  { url: "/admin/kategori", file: "admin-kategori-index.png" },
  { url: "/admin/siswa", file: "admin-siswa-index.png" },
  { url: "/admin/siswa/2", file: "admin-siswa-show-2.png" },
  { url: "/admin/pengaduan", file: "admin-pengaduan-index.png" },
  { url: "/admin/pengaduan/3", file: "admin-pengaduan-show-3.png" },
  { url: "/admin/profile", file: "admin-profile.png" },
];

const pagesSiswa = [
  { url: "/siswa/dashboard", file: "siswa-dashboard.png" },
  { url: "/siswa/pengaduan", file: "siswa-pengaduan-index.png" },
  { url: "/siswa/pengaduan/create", file: "siswa-pengaduan-create.png" },
  { url: "/siswa/pengaduan/3", file: "siswa-pengaduan-show-3.png" },
  { url: "/siswa/profile", file: "siswa-profile.png" },
];

function ensureDir(targetDir) {
  fs.mkdirSync(targetDir, { recursive: true });
}

function resolveFile(targetDir, fileName) {
  return path.resolve(targetDir, fileName);
}

async function captureSet(page, targetDir, pages) {
  for (const item of pages) {
    const targetUrl = new URL(item.url, baseUrl).toString();
    await page.goto(targetUrl, { waitUntil: "networkidle" });
    await page.waitForTimeout(500);
    await page.screenshot({
      path: resolveFile(targetDir, item.file),
      fullPage: true,
    });
    console.log(`[saved] ${item.file}`);
  }
}

async function logoutIfNeeded(page) {
  const logoutForm = page.locator('form[action$="/logout"]');
  if ((await logoutForm.count()) > 0) {
    await logoutForm.first().evaluate((form) => form.submit());
    await page.waitForURL(/\/(login)?$/, { timeout: 10000 }).catch(() => {});
    await page.waitForTimeout(300);
  }
}

async function loginAdmin(page, creds) {
  await page.goto(new URL("/login", baseUrl).toString(), { waitUntil: "networkidle" });
  await page.fill("#nip", creds.nip);
  await page.fill("#password", creds.password);
  await Promise.all([
    page.waitForURL(/\/admin\/dashboard/, { timeout: 10000 }),
    page.locator('button[type="submit"]').click(),
  ]);
}

async function loginSiswa(page, creds) {
  await page.goto(new URL("/login", baseUrl).toString(), { waitUntil: "networkidle" });
  await page.getByRole("button", { name: "Siswa" }).click();
  await page.fill("#nis", creds.nis);
  await page.fill("#password", creds.password);
  await Promise.all([
    page.waitForURL(/\/siswa\/dashboard/, { timeout: 10000 }),
    page.locator('button[type="submit"]').click(),
  ]);
}

async function run() {
  ensureDir(outputDir);
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({
    viewport: { width: 1440, height: 900 },
  });
  const page = await context.newPage();

  try {
    await captureSet(page, outputDir, pagesPublic);

    await loginAdmin(page, adminCreds);
    await captureSet(page, outputDir, pagesAdmin);
    await logoutIfNeeded(page);

    await loginSiswa(page, siswaCreds);
    await captureSet(page, outputDir, pagesSiswa);
    await logoutIfNeeded(page);
  } finally {
    await context.close();
    await browser.close();
  }
}

run().catch((error) => {
  console.error(error);
  process.exitCode = 1;
});
