<template>
    <aside class="w-full md:w-64">
        <div class="sticky top-24">
            <h2 class="font-semibold tracking-tight text-xl leading-snug text-slate-900 mb-4">Filters</h2>
            <div class="space-y-md">
                
                <!-- Category Filter -->
                <div class="border-b border-slate-200 pb-4">
                    <h3 class="font-semibold text-sm text-slate-900 mb-2">Category</h3>
                    <div class="space-y-sm">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input checked
                                class="form-checkbox h-4 w-4 text-slate-900 border-slate-200 rounded-md focus:ring-primary"
                                type="checkbox" />
                            <span class="font-normal text-base text-slate-900">All Products</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input
                                class="form-checkbox h-4 w-4 text-slate-900 border-slate-200 rounded-md focus:ring-primary"
                                type="checkbox" />
                            <span class="font-normal text-base text-slate-900">Electronics</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input
                                class="form-checkbox h-4 w-4 text-slate-900 border-slate-200 rounded-md focus:ring-primary"
                                type="checkbox" />
                            <span class="font-normal text-base text-slate-900">Home &amp; Garden</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input
                                class="form-checkbox h-4 w-4 text-slate-900 border-slate-200 rounded-md focus:ring-primary"
                                type="checkbox" />
                            <span class="font-normal text-base text-slate-900">Apparel</span>
                        </label>
                    </div>
                </div>

                <!-- Price Range Filter -->
                <div class="border-b border-slate-200 pb-4">
                    <h3 class="font-semibold text-sm text-slate-900 mb-2">Price Range</h3>
                    <div class="flex items-center space-x-2">
                        <input
                            class="w-full bg-white border border-slate-200 rounded-md p-2 font-normal text-base text-slate-900 focus:border-slate-900 focus:ring-0"
                            placeholder="Min" type="text" />
                        <span class="text-slate-900">-</span>
                        <input
                            class="w-full bg-white border border-slate-200 rounded-md p-2 font-normal text-base text-slate-900 focus:border-slate-900 focus:ring-0"
                            placeholder="Max" type="text" />
                    </div>
                </div>

                <!-- Stock Status Filter -->
                <div>
                    <h3 class="font-semibold text-sm text-slate-900 mb-2">Availability</h3>
                    <div class="space-y-sm">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input checked
                                class="form-radio h-4 w-4 text-slate-900 border-slate-200 focus:ring-primary"
                                name="stock" type="radio" />
                            <span class="font-normal text-base text-slate-900">In Stock</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input class="form-radio h-4 w-4 text-slate-900 border-slate-200 focus:ring-primary"
                                name="stock" type="radio" />
                            <span class="font-normal text-base text-slate-900">Out of Stock</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</template>
