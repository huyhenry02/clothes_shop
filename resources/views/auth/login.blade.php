@extends('customer.layouts.main')

@section('content')
    <section class="bg-img1 txt-center p-lr-15 p-tb-92"
             style="background-image: url('/customer/images/bg-01.jpg');">
        <h2 class="ltext-105 cl0">Đăng nhập</h2>
    </section>

    <section class="bg0 p-t-104 p-b-116" style="min-height: calc(100vh - 260px);">
        <div class="container h-full">
            <div class="flex-w flex-c-m h-full">
                <div class="size-210 bor10 p-lr-40 p-t-45 p-b-40 p-lr-15-lg w-full-md"
                     style="max-width: 560px; background:#fff;">
                    <form method="POST" action="">
                        @csrf

                        <h4 class="mtext-105 cl2 txt-center p-b-25">
                            Đăng nhập
                        </h4>

                        <div class="m-b-18">
                            <div class="bor8 how-pos4-parent">
                                <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-20"
                                       type="tel"
                                       name="phone"
                                       placeholder="Số điện thoại"
                                       required>
                                <i class="zmdi zmdi-phone how-pos4"></i>
                            </div>
                        </div>

                        <div class="m-b-22">
                            <div class="bor8 how-pos4-parent">
                                <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-52 password-field"
                                       type="password"
                                       name="password"
                                       placeholder="Mật khẩu"
                                       required>
                                <i class="zmdi zmdi-lock how-pos4"></i>
                                <i class="zmdi zmdi-eye toggle-password"></i>
                            </div>
                        </div>

                        <button class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer w-full">
                            Đăng nhập
                        </button>

                        <div class="txt-center p-t-18">
                            <span class="stext-111 cl2">Chưa có tài khoản?</span>
                            <a href="{{ route('auth.showRegister') }}" class="stext-111 cl5">
                                Đăng ký ngay
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <style>
        .toggle-password {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #999;
            cursor: pointer;
        }
    </style>

    <script>
        document.querySelectorAll('.toggle-password').forEach(function (icon) {
            icon.addEventListener('click', function () {
                const input = this.parentElement.querySelector('.password-field')
                if (input.type === 'password') {
                    input.type = 'text'
                    this.classList.remove('zmdi-eye')
                    this.classList.add('zmdi-eye-off')
                } else {
                    input.type = 'password'
                    this.classList.remove('zmdi-eye-off')
                    this.classList.add('zmdi-eye')
                }
            })
        })
    </script>
@endsection
