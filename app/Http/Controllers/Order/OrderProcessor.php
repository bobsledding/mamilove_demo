<?

use App\Order;

class OrderProcessor
{
    public function __construct(BillerInterface $biller)
    {
        $this->biller = $biller;
    }

    public function process(Order $order)
    {
        $recent = App\Order::getRecentOrderCount($order->account->id);

        if ($recent > 0)
        {
            throw new Exception('Duplicate order likely.');
        }

        $this->biller->bill($order->account->id, $order->amount);

        $order->created_at = Carbon::now();
        $order->save();
    }
}