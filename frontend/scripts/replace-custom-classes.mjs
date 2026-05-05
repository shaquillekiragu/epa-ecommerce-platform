import fs from 'node:fs'
import path from 'node:path'

const FRONTEND_ROOT = path.resolve(process.cwd())
const APP_DIR = path.join(FRONTEND_ROOT, 'app')

/**
 * NOTE:
 * This codemod intentionally targets *known* design-token classes used in this repo
 * and replaces them with the closest standard Tailwind utilities.
 *
 * If you introduce new token classes later, add them to CLASS_MAP.
 */
const CLASS_MAP = new Map([
  // Layout spacing tokens (approx: 4/8 scale)
  ['px-grid_margin', 'px-6'],
  ['py-xl', 'py-8'],
  ['pt-xl', 'pt-8'],
  ['pb-xl', 'pb-8'],
  ['p-xl', 'p-8'],
  ['p-lg', 'p-6'],
  ['p-md', 'p-4'],
  ['p-base', 'p-3'],
  ['p-sm', 'p-2'],
  ['p-xs', 'p-1'],
  ['px-xl', 'px-8'],
  ['px-lg', 'px-6'],
  ['px-md', 'px-4'],
  ['px-base', 'px-3'],
  ['px-sm', 'px-2'],
  ['px-xs', 'px-1'],
  ['py-lg', 'py-6'],
  ['py-md', 'py-4'],
  ['py-base', 'py-3'],
  ['py-sm', 'py-2'],
  ['py-xs', 'py-1'],
  ['mb-xl', 'mb-8'],
  ['mb-lg', 'mb-6'],
  ['mb-md', 'mb-4'],
  ['mb-base', 'mb-3'],
  ['mb-sm', 'mb-2'],
  ['mb-xs', 'mb-1'],
  ['mt-xl', 'mt-8'],
  ['mt-lg', 'mt-6'],
  ['mt-md', 'mt-4'],
  ['mt-base', 'mt-3'],
  ['mt-sm', 'mt-2'],
  ['mt-xs', 'mt-1'],
  ['gap-xl', 'gap-8'],
  ['gap-lg', 'gap-6'],
  ['gap-md', 'gap-4'],
  ['gap-base', 'gap-3'],
  ['gap-sm', 'gap-2'],
  ['gap-xs', 'gap-1'],
  ['pt-sm', 'pt-2'],
  ['pt-md', 'pt-4'],
  ['pt-lg', 'pt-6'],
  ['pb-md', 'pb-4'],
  ['pb-sm', 'pb-2'],
  ['pl-md', 'pl-4'],
  ['pr-sm', 'pr-2'],
  ['pr-lg', 'pr-6'],
  ['right-sm', 'right-2'],
  ['top-xs', 'top-1'],
  ['my-sm', 'my-2'],

  // Border radius tokens
  ['rounded-xl', 'rounded-xl'], // keep (already tailwind)
  ['rounded-DEFAULT', 'rounded-md'],

  // Color tokens -> slate/red approximations
  ['bg-surface-container-lowest', 'bg-white'],
  ['bg-surface-container-low', 'bg-slate-50'],
  ['bg-surface-container', 'bg-slate-100'],
  ['bg-surface-container-high', 'bg-slate-100'],
  ['bg-surface-container-highest', 'bg-slate-200'],
  ['bg-surface', 'bg-slate-50'],
  ['bg-surface-variant', 'bg-slate-100'],
  ['bg-surface-dim', 'bg-slate-200'],
  ['divide-surface-variant', 'divide-slate-200'],
  ['divide-surface-container', 'divide-slate-200'],
  ['text-on-surface', 'text-slate-900'],
  ['text-on-surface-variant', 'text-slate-600'],
  ['text-on-background', 'text-slate-900'],
  ['bg-background', 'bg-slate-50'],
  ['from-background', 'from-slate-50'],
  ['border-surface-variant', 'border-slate-200'],
  ['border-outline', 'border-slate-300'],
  ['border-outline-variant', 'border-slate-400'],
  ['border-outline-layout', 'border-slate-200'],
  ['text-on-surface-layout', 'text-slate-900'],
  ['bg-primary', 'bg-slate-900'],
  ['text-primary', 'text-slate-900'],
  ['text-on-primary', 'text-white'],
  ['bg-primary-fixed', 'bg-slate-900'],
  ['text-primary-fixed', 'text-slate-900'],
  ['text-on-primary-fixed-variant', 'text-white'],
  ['border-primary', 'border-slate-900'],
  ['border-primary-container', 'border-slate-800'],
  ['border-primary-fixed-dim', 'border-slate-400'],
  ['text-primary-container', 'text-slate-800'],
  ['bg-primary-container', 'bg-slate-800'],
  ['text-on-primary-container', 'text-slate-50'],
  ['bg-secondary', 'bg-slate-600'],
  ['text-secondary', 'text-slate-600'],
  ['text-outline', 'text-slate-400'],
  ['text-outline-variant', 'text-slate-500'],
  ['bg-outline-variant', 'bg-slate-300'],
  ['divide-outline-variant', 'divide-slate-300'],
  ['bg-secondary-container', 'bg-slate-100'],
  ['text-on-secondary-container', 'text-slate-700'],
  ['text-on-tertiary-container', 'text-slate-700'],
  ['border-on-tertiary-container', 'border-slate-700'],
  ['bg-tertiary-fixed', 'bg-slate-100'],
  ['bg-tertiary-fixed-dim', 'bg-slate-200'],
  ['text-tertiary-fixed', 'text-slate-700'],
  ['text-on-tertiary-fixed-variant', 'text-slate-700'],
  ['bg-secondary-fixed', 'bg-slate-200'],
  ['text-on-secondary-fixed-variant', 'text-slate-700'],
  ['text-on-secondary-fixed', 'text-slate-800'],
  ['text-on-tertiary-fixed', 'text-slate-700'],
  ['bg-error-container', 'bg-red-100'],
  ['text-on-error-container', 'text-red-700'],
  ['bg-error', 'bg-red-600'],
  ['text-error', 'text-red-600'],
  ['border-error', 'border-red-600'],
  ['bg-surface-bright', 'bg-white'],
  ['bg-surface-tint', 'bg-slate-800'],
  ['border-surface-container', 'border-slate-200'],
  ['border-surface-container-lowest', 'border-white'],

  // Typography token classes -> closest utilities
  ['font-display-lg', 'font-bold tracking-tight'],
  ['text-display-lg', 'text-4xl leading-tight'],
  ['font-headline-lg', 'font-bold tracking-tight'],
  ['text-headline-lg', 'text-3xl leading-tight'],
  ['font-headline-md', 'font-semibold tracking-tight'],
  ['text-headline-md', 'text-xl leading-snug'],
  ['font-body-lg', 'font-normal'],
  ['text-body-lg', 'text-lg'],
  ['font-body-md', 'font-normal'],
  ['text-body-md', 'text-base'],
  ['font-label-md', 'font-semibold'],
  ['text-label-md', 'text-sm'],
  ['font-label-sm', 'font-medium'],
  ['text-label-sm', 'text-xs'],

  // Size tokens used in a few places
  ['w-xl', 'w-20'],
  ['h-xl', 'h-20'],
])

function listVueFiles(dir) {
  const out = []
  const entries = fs.readdirSync(dir, { withFileTypes: true })
  for (const ent of entries) {
    const full = path.join(dir, ent.name)
    if (ent.isDirectory()) out.push(...listVueFiles(full))
    else if (ent.isFile() && full.endsWith('.vue')) out.push(full)
  }
  return out
}

function replaceAllTokens(source) {
  let next = source
  for (const [from, to] of CLASS_MAP.entries()) {
    // replace as whole "class token" to avoid partial matches
    // include '/' so things like `text-error/80` are handled
    const re = new RegExp(`(^|[\\s"'\\[\\]{}(),:/])${from}([\\s"'\\[\\]{}(),:/]|$)`, 'g')
    next = next.replace(re, `$1${to}$2`)
  }
  return next
}

const files = listVueFiles(APP_DIR)
let changed = 0

for (const file of files) {
  const before = fs.readFileSync(file, 'utf8')
  const after = replaceAllTokens(before)
  if (after !== before) {
    fs.writeFileSync(file, after, 'utf8')
    changed++
  }
}

console.log(`Updated ${changed} Vue file(s).`)
