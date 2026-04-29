<template>
    <section class="w-full max-w-[1280px] mx-auto px-6 py-16">
        <div class="flex items-end justify-between mb-8">
            <div>
                <h2 class="font-headline-lg text-headline-lg text-on-surface">Curated Categories</h2>
                <p class="font-body-md text-body-md text-on-surface-variant mt-2">Explore our finest selections
                    across domains.</p>
            </div>
            <a class="font-label-md text-label-md text-primary flex items-center gap-1 hover:underline" href="#">
                View All <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 h-auto md:h-[500px]">
            <!-- Category 1: Electronics (Large) -->
            <a class="md:col-span-2 relative rounded-xl overflow-hidden group bg-surface-container-highest border border-surface-variant"
                href="#">
                <img alt="Electronics workspace"
                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105"
                    data-alt="Modern clean desk setup with sleek laptop, mechanical keyboard, and minimal accessories bathed in cool architectural lighting"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCYqVG1bPAuaot8LZjYQTGUGL7oCrcQsxP2RydaWYvyg6YBL0FOqWIKaW5lyIKIeGtJ3ZO1dfiyNFgjtbOyaLbj_deHKdq6sbtyRuQt3-RQWl6BEveEPC7bZyssMLOtHl3NHTYEIeiYKFTUfzrM6QvZfp0SiEKv1jSvcpkHQ0XeJ7rM38Bv5uG4YJU7-JxRJrPjjgKiCuiHO3xYWlBgICpGgsps0H9TJXlN2d-DZl0zmyfjlAXcMQfy0rJ4INk3cdGwD-qJO4tjNYvK" />
                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/40 transition-colors"></div>
                <div class="absolute bottom-0 left-0 p-8 w-full bg-gradient-to-t from-black/80 to-transparent">
                    <h3 class="font-headline-md text-headline-md text-white mb-2">High-Fidelity Electronics</h3>
                    <p class="font-body-md text-body-md text-white/80 max-w-md">State-of-the-art devices for
                        productivity and entertainment.</p>
                </div>
            </a>

            <!-- Category 2 & 3 (Stacked vertically on desktop) -->
            <div class="flex flex-col gap-6">
                <a class="flex-1 relative rounded-xl overflow-hidden group bg-surface-container-highest border border-surface-variant"
                    href="#">
                    <img alt="Fashion coats"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105"
                        data-alt="Row of premium tailored wool coats hanging on a minimal rail in a brightly lit boutique"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuAYUS08R0Szh5Jx0wduYqRBT7Ki1k-wqfD9tMcvIlbxUrx7PywOmg5RsgyRGzVFMO5DhkARb1pbPx0tKm1oK9NGdbhSwpvK3tZ0LPlJ4VDloxyyMLavnqHsQbpGxsKJBohTF_wmQ9NQovfAxoeqaimXa2bKKaAFSXFseiFhsgnEoBfdb4GVVpS6UpPptgIYpYqN5PKoRZY8K9g_UyNC_aa1z2k-Do7T_Ux9qzmTAjQvISS9xoX4JuH_hhqdlveQPYgAjbh1lpl8E5Nm" />
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors"></div>
                    <div class="absolute bottom-0 left-0 p-6 w-full bg-gradient-to-t from-black/70 to-transparent">
                        <h3 class="font-headline-md text-headline-md text-white">Avant-Garde Fashion</h3>
                    </div>
                </a>

                <a class="flex-1 relative rounded-xl overflow-hidden group bg-surface-container-highest border border-surface-variant"
                    href="#">
                    <img alt="Modern living room"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105"
                        data-alt="Minimalist modern living room corner with a sculptural lounge chair and soft warm morning sunlight casting shadows"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCcZEI8yj9rt0ybIkNT0SInlRxsF48NCt-ZIMWyZSfS43VFNAqq9_MfZ9tfChxa9i631_REBy-tIwIxG4Gr96og_oNtAoNdZBTiD9P7Wa4bHS4tGAd0CYjawDrb8Jpp0Bf7xdC5_PGxzzeOeC8WgSOJdOavxqJtGAnOZmGjuNSPBvsun1OpRc5O2SrgFzWIxLGTbS39SuwGlni3_FghJxObu8G5_vYozactK4uJtYtUOF5AlBmSCeFiV0IREsSNIyei2W1kFyiiP9WV" />
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors"></div>
                    <div class="absolute bottom-0 left-0 p-6 w-full bg-gradient-to-t from-black/70 to-transparent">
                        <h3 class="font-headline-md text-headline-md text-white">Bespoke Home</h3>
                    </div>
                </a>
            </div>
        </div>
    </section>
</template>
