@extends('customer.layouts.main')

@section('content')
    <section class="bg-img1 txt-center p-lr-15 p-tb-92"
             style="background-image: url('/customer/images/bg-01.jpg');">
        <h2 class="ltext-105 cl0">Đăng ký</h2>
    </section>

    <section class="bg0 p-t-104 p-b-116" style="min-height: calc(100vh - 260px);">
        <div class="container h-full">
            <div class="flex-w flex-c-m h-full">
                <div class="size-210 bor10 p-lr-40 p-t-45 p-b-40 p-lr-15-lg w-full-md"
                     style="max-width: 680px; background:#fff;">
                    <form method="POST" action="">
                        @csrf

                        <h4 class="mtext-105 cl2 txt-center p-b-25">
                            Tạo tài khoản
                        </h4>

                        <div class="m-b-18">
                            <div class="bor8 how-pos4-parent">
                                <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-20"
                                       type="text" name="full_name"
                                       placeholder="Họ và tên" required>
                                <i class="zmdi zmdi-account how-pos4"></i>
                            </div>
                        </div>

                        <div class="m-b-18">
                            <div class="bor8 how-pos4-parent">
                                <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-20"
                                       type="tel" name="phone"
                                       placeholder="Số điện thoại" required>
                                <i class="zmdi zmdi-phone how-pos4"></i>
                            </div>
                        </div>

                        <div class="m-b-18">
                            <div class="bor8 how-pos4-parent">
                                <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-20"
                                       type="email" name="email"
                                       placeholder="Email" required>
                                <i class="zmdi zmdi-email how-pos4"></i>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 m-b-18">
                                <div class="bor8">
                                    <select name="gender"
                                            class="stext-111 cl2 size-116 p-l-20 p-r-20 w-full"
                                            required
                                            style="height:50px;border:none;background:transparent;">
                                        <option value="" disabled selected>Giới tính</option>
                                        <option value="Nam">Nam</option>
                                        <option value="Nữ">Nữ</option>
                                        <option value="Khác">Khác</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 m-b-18">
                                <div class="bor8">
                                    <input type="date" name="birthday"
                                           class="stext-111 cl2 size-116 p-l-20 p-r-20 w-full"
                                           required
                                           style="height:50px;border:none;background:transparent;">
                                </div>
                            </div>
                        </div>

                        <div class="m-b-18">
                            <div class="bor8">
                                <textarea name="address" rows="3"
                                          class="stext-111 cl2 plh3 p-l-20 p-r-20 p-t-12 p-b-12 w-full"
                                          placeholder="Địa chỉ"
                                          required
                                          style="border:none;background:transparent;resize:none;"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 m-b-18">
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

                            <div class="col-md-6 m-b-18">
                                <div class="bor8 how-pos4-parent">
                                    <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-52 password-field"
                                           type="password"
                                           name="password_confirmation"
                                           placeholder="Nhập lại mật khẩu"
                                           required>
                                    <i class="zmdi zmdi-lock-outline how-pos4"></i>
                                    <i class="zmdi zmdi-eye toggle-password"></i>
                                </div>
                            </div>
                        </div>

                        <button class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer w-full">
                            Đăng ký
                        </button>

                        <div class="txt-center p-t-18">
                            <span class="stext-111 cl2">Đã có tài khoản?</span>
                            <a href="{{ route('auth.showLogin') }}" class="stext-111 cl5">
                                Đăng nhập
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
