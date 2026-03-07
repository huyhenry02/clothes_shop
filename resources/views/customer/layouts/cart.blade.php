<div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
            <span class="mtext-103 cl2">
                Giỏ hàng của bạn
            </span>

            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="header-cart-content flex-w js-pscroll">
            <ul class="header-cart-wrapitem w-full">
                @forelse($cartItemsGlobal as $item)
                    @php
                        $price = (!empty($item->product->discount_price) && (int)$item->product->discount_price > 0)
                            ? (int)$item->product->discount_price
                            : (int)($item->product->price ?? 0);

                        $image = $item->product->image_detail_1 ?? '/customer/images/item-cart-01.jpg';
                    @endphp

                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img src="{{ $image }}" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a href="{{ route('customer.showProductDetail', $item->product->id) }}"
                               class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                {{ $item->product->name ?? 'Sản phẩm' }}
                            </a>

                            <span class="header-cart-item-info d-block">
                                Size: {{ $item->size ?? '---' }} | Màu: {{ $item->color ?? '---' }}
                            </span>

                            <span class="header-cart-item-info">
                                {{ $item->quantity }} x {{ number_format($price, 0, ',', '.') }} đ
                            </span>
                        </div>
                    </li>
                @empty
                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-txt p-t-8">
                            <span class="header-cart-item-name m-b-18">
                                Giỏ hàng của bạn đang trống.
                            </span>
                        </div>
                    </li>
                @endforelse
            </ul>

            <div class="w-full">
                <div class="header-cart-total w-full p-tb-40">
                    Tổng tiền: {{ number_format($cartTotalGlobal ?? 0, 0, ',', '.') }} đ
                </div>

                @if(($cartItemsGlobal ?? collect())->count() > 0)
                    <div class="header-cart-buttons flex-w w-full">
                        <a href="{{ route('customer.showCart') }}"
                           class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                            Xem giỏ hàng
                        </a>

                        <a href="{{ route('customer.showCheckout') }}"
                           class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                            Thanh toán
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
