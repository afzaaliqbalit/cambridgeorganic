<div class="customer-header">
    <div class="head">
        <h1>Manage Account</h1>
        <p>Use the following icons to edit specific elements of your Account:</p>
    </div>

    <?php
    $curr_page = $GLOBALS['profile_page'];

    $menu_items = [
        [
            'slug'  => 'schedule',
            'label' => 'Schedule',
            'icon'  => 'icon-calender',
            'url'   => site_url('customer/schedule'),
        ],
        [
            'slug'  => 'orders',
            'label' => 'Orders',
            'icon'  => 'icon-vegebox',
            'url'   => site_url('customer/orders'),
        ],
        [
            'slug'  => 'deliveries',
            'label' => 'Deliveries',
            'icon'  => 'icon-truck',
            'url'   => site_url('customer/deliveries'),
        ],
        [
            'slug'  => 'profile',
            'label' => 'Profile',
            'icon'  => 'icon-user',
            'url'   => site_url('customer/profile'),
        ],
        [
            'slug'  => 'payments',
            'label' => 'Payments',
            'icon'  => 'icon-currency',
            'url'   => site_url('customer/payments'),
        ],
        [
            'slug'  => 'contact',
            'label' => 'Contact Us',
            'icon'  => 'icon-message',
            'url'   => site_url('customer/contact'),
        ],
    ];
    ?>

    <div class="body">
        <div class="icon-list">
            <?php foreach ($menu_items as $item) : ?>
                <div>
                    <a href="<?php echo esc_url($item['url']); ?>" class="icon-box <?php echo $curr_page === $item['slug'] ? 'active' : ''; ?>">
                        <i class="<?php echo esc_attr($item['icon']); ?>"></i>
                        <?php echo esc_html($item['label']); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>