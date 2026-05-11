<template>
	<main class="min-h-screen w-full flex-1 pb-16 pt-24">
        <!-- TopAppBar (Authority: JSON) -->
        <header
            class="bg-white border-b border-slate-200 flex justify-between items-center h-16 px-6 w-full sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <span class="text-xl font-bold text-slate-900 tracking-tight">MerchFlow</span>
            </div>
            <div class="flex items-center gap-4">
                <button class="p-2 text-slate-500 hover:bg-slate-50 rounded-full transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <button class="p-2 text-slate-500 hover:bg-slate-50 rounded-full transition-colors">
                    <span class="material-symbols-outlined">settings</span>
                </button>
                <div class="size-8 rounded-full bg-slate-200 overflow-hidden border border-slate-200">
                    <img alt="Merchant Profile"
                        data-alt="A professional headshot of a business merchant in a modern corporate setting. The lighting is bright and clean with a soft-focus office background, reflecting a professional and trustworthy e-commerce management environment. The aesthetic is high-key and minimalist with neutral tones."
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuAEe8AkbyauDE0zns4tOgIluI_xFLtsS5zKExg2nhauY0_a45spXkLoz0Xgd07KFfO8QtslyVewe9busMoZtwAAhmrkvgf3FSA6Pcr4iY9eUdSH5ZL9l61aG-JBA8to2hGQTGwEJuEUhEGMAU91xHVGuWzFYKBEHjgBLnRnTdT6UkkmteXLLuCBFPIUZ3SlxGnrDEupvag6808Sg1HkjA8t62l90GSOWk2pEE8XBJF3Z3y2ca2FNuqNcsIPVvA0qzBvlmACubs5qfs-" />
                </div>
            </div>
        </header>
        <!-- Focused Order Status Content -->
        <section class="max-w-4xl mx-auto py-12 px-6">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <BreadcrumbsComponent class="mb-2 text-sm text-slate-600" :items="order_edit_crumbs" />
                    <h2 class="text-3xl leading-tight font-bold tracking-tight text-slate-900">Manage Order Status</h2>
                </div>
                <div
                    class="px-4 py-2 bg-slate-100 text-slate-700 rounded-full flex items-center gap-2">
                    <span class="size-2 rounded-full bg-slate-600"></span>
                    <span class="text-sm">Current Status: Paid</span>
                </div>
            </div>
            <!-- Main Transition Card -->
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden mb-8 shadow-sm">
                <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row gap-8 items-start">
                    <div class="flex-1">
                        <p class="text-xs text-slate-500 uppercase tracking-widest mb-4">Update Fulfillment State
                        </p>
                        <h3 class="text-xl leading-snug font-semibold tracking-tight mb-6">Change order status to the next stage</h3>
                        <div class="space-y-6">
                            <!-- Custom Select/Dropdown UI -->
                            <div>
                                <label class="block text-sm text-slate-700 mb-2">New Status</label>
                                <div class="relative">
                                    <select
                                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 appearance-none focus:ring-2 focus:ring-primary focus:border-transparent outline-none font-normal">
                                        <option selected value="paid">Paid (Current)</option>
                                        <option value="shipped">Shipped</option>
                                        <option value="delivered">Delivered</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                    <span
                                        class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">unfold_more</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-2">Moving to 'Shipped' will trigger a notification
                                    email to the customer.</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4">
                                <button
                                    class="bg-slate-900 text-white py-4 px-6 rounded-lg font-semibold flex items-center justify-center gap-2 hover:opacity-90 transition-opacity">
                                    <span class="material-symbols-outlined">check_circle</span>
                                    Update Status
                                </button>
                                <button
                                    class="border border-red-600 text-red-600 py-4 px-6 rounded-lg font-semibold flex items-center justify-center gap-2 hover:bg-red-600/5 transition-colors">
                                    <span class="material-symbols-outlined">assignment_return</span>
                                    Trigger Refund
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Visual Representation -->
                    <div class="w-full md:w-80 bg-slate-50 rounded-xl p-6 border border-slate-100">
                        <p class="text-sm font-bold mb-4">Order Timeline</p>
                        <div class="space-y-6 relative">
                            <!-- Vertical Line -->
                            <div class="absolute left-3.5 top-2 bottom-2 w-0.5 bg-slate-200"></div>
                            <div class="relative flex gap-4">
                                <div class="size-7 rounded-full bg-slate-900 flex items-center justify-center z-10">
                                    <span class="material-symbols-outlined text-white text-xs"
                                        style="font-variation-settings: 'FILL' 1;">check</span>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-900">Order Placed</p>
                                    <p class="text-xs text-slate-500">Oct 24, 2023 • 10:30 AM</p>
                                </div>
                            </div>
                            <div class="relative flex gap-4">
                                <div class="size-7 rounded-full bg-slate-900 flex items-center justify-center z-10">
                                    <span class="material-symbols-outlined text-white text-xs"
                                        style="font-variation-settings: 'FILL' 1;">check</span>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-900">Payment Confirmed</p>
                                    <p class="text-xs text-slate-500">Oct 24, 2023 • 10:32 AM</p>
                                </div>
                            </div>
                            <div class="relative flex gap-4">
                                <div
                                    class="size-7 rounded-full bg-slate-200 border-2 border-slate-900 flex items-center justify-center z-10">
                                    <div class="size-2 rounded-full bg-slate-900"></div>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-900 font-bold">In Processing</p>
                                    <p class="text-xs text-slate-500">Awaiting shipment update</p>
                                </div>
                            </div>
                            <div class="relative flex gap-4 opacity-50">
                                <div class="size-7 rounded-full bg-slate-200 flex items-center justify-center z-10">
                                    <div class="size-2 rounded-full bg-slate-400"></div>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-600">Shipped</p>
                                    <p class="text-xs text-slate-400">Pending action</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-8 bg-slate-50/50">
                    <div class="flex items-center gap-4">
                        <div class="size-12 bg-white border border-slate-200 rounded p-2">
                            <img alt="Product"
                                data-alt="A studio photograph of a premium red running shoe on a clean, white background. The lighting is soft and professional, highlighting the texture of the fabric and the sleek design. The overall feel is modern, commercial, and high-quality e-commerce photography."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCR-4xfCXHtWOAmSgu09QjuWSkVM9FrKwhmshIPS0j5gmo1CserJhDskKLCiO63zlvPbbJ7ZoIcExdlYyJDmZQKsgCOSAAy9a8EkEXG9lX6B7Vt3LUmjzum76OLG6p_qMmbOpZL28gYgC3tZl7QN1Hgt-zm_SZ0K89ga6ZFMYtFzAgZB0aKDjApHT4TtBbq-NYGf-Sk1N33hCw0ubSA3mAqxSfWeO_TEqFpfwKgDSoY6adK8m6nweOAiFar9Vp93sbvZ6pqi4EOpuAn" />
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Velocity Pro-Runner Gen 2</p>
                            <p class="text-xs text-slate-500">SKU: VPR-220-RED • Size: 10.5</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="text-sm font-bold text-slate-900">$189.00</p>
                            <p class="text-xs text-slate-500">Qty: 1</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Quick Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white border border-slate-200 p-6 rounded-xl">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="material-symbols-outlined text-slate-400">person</span>
                        <span class="text-sm font-bold">Customer</span>
                    </div>
                    <p class="text-base text-slate-900">Jonathan Henderson</p>
                    <p class="text-sm text-slate-500">j.henderson@example.com</p>
                    <button class="mt-4 text-xs font-semibold text-slate-900 flex items-center gap-1 hover:underline">
                        View Profile <span class="material-symbols-outlined text-xs">arrow_outward</span>
                    </button>
                </div>
                <div class="bg-white border border-slate-200 p-6 rounded-xl">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="material-symbols-outlined text-slate-400">local_shipping</span>
                        <span class="text-sm font-bold">Shipping</span>
                    </div>
                    <p class="text-base text-slate-900">Express Delivery</p>
                    <p class="text-sm text-slate-500">Tracking: LX-7788-2931</p>
                    <button class="mt-4 text-xs font-semibold text-slate-900 flex items-center gap-1 hover:underline">
                        Edit Address <span class="material-symbols-outlined text-xs">edit</span>
                    </button>
                </div>
                <div class="bg-white border border-slate-200 p-6 rounded-xl">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="material-symbols-outlined text-slate-400">receipt</span>
                        <span class="text-sm font-bold">Payment</span>
                    </div>
                    <p class="text-base text-slate-900">Visa ending in 4421</p>
                    <p class="text-sm text-slate-500">Authorization: #882910</p>
                    <button class="mt-4 text-xs font-semibold text-slate-900 flex items-center gap-1 hover:underline">
                        View Receipt <span class="material-symbols-outlined text-xs">description</span>
                    </button>
                </div>
            </div>
        </section>
    </main>
</template>

<script setup lang="ts">
import type { BreadcrumbItem } from '~/types/breadcrumb';

definePageMeta({ middleware: ['role-merchant'] });

const route = useRoute();

const store_id = computed(() => {
	const raw = route.params.storeId;
	const s = Array.isArray(raw) ? raw[0] : raw;
	const n = typeof s === 'string' ? Number.parseInt(s, 10) : Number.NaN;
	return Number.isFinite(n) && n > 0 ? n : null;
});

const order_id = computed(() => {
	const raw = route.params.orderId;
	const s = Array.isArray(raw) ? raw[0] : raw;
	const n = typeof s === 'string' ? Number.parseInt(s, 10) : Number.NaN;
	return Number.isFinite(n) && n > 0 ? n : null;
});

const order_edit_crumbs = computed<BreadcrumbItem[]>(() => {
	const sid = store_id.value;
	const oid = order_id.value;
	if (sid == null || oid == null) return [];
	return [
		{ label: 'Overview', to: '/merchant' },
		{ label: 'My stores', to: '/merchant/stores' },
		{ label: 'Store', to: `/merchant/stores/${sid}` },
		{ label: 'Orders', to: `/merchant/stores/${sid}/orders` },
		{ label: `Order #${oid}`, to: `/merchant/stores/${sid}/orders/${oid}` },
		{ label: 'Edit status' },
	];
});
</script>
