<?php
class Cart
{
    /**
     * Session key used to store cart data.
     *
     * @var string
     */
    protected $sessionKey = 'ordle-cart';

    /**
     * Constructor
     */
    public function __construct($sessionKey = 'ordle-cart')
    {
        $this->sessionKey = $sessionKey;
    }

    /**
     * Get complete cart.
     *
     * @return array
     */
    public function getCart()
    {

        $session = get_session($this->sessionKey) ?? [];
        return $session;
    }

    /**
     * Get single cart item.
     *
     * @param string|int $key
     * @param mixed $default
     * @return mixed
     */
    public function getItem($key, $default = null)
    {
        $cart = $this->getCart();

        return $cart[$key] ?? $default;
    }

    public function addProduct($key, $value)
    {
        $cart = $this->getCart();
        $product = new Products();
        $product_info = $product->getProduct($key);

        if (isset($cart[$key])) {
            $cart['products'][$key]['cart_quantity'] += $value['cart_quantity'] ?? 1;
        } else {
            $product_info['cart_quantity'] = $value['cart_quantity'];
            $cart['products'][$key] = $product_info;
        }

        set_session($this->sessionKey, $cart);

        return $cart[$key];
    }

    /**
     * Add or update an item in cart.
     *
     * @param string|int $key
     * @param mixed $value
     * @return mixed
     */
    public function setItem($key, $value)
    {
        $cart = $this->getCart();

        $cart[$key] = $value;

        set_session($this->sessionKey, $cart);

        return $cart[$key];
    }

    /**
     * Delete an item from cart.
     *
     * @param string|int $key
     * @return bool
     */
    public function deleteItem($key)
    {
        $cart = $this->getCart();

        if (!isset($cart['products'][$key])) {
            return false;
        }

        unset($cart['products'][$key]);

        set_session($this->sessionKey, $cart);

        return true;
    }

    public function getCount() {
        $cart = $this->getCart();
      //  pr($cart);
        return !empty($cart['products']) ? count($cart['products']) : 0;
    }

    public function getSubTotal() {
        $cart = $this->getCart();
        $total = 0;
        if(!empty($cart['products'])) {
            foreach($cart['products'] as $item) {
                $total += $item['net_selling_price'] * $item['cart_quantity'];
            }
        }
        return $total;
    }

    public function getTotal() {
        $cart = $this->getCart();
        $total = 0;
        if(!empty($cart['products'])) {
            foreach($cart['products'] as $item) {
                $total += $item['net_selling_price'] * $item['cart_quantity'];
            }
        }
        return $total;
    }

    public function deliveryCost() {
        return 0;
    }

    public function getRouteInfo($fetchInfo=[]) {
        if(empty($fetchInfo['id'])) {
            $cart = $this->getCart();
            $route_id = $cart['delivery_route'];
        }else {
            $route_id = $fetchInfo['id'];
        }

        if(!empty($fetchInfo['reload']) || empty($_SESSION['delivery_route_info'][$route_id]['next_delivery_date'])) {
            $apiClient = new APIClient();
            $fetchRec = $apiClient->request('GET', '/getRouteInfo/'.$route_id);
            if(empty($fetchRec['success'])) {
                return [
                    'success' => false,
                    'message' => 'Failed to fetch route information'
                ];
            }
            $fetchInfo = $fetchRec['data'];
            $_SESSION['delivery_route_info'][$route_id] = $fetchInfo;
        }

        if(isset($_SESSION['ordle-cart']['routeDay'])) {
            $routeDay = $_SESSION['ordle-cart']['routeDay'];
        }else {
            $routeDay = $fetchInfo['RouteDay'];
        }

        $next_delivery_day = false;
        $next_delivery_date = null;
        $next_delivery_day_num = null;
        $next_delivery_month = null;

        if(isset($_SESSION['ordle-cart']['routeName'])) {
            $routeName = $_SESSION['ordle-cart']['routeName'];
        }else {
            $routeName = !empty($fetchInfo['RouteName']) ? $fetchInfo['RouteName'] : '';
        }

        $weekDays = weekDays();
        $day = $routeDay;

        $dayIndex = array_search($day, $weekDays, true);

        if ($dayIndex !== false) {

            $today = new DateTime();
            $currentDay = (int)$today->format('N'); // 1 (Mon) - 7 (Sun)

            $dayNumber = $dayIndex + 1;

            // Days until next occurrence
            $diff = ($dayNumber - $currentDay + 7) % 7;

            // If today is the delivery day, return next week's date
            if ($diff == 0) {
                $diff = 7;
            }

            $nextDate = clone $today;
            $nextDate->modify("+{$diff} days");

            $next_delivery_day = $day;
            $next_delivery_date = $nextDate->format('Y-m-d');
            $next_delivery_day_num = $nextDate->format('d');
            $next_delivery_month = $nextDate->format('m');
        }


        if(!empty($_SESSION['ordle-cart']['next_delivery_date'])) {
            $next_delivery_date = $_SESSION['ordle-cart']['next_delivery_date'];
            $next_delivery_month = date('m', strtotime($next_delivery_date));
        }
        if(!empty($_SESSION['ordle-cart']['delivery_route'])) {
            $route_id = $_SESSION['ordle-cart']['delivery_route'];
        }

        return [
            'success' => true,
            'id' => $route_id,
            'routeName' => $routeName,
            'routeDay' => $routeDay,
            'next_delivery_day' => $next_delivery_day,
            'next_delivery_day_num' => $next_delivery_day_num,
            'next_delivery_month' => $next_delivery_month,
            'next_delivery_date' => $next_delivery_date,
        ];
    }

    public function clear() {
        unset($_SESSION[$this->sessionKey]);
    }
}