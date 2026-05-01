<template>
    <aside class="w-full md:w-64">
        <div class="sticky top-24">
            <h2 class="font-headline-md text-headline-md text-on-surface mb-md">Filters</h2>
            <div class="space-y-md">
                
                <!-- Category Filter -->
                <div class="border-b border-outline-layout pb-md">
                    <h3 class="font-label-md text-label-md text-on-surface mb-sm">Category</h3>
                    <div class="space-y-sm">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input checked
                                class="form-checkbox h-4 w-4 text-primary border-outline-layout rounded-DEFAULT focus:ring-primary"
                                type="checkbox" />
                            <span class="font-body-md text-body-md text-on-surface-layout">All Products</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input
                                class="form-checkbox h-4 w-4 text-primary border-outline-layout rounded-DEFAULT focus:ring-primary"
                                type="checkbox" />
                            <span class="font-body-md text-body-md text-on-surface-layout">Electronics</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input
                                class="form-checkbox h-4 w-4 text-primary border-outline-layout rounded-DEFAULT focus:ring-primary"
                                type="checkbox" />
                            <span class="font-body-md text-body-md text-on-surface-layout">Home &amp; Garden</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input
                                class="form-checkbox h-4 w-4 text-primary border-outline-layout rounded-DEFAULT focus:ring-primary"
                                type="checkbox" />
                            <span class="font-body-md text-body-md text-on-surface-layout">Apparel</span>
                        </label>
                    </div>
                </div>

                <!-- Price Range Filter -->
                <div class="border-b border-outline-layout pb-md">
                    <h3 class="font-label-md text-label-md text-on-surface mb-sm">Price Range</h3>
                    <div class="flex items-center space-x-2">
                        <input
                            class="w-full bg-surface-container-lowest border border-outline-layout rounded-DEFAULT p-sm font-body-md text-body-md text-on-surface focus:border-primary focus:ring-0"
                            placeholder="Min" type="text" />
                        <span class="text-on-surface-layout">-</span>
                        <input
                            class="w-full bg-surface-container-lowest border border-outline-layout rounded-DEFAULT p-sm font-body-md text-body-md text-on-surface focus:border-primary focus:ring-0"
                            placeholder="Max" type="text" />
                    </div>
                </div>

                <!-- Stock Status Filter -->
                <div>
                    <h3 class="font-label-md text-label-md text-on-surface mb-sm">Availability</h3>
                    <div class="space-y-sm">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input checked
                                class="form-radio h-4 w-4 text-primary border-outline-layout focus:ring-primary"
                                name="stock" type="radio" />
                            <span class="font-body-md text-body-md text-on-surface-layout">In Stock</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input class="form-radio h-4 w-4 text-primary border-outline-layout focus:ring-primary"
                                name="stock" type="radio" />
                            <span class="font-body-md text-body-md text-on-surface-layout">Out of Stock</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</template>
