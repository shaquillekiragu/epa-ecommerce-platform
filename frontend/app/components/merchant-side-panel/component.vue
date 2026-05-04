<template>
    <nav
        class="bg-slate-50 dark:bg-slate-950 h-full w-64 border-r border-slate-200 dark:border-slate-800 flat no shadows fixed left-0 top-0 flex flex-col pt-20 pb-6 z-40">
        <!-- Header -->
        <div class="px-6 mb-8 flex flex-col gap-1">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white font-['Manrope']">Merchant Admin</h2>
            <span
                class="text-xs text-slate-500 dark:text-slate-400 font-['Manrope'] uppercase tracking-wider font-semibold">Store
                Management</span>
        </div>
        <!-- Navigation Links -->
        <div class="flex-1 flex flex-col gap-1 px-4">
            <!-- Active Tab: Overview -->
            <a class="bg-slate-200 dark:bg-slate-800 text-slate-900 dark:text-white font-bold rounded-md px-4 py-2 font-['Manrope'] text-sm flex items-center gap-3 active:scale-95 transition-transform"
                href="#">
                <span class="material-symbols-outlined text-xl" data-icon="dashboard">dashboard</span>
                Overview
            </a>
            <a class="text-slate-600 dark:text-slate-400 px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-900 transition-all font-['Manrope'] text-sm rounded-md flex items-center gap-3 focus:ring-2 focus:ring-slate-400 outline-none"
                href="#">
                <span class="material-symbols-outlined text-xl" data-icon="inventory_2">inventory_2</span>
                Inventory
            </a>
            <a class="text-slate-600 dark:text-slate-400 px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-900 transition-all font-['Manrope'] text-sm rounded-md flex items-center gap-3 focus:ring-2 focus:ring-slate-400 outline-none"
                href="#">
                <span class="material-symbols-outlined text-xl" data-icon="receipt_long">receipt_long</span>
                Orders
            </a>
            <a class="text-slate-600 dark:text-slate-400 px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-900 transition-all font-['Manrope'] text-sm rounded-md flex items-center gap-3 focus:ring-2 focus:ring-slate-400 outline-none"
                href="#">
                <span class="material-symbols-outlined text-xl" data-icon="group">group</span>
                Customers
            </a>
            <a class="text-slate-600 dark:text-slate-400 px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-900 transition-all font-['Manrope'] text-sm rounded-md flex items-center gap-3 focus:ring-2 focus:ring-slate-400 outline-none"
                href="#">
                <span class="material-symbols-outlined text-xl" data-icon="analytics">analytics</span>
                Analytics
            </a>
        </div>
        <!-- CTA -->
        <div class="px-6 my-6">
            <button
                class="w-full bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold py-2 px-4 rounded-md font-['Manrope'] text-sm hover:opacity-90 transition-opacity flex items-center justify-center gap-2 focus:ring-2 focus:ring-slate-400 outline-none">
                <span class="material-symbols-outlined text-lg" data-icon="add">add</span>
                Add Product
            </button>
        </div>
        <!-- Footer Links -->
        <div class="mt-auto flex flex-col gap-1 px-4 border-t border-slate-200 dark:border-slate-800 pt-4">
            <a class="text-slate-600 dark:text-slate-400 px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-900 transition-all font-['Manrope'] text-sm rounded-md flex items-center gap-3 focus:ring-2 focus:ring-slate-400 outline-none"
                href="#">
                <span class="material-symbols-outlined text-xl" data-icon="settings">settings</span>
                Settings
            </a>
            <a class="text-slate-600 dark:text-slate-400 px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-900 transition-all font-['Manrope'] text-sm rounded-md flex items-center gap-3 focus:ring-2 focus:ring-slate-400 outline-none"
                href="#">
                <span class="material-symbols-outlined text-xl" data-icon="help_outline">help_outline</span>
                Support
            </a>
        </div>
    </nav>
</template>
