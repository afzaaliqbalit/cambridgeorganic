<?php get_header( 'shop' ); ?>

    <div id="customer-profile" class="container page-wrap">
        <?php echo get_template_part('customer/inc/header') ?>

        <?php
        $user = new User();
        $orders = $user->getCustomerOrders();
        $profile = $user->getCustomer();

        $customer_points = $profile['remaining_points'];
        ?>

        <div id="profile-orders" class="body-content">
            <?php
/*<section>
                <div class="head-text">
                    <h4>Set Your 3 Dislikes</h4>
                    <p>Tell us up to three things you Dislike in your Veg Box just so we know. You can change this at any time.</p>
                </div>

                <div class="content-box">
                    <div class="actions-box">
                        <div class="box-items">
                            <div class="text-checkbox">
                                <input type="checkbox" name="dislike_item">
                                <span>Apples</span>
                            </div>
                            <div class="text-checkbox">
                                <input type="checkbox" name="dislike_item">
                                <span>Beetroot</span>
                            </div>
                            <div class="text-checkbox">
                                <input type="checkbox" name="dislike_item">
                                <span>Mushrooms</span>
                            </div>
                        </div>
                        <div class="box-actions" style="flex: 0.18">
                            <a href="" class="button button-round btn-red btn-secondary fs-14"><i class="icon-vegebox"></i> Choose 3 Dislikes</a>
                            <a href="" class="button button-round btn-secondary fs-14"><i class="icon-vegebox"></i> Edit Your 3 Dislikes</a>
                        </div>
                    </div>
                </div>

            </section>*/
            /*
                        if(!empty($orders)) {
                         /* ?>
                        <section>
                            <div class="head-text">
                                <h4>Subscriptions</h4>
                            </div>
                            <form class="form">
                                <?php foreach ($orders as $order) {
                                    foreach($order['selectedProducts'] as $product) {
                                    ?>
                                <div class="actions-box">
                                    <div class="box-items">
                                        <div class="inline-inputs">
                                            <div>
                                                <label>Name</label>
                                                <?php echo $product['name'] ?>
                                            </div>
                                            <div>
                                                <label>Size</label>
                                                <select class="select w-100">
                                                    <option>Small</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label>Option</label>
                                                <select class="select w-100">
                                                    <option>Build Your Own ― Choice</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label>Frequency</label>
                                                <select class="select w-100">
                                                    <option>Weekly</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-actions" style="justify-content: end; padding-bottom: 7px;">
                                        <a href="" class="button button-round btn-secondary fs-14"><i class="icon-vegebox"></i> Click To Change Your Box</a>
                                    </div>
                                </div>
                                <?php
                                    }
                                } ?>
                            </form>
                        </section>
                <?php }*/
                ?>
            <section>
            <div class="head-text">
                <h4>Next Order</h4>
            </div>

            <?php
            $order = $user->nextOrder();
            if(!empty($order)) {
                $totalPrice = $order['totalPrice'];
                $selectedProducts = $order['selectedProducts'];
                $orderStatus  = $order['orderStatus'];
                $points_used = 0;
                $deliveryDates = $order['deliveryDates'][0] ?? '';

                    foreach($selectedProducts as $product) {
                        $points_used += $product['points'];
                    }
                ?>
                <div>
                    <div class="content-box w-100">
                        <div class="content-head w-100">
                            <div class="d-flex justify-content-between w-100">
                                <div class="d-flex gap-3">
                                    <div class="d-flex gap-2">
                                        <i class="icon-vegebox"></i> <?php echo date('l ― d/m/Y', strtotime($deliveryDates)); ?>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <?php echo price($totalPrice) ?>
                                    </div>
                                </div>

                                <div class="d-flex gap-3">
                                    <p class="mb-0">Points Used: <?php echo $points_used ?> / <?php echo $customer_points ?></p>
                                    <p class="mb-0">Order Status: <?php echo $orderStatus ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-box w-100">
                    <?php
                    $single_products = [];
                    foreach($selectedProducts as $product) {

                        if($product['type'] !== 'single') {
                            $child_products = $product['child_products'];
                        ?>

                        <div class="content-table">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th width="22%">Box & Contents</th>
                                        <th width="12%">Price</th>
                                        <th width="10%">Quantity</th>
                                        <th width="10%">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><p><?php echo $product['name'] ?></p></td>
                                        <td class="text-center"><?php echo price($product['price']) ?></td>
                                        <td class="text-center"><p><?php echo $product['qty'] ?></p></td>
                                        <td class="text-center"><p><?php echo price($product['subtotal']) ?></p></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <table class="table w-100">
                                                <thead>
                                                <tr>
                                                    <th width="22%">Box & Contents</th>
                                                    <th width="12%">Measure</th>
                                                    <th width="10%">Quantity</th>
                                                    <th width="12%">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($child_products as $child) { ?>
                                                    <tr>
                                                        <td width="22%"><?php echo $child['name'] ?></td>
                                                        <td width="12%" class="text-center"><?php echo product_weight($child) ?></td>
                                                        <td width="10%" class="text-center"><?php echo $child['quantity'] ?></td>
                                                        <td width="12%" class="text-center">
                                                            <a href="" class="btn-secondary button fs-14">Change</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php }
                        else {
                            $single_products[] = $product;
                        }
                    }
                    $points_msg = '';

                    if($points_used < $customer_points) {
                        $rem_points = $customer_points - $points_used;
                        $points_msg = 'You have '.$rem_points.' Points remaining for this Box ― Click the ‘Edit Your Choices’ button to add more items';
                    }
                    if($points_used > $customer_points) {
                        $rem_points = $points_used - $customer_points;
                        $points_msg = 'You have used '.$rem_points.' extra points for this Box ― Click the ‘Edit Your Choices’ button to remove items';
                    }
                    if($rem_points) {
                    ?>

                        <div id="points-box" class="actions-box">
                            <div class="action-head w-100 d-flex align-items-center justify-content-center" style="flex: 1">
                                <p class="pb-0 mb-0 text-center"><?php echo $points_msg ?></p>
                            </div>
                            <div class="action-table box-actions">
                                <a href="" class="button button-round btn-secondary btn-red fs-14"><i class="icon-vegebox"></i> Edit Your Choices</a>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if(!empty($single_products)) { ?>
                        <div class="content-table">
                            <table class="table w-100">
                                <thead>
                                <tr>
                                    <th width="22%">Additional Items</th>
                                    <th width="12%">Measure</th>
                                    <th width="10%">Points</th>
                                    <th width="10%">Price</th>
                                    <th width="10%">Quantity</th>
                                    <th width="12%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($selectedProducts as $product) {
                                        if($product['type'] == 'single') {
                                          ?>
                                                <tr>
                                                    <td width="22%"><?php echo $product['name'] ?></td>
                                                    <td width="12%" class="text-center"><?php echo product_weight($product) ?></td>
                                                    <td width="10%" class="text-center"><?php echo $product['points'] ?></td>
                                                    <td width="10%" class="text-center"><?php echo price($product['gross_selling_price']) ?></td>
                                                    <td width="10%" class="text-center"><?php echo $product['qty'] ?></td>
                                                    <td width="12%" class="text-center">
                                                        <a href="" class="btn-secondary button fs-14">Change</a>
                                                    </td>
                                                </tr>
                                          <?php
                                        }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                        <div class="content-table mt-5">
                            <div class="d-flex justify-content-between">
                                <a href="" class="button icon-button button-round btn-secondary btn-red fs-14"><i class="icon-vegebox"></i> Add to Order</a>
                                <a href="" class="button icon-button button-round btn-secondary btn-red fs-14"><i class="icon-truck"></i> Edit Schedule</a>
                            </div>
                        </div>
                    </div>
                </div>


            <?php
            }?>
            </section>

            <section>
                <div class="head-text">
                    <h4>Future Orders</h4>
                </div>
                <div class="content-box w-100 text-center" style="background-color: #e6e6e6">
                    <a href="" class="btn icon-button button-rounded button btn-secondary"><i class="icon-vegebox"></i> View Future Orders</a>
                </div>
            </section>

            <section>
                <div class="head-text">
                    <h4>Order History</h4>
                </div>

                <?php
                if(!empty($orders)) {
                    foreach($orders as $order) {
                    $totalPrice = $order['totalPrice'];
                    $selectedProducts = $order['selectedProducts'];
                    $orderStatus  = $order['orderStatus'];
                    $points_used = 0;
                    $deliveryDates = $order['deliveryDates'][0] ?? '';

                    foreach($selectedProducts as $product) {
                        $points_used += $product['points'];
                    }
                    ?>
                    <div>
                        <div class="content-box w-100">
                            <div class="content-head w-100">
                                <div class="d-flex justify-content-between w-100">
                                    <div class="d-flex gap-3">
                                        <div class="d-flex gap-2">
                                            <i class="icon-vegebox"></i> <?php echo date('l ― d/m/Y', strtotime($deliveryDates)); ?>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <?php echo price($totalPrice) ?>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-3">
                                        <p class="mb-0">Points Used: <?php echo $points_used ?> / <?php echo $customer_points ?></p>
                                        <p class="mb-0">Order Status: <?php echo $orderStatus ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content-box w-100">
                            <?php
                            $single_products = [];
                            foreach($selectedProducts as $product) {

                                if($product['type'] !== 'single') {
                                    $child_products = $product['child_products'];
                                    ?>

                                    <div class="content-table">
                                        <table class="table w-100">
                                            <thead>
                                            <tr>
                                                <th width="22%">Box & Contents</th>
                                                <th width="12%">Price</th>
                                                <th width="10%">Quantity</th>
                                                <th width="10%">Subtotal</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><p><?php echo $product['name'] ?></p></td>
                                                <td class="text-center"><?php echo price($product['price']) ?></td>
                                                <td class="text-center"><p><?php echo $product['qty'] ?></p></td>
                                                <td class="text-center"><p><?php echo price($product['subtotal']) ?></p></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">
                                                    <table class="table w-100">
                                                        <thead>
                                                        <tr>
                                                            <th width="22%">Box & Contents</th>
                                                            <th width="12%">Measure</th>
                                                            <th width="10%">Quantity</th>
                                                            <th width="12%">Actions</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php foreach($child_products as $child) { ?>
                                                            <tr>
                                                                <td width="22%"><?php echo $child['name'] ?></td>
                                                                <td width="12%" class="text-center"><?php echo product_weight($child) ?></td>
                                                                <td width="10%" class="text-center"><?php echo $child['quantity'] ?></td>
                                                                <td width="12%" class="text-center">
                                                                    <a href="" class="btn-secondary button fs-14">Change</a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php }
                                else {
                                    $single_products[] = $product;
                                }
                            }
                            if(!empty($single_products)) {
                             ?>
                            <div class="content-table">
                                <table class="table w-100">
                                    <thead>
                                    <tr>
                                        <th width="22%">Additional Items</th>
                                        <th width="12%">Measure</th>
                                        <th width="10%">Points</th>
                                        <th width="10%">Price</th>
                                        <th width="10%">Quantity</th>
                                        <th width="12%">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($single_products as $product) {
                                        if($product['type'] == 'single') {
                                            ?>
                                            <tr>
                                                <td width="22%"><?php echo $product['name'] ?></td>
                                                <td width="12%" class="text-center"><?php echo product_weight($product) ?></td>
                                                <td width="10%" class="text-center"><?php echo $product['points'] ?></td>
                                                <td width="10%" class="text-center"><?php echo price($product['gross_selling_price']) ?></td>
                                                <td width="10%" class="text-center"><?php echo $product['qty'] ?></td>
                                                <td width="12%" class="text-center">
                                                    <a href="" class="btn-secondary button fs-14">Report</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                                <?php } ?>

                        </div>
                    </div>
                    <?php
                    }
                }?>

                <?php /*<div class="content-box w-100">
                    <div class="content-head w-100">
                        <div class="d-flex justify-content-between w-100">
                            <div class="d-flex gap-3">
                                <div class="d-flex gap-2">
                                    <i class="icon-vegebox"></i> Monday ― DD/MM/YYYY
                                </div>
                                <div class="d-flex gap-2">
                                    <?php echo price(0) ?>
                                </div>
                            </div>

                            <div>
                                <button type="button" class="btn icon-button button-rounded button btn-secondary fs-14" onclick="report_delivery_popup()">Report Whole Delivery</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-box w-100">
                    <div class="content-table">
                        <table class="table w-100">
                            <thead>
                            <tr>
                                <th width="22%">Box & Contents</th>
                                <th width="12%">Measure</th>
                                <th width="10%">Points</th>
                                <th width="10%">Quantity</th>
                                <th width="10%">Status</th>
                                <th width="12%">Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td colspan="6">
                                    <p>Veg Box ― Build Your Own (Choice) ― Small</p>
                                    <table class="table w-100">
                                        <tbody>
                                        <tr>
                                            <td width="22%">Carrots</td>
                                            <td width="12%" class="text-center">150g</td>
                                            <td width="10%" class="text-center">1</td>
                                            <td width="10%" class="text-center">3</td>
                                            <td width="10%" class="text-center">Ordered</td>
                                            <td width="12%" class="text-center">
                                                <button class="btn-secondary button fs-14" onclick="report_delivery_item_popup()">Report</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="22%">Carrots</td>
                                            <td width="12%" class="text-center">150g</td>
                                            <td width="10%" class="text-center">1</td>
                                            <td width="10%" class="text-center">3</td>
                                            <td width="10%" class="text-center color-red">Reported</td>
                                            <td width="12%" class="text-center">
                                                <button class="btn-primary button fs-14" onclick="report_view_delivery_item_popup()">View</button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>*/ ?>

            </section>
        </div>
    </div>

<?php get_footer( 'shop' ); ?>