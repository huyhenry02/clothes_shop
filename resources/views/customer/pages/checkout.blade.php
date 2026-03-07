@extends('customer.layouts.main')
@section('content')
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ route('customer.showIndex') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Trang chủ
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <a href="{{ route('customer.showCart') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Giỏ hàng
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                Thanh toán
            </span>
        </div>
    </div>

    <form action="{{ route('customer.storeOrder') }}" method="POST" class="bg0 p-t-75 p-b-85">
        @csrf
        <div class="container">

            @if(session('error'))
                <div class="alert alert-danger m-b-20">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                <div class="col-lg-7 col-xl-7 m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            Thông tin nhận hàng
                        </h4>

                        <div class="bor8 bg0 m-b-12">
                            <input class="stext-111 cl8 plh3 size-111 p-lr-15"
                                   type="text"
                                   name="shipping_name"
                                   placeholder="Họ và tên người nhận"
                                   value="{{ old('shipping_name') }}">
                        </div>
                        @error('shipping_name')
                        <small class="text-danger d-block m-b-10">{{ $message }}</small>
                        @enderror

                        <div class="bor8 bg0 m-b-12">
                            <input class="stext-111 cl8 plh3 size-111 p-lr-15"
                                   type="text"
                                   name="shipping_phone"
                                   placeholder="Số điện thoại"
                                   value="{{ old('shipping_phone') }}">
                        </div>
                        @error('shipping_phone')
                        <small class="text-danger d-block m-b-10">{{ $message }}</small>
                        @enderror

                        <div class="bor8 bg0 m-b-12">
                            <input class="stext-111 cl8 plh3 size-111 p-lr-15"
                                   type="email"
                                   name="shipping_email"
                                   placeholder="Email"
                                   value="{{ old('shipping_email') }}">
                        </div>
                        @error('shipping_email')
                        <small class="text-danger d-block m-b-10">{{ $message }}</small>
                        @enderror

                        <div class="bor8 bg0 m-b-22">
                            <textarea class="stext-111 cl8 plh3 size-111 p-lr-15 p-tb-10"
                                      name="shipping_address"
                                      rows="4"
                                      placeholder="Địa chỉ nhận hàng">{{ old('shipping_address') }}</textarea>
                        </div>
                        @error('shipping_address')
                        <small class="text-danger d-block m-b-10">{{ $message }}</small>
                        @enderror

                        <h4 class="mtext-109 cl2 p-b-20 p-t-20">
                            Phương thức thanh toán
                        </h4>

                        <div class="m-b-10">
                            <label>
                                <input type="radio" name="payment_method" value="cod" {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}>
                                Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>

                        <div class="m-b-10">
                            <label>
                                <input type="radio" name="payment_method" value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'checked' : '' }}>
                                Chuyển khoản ngân hàng
                            </label>
                        </div>

                        @error('payment_method')
                        <small class="text-danger d-block m-b-10">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-5 col-xl-5 m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            Đơn hàng của bạn
                        </h4>

                        @foreach($cartItems as $item)
                            @php
                                $price = !empty($item->product->discount_price) && (int)$item->product->discount_price > 0
                                    ? (int)$item->product->discount_price
                                    : (int)($item->product->price ?? 0);

                                $lineTotal = $price * (int)$item->quantity;
                            @endphp

                            <div class="flex-w flex-t bor12 p-b-13 m-b-15">
                                <div style="width: 70%;">
                                    <div class="stext-110 cl2">
                                        {{ $item->product->name ?? 'Sản phẩm' }}
                                    </div>
                                    <div class="stext-111 cl6">
                                        Size: {{ $item->size ?? '---' }} | Màu: {{ $item->color ?? '---' }}
                                    </div>
                                    <div class="stext-111 cl6">
                                        Số lượng: {{ $item->quantity }}
                                    </div>
                                </div>

                                <div style="width: 30%; text-align:right;">
                                    <span class="stext-110 cl2">
                                        {{ number_format($lineTotal, 0, ',', '.') }} đ
                                    </span>
                                </div>
                            </div>
                        @endforeach

                        <div class="flex-w flex-t p-t-27 p-b-33">
                            <div class="size-208">
                                <span class="mtext-101 cl2">Tổng cộng:</span>
                            </div>

                            <div class="size-209 p-t-1">
                                <span class="mtext-110 cl2">
                                    {{ number_format($subtotal, 0, ',', '.') }} đ
                                </span>
                            </div>
                        </div>

                        <button type="submit"
                                class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                            Đặt hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
