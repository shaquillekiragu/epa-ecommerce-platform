import type { RouteLocationRaw } from 'vue-router';

/** One segment: link when `to` is set; current page when omitted. */
export type BreadcrumbItem = {
	label: string;
	to?: RouteLocationRaw;
};
