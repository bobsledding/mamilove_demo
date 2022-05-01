<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Order;
use App\Http\Controllers\Order\OrderProcessor;

class OrderProcessorTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testProcessNormal()
    {
        $biller = new DefaultBiller();
        $account = App\Account::find(TEST_ACCOUNT_ID);
        $order = new Order;
        $order->account = $account;
        $order->amount = 10;

        try {
            $orderProcessor = new OrderProcessor($biller);
            $orderProcessor->process($order);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }

        $this->assertTrue(true);
    }

    public function testProcessDuplicateOrder()
    {
        $biller = new DefaultBiller();
        $account = App\Account::find(TEST_ACCOUNT_ID);
        $order = new Order;
        $order->account = $account;
        $order->amount = 10;

        try {
            $orderProcessor = new OrderProcessor($biller);
            $orderProcessor->process($order);
            $orderProcessor->process($order);
        } catch (Exception $e) {
            $this->assertTrue(true);
        }

        $this->assertTrue(false);
    }
}
