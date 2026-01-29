@extends('admin.layouts.main')

@section('content')
    @php
        $title = 'Chi tiết sản phẩm';

        $categoryName = optional($product->category ?? null)->name ?? '—';
        $code = $product->code ?? '—';
        $name = $product->name ?? '—';
        $slug = $product->slug ?? '—';
        $description = $product->description ?? '—';

        $price = isset($product->price) ? number_format($product->price, 0, ',', '.') . 'đ' : '—';
        $discountPrice = isset($product->discount_price) ? number_format($product->discount_price, 0, ',', '.') . 'đ' : '—';
        $stock = isset($product->stock_quantity) ? (int)$product->stock_quantity : 0;

        $color = $product->color ?: '—';
        $material = $product->material ?: '—';
        $style = $product->style ?: '—';

        $isActive = (int)($product->is_active ?? 1) === 1;

        $image = $product->image ?? '';
        $img1 = $product->image_detail_1 ?? '';
        $img2 = $product->image_detail_2 ?? '';
        $img3 = $product->image_detail_3 ?? '';
    @endphp

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">{{ $title }}</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Quản trị</a></li>
                <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
                <li class="breadcrumb-item">Chi tiết</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                    <a href="#" class="btn btn-light">
                        <i class="feather-arrow-left me-2"></i>
                        <span>Quay lại</span>
                    </a>
                    <a href="#" class="btn btn-primary">
                        <i class="feather-edit-3 me-2"></i>
                        <span>Chỉnh sửa</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-top-0">
                    <div class="card-body">
                        <div class="row">
                            {{-- LEFT: Thông tin cơ bản --}}
                            <div class="col-lg-8">
                                <div class="d-flex align-items-start justify-content-between mb-3">
                                    <div>
                                        <h6 class="fw-bold mb-1">Thông tin cơ bản</h6>
                                        <div class="text-muted" style="font-size: 13px;">
                                            ID: <span class="fw-semibold">#{{ $product->id }}</span>
                                            @if($product->created_at)
                                                <span class="mx-2">•</span>
                                                Ngày tạo: <span class="fw-semibold">{{ $product->created_at->format('d/m/Y H:i') }}</span>
                                            @endif
                                            @if($product->updated_at)
                                                <span class="mx-2">•</span>
                                                Cập nhật: <span class="fw-semibold">{{ $product->updated_at->format('d/m/Y H:i') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <span class="badge {{ $isActive ? 'bg-soft-success text-success' : 'bg-soft-secondary text-secondary' }}"
                                          style="font-weight:700;">
                                        {{ $isActive ? 'Đang bán' : 'Tạm ẩn' }}
                                    </span>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <div class="label">Danh mục</div>
                                            <div class="value">
                                                <span class="badge bg-soft-primary text-primary" style="font-weight:700;">
                                                    {{ $categoryName }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <div class="label">Mã sản phẩm</div>
                                            <div class="value">{{ $code }}</div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="info-box">
                                            <div class="label">Tên sản phẩm</div>
                                            <div class="value">{{ $name }}</div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="info-box">
                                            <div class="label">Slug</div>
                                            <div class="value">
                                                <span class="text-muted">{{ $slug }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <div class="label">Giá</div>
                                            <div class="value">{{ $price }}</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <div class="label">Giá khuyến mãi</div>
                                            <div class="value">
                                                @if($discountPrice !== '—')
                                                    <span class="fw-semibold text-success">{{ $discountPrice }}</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <div class="label">Tồn kho</div>
                                            <div class="value">
                                                <span class="badge {{ $stock > 0 ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }}"
                                                      style="font-weight:700;">
                                                    {{ $stock }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <div class="label">Thuộc tính</div>
                                            <div class="value d-flex flex-wrap gap-2">
                                                <span class="badge bg-soft-secondary text-secondary">{{ $color }}</span>
                                                <span class="badge bg-soft-secondary text-secondary">{{ $material }}</span>
                                                <span class="badge bg-soft-secondary text-secondary">{{ $style }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="info-box">
                                            <div class="label">Mô tả</div>
                                            <div class="value" style="white-space: pre-line;">
                                                {{ $description }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- RIGHT: Hình ảnh --}}
                            <div class="col-lg-4">
                                <h6 class="fw-bold mb-3">Hình ảnh</h6>

                                <div class="mb-4">
                                    <div class="img-box" style="height: 220px;">
                                        @if($image)
                                            <img src="{{ $image }}" alt="Ảnh chính">
                                        @else
                                            <div class="img-empty">
                                                <i class="feather-image"></i>
                                                <span>Chưa có ảnh chính</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-muted mt-2" style="font-size: 13px;">
                                        Ảnh chính
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="img-box" style="height: 150px;">
                                            @if($img1)
                                                <img src="{{ $img1 }}" alt="Ảnh chi tiết 1">
                                            @else
                                                <div class="img-empty">
                                                    <i class="feather-image"></i>
                                                    <span>Chưa có ảnh chi tiết 1</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-muted mt-2" style="font-size: 13px;">Ảnh chi tiết 1</div>
                                    </div>

                                    <div class="col-12">
                                        <div class="img-box" style="height: 150px;">
                                            @if($img2)
                                                <img src="{{ $img2 }}" alt="Ảnh chi tiết 2">
                                            @else
                                                <div class="img-empty">
                                                    <i class="feather-image"></i>
                                                    <span>Chưa có ảnh chi tiết 2</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-muted mt-2" style="font-size: 13px;">Ảnh chi tiết 2</div>
                                    </div>

                                    <div class="col-12">
                                        <div class="img-box" style="height: 150px;">
                                            @if($img3)
                                                <img src="{{ $img3 }}" alt="Ảnh chi tiết 3">
                                            @else
                                                <div class="img-empty">
                                                    <i class="feather-image"></i>
                                                    <span>Chưa có ảnh chi tiết 3</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-muted mt-2" style="font-size: 13px;">Ảnh chi tiết 3</div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="#" class="btn btn-light">
                                <i class="feather-arrow-left me-2"></i>
                                Quay lại
                            </a>
                            <a href="#" class="btn btn-primary">
                                <i class="feather-edit-3 me-2"></i>
                                Chỉnh sửa
                            </a>
                        </div>

                        <style>
                            .info-box{
                                border: 1px solid #e9ecef;
                                border-radius: 10px;
                                padding: 12px 14px;
                                background: #fff;
                            }
                            .info-box .label{
                                font-size: 12.5px;
                                color: #6c757d;
                                margin-bottom: 6px;
                                font-weight: 600;
                                text-transform: none;
                            }
                            .info-box .value{
                                font-size: 14.5px;
                                color: #212529;
                                font-weight: 600;
                                line-height: 1.4;
                            }
                            .img-box{
                                width: 100%;
                                border: 1px solid #e9ecef;
                                border-radius: 12px;
                                overflow: hidden;
                                background: #f8f9fa;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                            }
                            .img-box img{
                                width: 100%;
                                height: 100%;
                                object-fit: contain;
                                object-position: center;
                                display:block;
                                background: #fff;
                            }
                            .img-empty{
                                display:flex;
                                flex-direction:column;
                                align-items:center;
                                justify-content:center;
                                gap: 6px;
                                color:#98a2b3;
                                font-size: 13px;
                                padding: 12px;
                                text-align:center;
                            }
                            .img-empty i{
                                font-size: 20px;
                            }
                        </style>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
