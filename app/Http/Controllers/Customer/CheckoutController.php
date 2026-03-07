<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Random\RandomException;
use Throwable;

class CheckoutController extends Controller
{
    protected function getCustomerId()
    {
        $userId = auth()->id();
        $customer = Customer::where('user_id', $userId)->first();
        return $customer->id ?? null;
    }

    protected function getProductPrice($product): int
    {
        if (!empty($product->discount_price) && (int) $product->discount_price > 0) {
            return (int) $product->discount_price;
        }

        return (int) ($product->price ?? 0);
    }

    /**
     * @throws RandomException
     */
    protected function generateOrderCode(): string
    {
        do {
            $orderCode = 'DH' . now()->format('YmdHis') . random_int(100, 999);
        } while (Order::where('order_code', $orderCode)->exists());

        return $orderCode;
    }

    public function showCart()
    {

        $customerId = $this->getCustomerId();

        if (!$customerId) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để xem giỏ hàng.');
        }

        $cartItems = Cart::with('product')
            ->where('customer_id', $customerId)
            ->latest()
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            $price = $this->getProductPrice($item->product);
            return $price * (int) $item->quantity;
        });

        return view('customer.pages.cart', compact('cartItems', 'subtotal'));
    }

    public function addToCart(Request $request): RedirectResponse
    {
        $customerId = $this->getCustomerId();

        if (!$customerId) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.');
        }

        $product = Product::findOrFail($request->product_id);

        $cart = Cart::where('customer_id', $customerId)
            ->where('product_id', $product->id)
            ->where('size', $request->size)
            ->where('color', $request->color)
            ->first();

        if ($cart) {
            $cart->quantity = (int) $cart->quantity + (int) $request->quantity;
            $cart->save();
        } else {
            Cart::create([
                'customer_id' => $customerId,
                'product_id'  => $product->id,
                'size'        => $request->size,
                'color'       => $request->color,
                'quantity'    => $request->quantity,
            ]);
        }

        return redirect()->route('customer.showCart')
            ->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function updateCart(Request $request, $id)
    {
        $customerId = $this->getCustomerId();

        if (!$customerId) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập.');
        }

        $cart = Cart::where('customer_id', $customerId)->findOrFail($id);

        $cart->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('customer.showCart')
            ->with('success', 'Cập nhật giỏ hàng thành công.');
    }

    public function deleteCart($id): RedirectResponse
    {
        $customerId = $this->getCustomerId();

        if (!$customerId) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập.');
        }

        $cart = Cart::where('customer_id', $customerId)->findOrFail($id);
        $cart->delete();

        return redirect()->route('customer.showCart')
            ->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    public function showCheckout()
    {
        $customerId = $this->getCustomerId();

        if (!$customerId) {
            return redirect()->route('customer.showCart')
                ->with('error', 'Vui lòng đăng nhập để thanh toán.');
        }

        $cartItems = Cart::with('product')
            ->where('customer_id', $customerId)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.showCart')
                ->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            $price = $this->getProductPrice($item->product);
            return $price * (int) $item->quantity;
        });

        return view('customer.pages.checkout', compact('cartItems', 'subtotal'));
    }

    public function storeOrder(Request $request): ?RedirectResponse
    {
        $customerId = $this->getCustomerId();

        if (!$customerId) {
            return redirect()->route('customer.showCart')
                ->with('error', 'Vui lòng đăng nhập để đặt hàng.');
        }

        $cartItems = Cart::with('product')
            ->where('customer_id', $customerId)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.showCart')
                ->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        DB::beginTransaction();

        try {
            $totalAmount = $cartItems->sum(function ($item) {
                $price = $this->getProductPrice($item->product);
                return $price * (int) $item->quantity;
            });

            $order = Order::create([
                'customer_id'      => $customerId,
                'order_code'       => $this->generateOrderCode(),
                'total_amount'     => $totalAmount,
                'status'           => 'pending',
                'payment_status'   => $request->payment_method === 'cod' ? 'unpaid' : 'pending',
                'payment_method'   => $request->payment_method,
                'shipping_name'    => $request->shipping_name,
                'shipping_phone'   => $request->shipping_phone,
                'shipping_email'   => $request->shipping_email,
                'shipping_address' => $request->shipping_address,
            ]);

            foreach ($cartItems as $item) {
                $price = $this->getProductPrice($item->product);

                OrderDetail::create([
                    'order_id'    => $order->id,
                    'product_id'  => $item->product_id,
                    'size'        => $item->size,
                    'color'       => $item->color,
                    'quantity'    => $item->quantity,
                    'total_price' => $price * (int) $item->quantity,
                ]);
            }

            Cart::where('customer_id', $customerId)->delete();

            DB::commit();

            return redirect()->route('customer.orders.index')
                ->with('success', 'Đặt hàng thành công.');
        } catch (Throwable $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Đặt hàng thất bại: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $customerId = $this->getCustomerId();

        if (!$customerId) {
            return redirect()->route('customer.showCart')
                ->with('error', 'Vui lòng đăng nhập.');
        }

        $orders = Order::where('customer_id', $customerId)
            ->latest()
            ->get();

        return view('customer.pages.orders', compact('orders'));
    }

    public function show($id)
    {
        $customerId = $this->getCustomerId();

        if (!$customerId) {
            return redirect()->route('customer.showCart')
                ->with('error', 'Vui lòng đăng nhập.');
        }

        $order = Order::with(['orderDetails.product'])
            ->where('customer_id', $customerId)
            ->findOrFail($id);

        return view('customer.pages.order-detail', compact('order'));
    }
}
