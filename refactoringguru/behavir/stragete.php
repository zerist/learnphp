<?php

namespace zerist\behavir\stragete;

//class represent Order

/**
 * Class Order
 * @package zerist\behavir\stragete
 */
class Order
{
    /**
     * @var array
     */
    private static $orders = [];


    /**
     * @param int|null $orderId
     * @return array|mixed
     */
    public static function get(int $orderId = null)
    {
        if ($orderId === null) {
            return self::$orders;
        } else {
            return self::$orders[$orderId];
        }
    }

    public function __construct(array $arrtributes)
    {
        $this->id = count(self::$orders);
        $this->status = "new";
        foreach ($arrtributes as $key => $value) {
            $this->{$key} = $value;
        }
        self::$orders[$this->id] = $this;
    }


    public function complete(): void
    {
        $this->status = "completed";
        echo "Order: #{$this->id} is now {$this->status}.\n";
    }
}

//stratege class factory
class PaymentFactory
{
    public static function getPaymentMethod(string $id): PaymentMethod
    {
        switch ($id) {
            case "cc":
                return new CreditCardPayment();
        }
    }
}

//strategy interface

/**
 * Interface PaymentMethod
 * @package zerist\behavir\stragete
 */
interface PaymentMethod
{
    public function getPaymentForm(Order $order): string;

    public function validateReturn(Order $order, array $data): bool;
}

//concrete strategy class
class CreditCardPayment implements PaymentMethod
{
    static private $store_secret_key = "xukang";

    public function getPaymentForm(Order $order): string
    {
        // TODO: Implement getPaymentForm() method.
        $returlUrl = "https://store.com/" . "order/{$order->id}/payment/cc/return";
        return <<<FORM
<form action="https://credit_processor.com/charge" method="POST">
FORM;

    }
}