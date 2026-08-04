<template id="hyperproduct-order-builder-popup">
    <div id="hyperproduct-order-builder-wrapper">
        <div id="hyperproduct-order-builder" class="text-center mb-4">
            <h2 class="h4 fw-bold text-emerald-950 mb-1">Build Your Order</h2>
            <p class="text-muted small">We need you to build your Box for this week’s Delivery:</p>
        </div>

        <!-- Main Form Wrapper -->
        <form id="veg-box-form" onsubmit="event.preventDefault();">

            <!-- HIDDEN INPUT FIELD TO COLLECT ALL SELECTED ITEMS -->
            <input type="hidden" name="selected_items" id="selected-items-input" value="[]">

            <!-- Main Container Box -->
            <div class="main-box-card p-3 p-md-4 shadow-sm text-start">

                <!-- Top Toolbar: Search Bar + Points Used Display -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mb-4 pb-2">
                    <!-- Search Input Box -->
                    <div class="search-wrapper">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="search-input" class="form-control form-control-md" placeholder="Search this week's availability...">
                    </div>

                    <!-- Points Counter -->
                    <div class="fs-5 fw-medium text-emerald-950 d-flex align-items-center gap-2">
                        <span>Points Used</span>
                        <span class="text-muted">—</span>
                        <span class="fw-bold text-wine-red fs-4" id="points-summary-badge">
                                    <span id="points-used-counter">0</span> / <span id="points-limit-counter">0</span>
                                </span>
                    </div>
                </div>

                <!-- Grid Content -->
                <div class="row g-4 align-items-stretch">

                    <!-- LEFT COLUMN: Item Availability List -->
                    <div class="col-lg-7 vertical-divider">
                        <div class="custom-scroll pe-2" id="items-container">
                            <!-- Dynamic items injected via JavaScript -->
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: Summary & Points Details -->
                    <div class="col-lg-5 d-flex flex-column justify-content-between ps-lg-4">
                        <div>
                            <!-- Header Icon & Box Title -->
                            <div class="text-center mb-4">
                                <div class="d-flex align-items-center justify-content-center gap-2 text-emerald-900 fw-bold fs-5">
                                    <!-- Box SVG Icon -->
                                    <svg width="24" height="24" fill="currentColor" class="text-emerald-800" viewBox="0 0 24 24">
                                        <path d="M19 7h-3V5c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2H5c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2zm-8-2h2v2h-2V5zm8 14H5V9h14v10z"/>
                                        <path d="M7 11h2v6H7zm4 0h2v6h-2zm4 0h2v6h-2z"/>
                                    </svg>
                                    <span>Build Your Own</span>
                                </div>
                                <div class="text-emerald-900 fw-medium small">
                                    (Choice) Veg Box — Small
                                </div>
                            </div>

                            <!-- Summary Table Section -->
                            <div class="mb-4">
                                <h6 class="text-center text-secondary fw-semibold small mb-3">Summary of your Box</h6>

                                <!-- Dynamic Selected Items List -->
                                <div id="summary-items-list" class="d-flex flex-column gap-2 small">
                                    <!-- Populated dynamically when quantity > 0 -->
                                </div>

                                <div id="empty-summary-message" class="d-none text-center text-muted py-5 small italic">
                                    Your veg box is currently empty. Add items from the availability list!
                                </div>
                            </div>
                        </div>

                        <!-- Points Calculations & Warning Box -->
                        <div class="pt-3 border-top border-danger-subtle">
                            <div class="text-center text-wine-red">
                                <h6 class="fw-bold mb-1">Our Points System</h6>

                                <p class="fw-semibold small mb-0">
                                    You have gone over your points by:
                                </p>

                                <div id="points-over-count" class="display-6 fw-extrabold my-0">
                                    7
                                </div>

                                <p class="fw-semibold small mb-0">
                                    Incurring an additional cost of:
                                </p>

                                <div id="points-over-cost" class="fs-5 fw-bold my-1">
                                    £3.50
                                </div>

                                <p class="small text-wine-red text-opacity-75 lh-sm mt-2 px-2" style="font-size: 0.82rem;">
                                    You can either amend your order by removing items / choosing lower quantities, or proceed with this additional cost.
                                </p>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </form>

        <hr class="my-4" style="opacity: 0.1;">

        <div class="d-flex gap-3 justify-content-center">
            <button id="hyperproduct-order-builder-confirm" type="button" class="button btn-secondary">Confirm & Save Selection</button>
            <button id="hyperproduct-order-builder-skip" type="button" class="button btn-primary">Skip for now</button>
        </div>
    </div>
</template>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/assets/css/order_builder.css">
<script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/order_builder.js"></script>