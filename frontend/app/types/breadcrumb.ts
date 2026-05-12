import type { RouteLocationRaw } from 'vue-router';

export type BreadcrumbItem = {
	label: string;
	to?: RouteLocationRaw;
};
