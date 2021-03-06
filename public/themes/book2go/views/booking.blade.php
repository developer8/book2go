<section id="ks-booking">
                
    <div class="container">
    	@if(!Auth::guard('member')->check() && setting('allow_discount_membership'))
            <div class="login-tip">
                <div class="row">
                    <div class="col-9">
                        <i class="insider-banner-tag"></i>
                        <strong>{!! setting('member_discounts_name') !!}</strong>
                        <p>Giá sẽ giảm ngay khi đăng nhập!</p>
                    </div>
                    <div class="col-3">
                        Đăng nhập
                        <i class="fas fa-chevron-circle-right"></i>
                    </div>
                </div>
            </div>
            @php 
        	$member = null; @endphp
        @else
        	@php 
        	$member = Auth::guard('member')->user(); @endphp
        @endif
        @if (isset($errors) && count($errors))
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
            <div class="row">
                <div class="promo-img">
                    <img class="img-fluid" src="{{ theme_option('bookingpage_img') }}" alt="slide">
                </div>
            </div>
        
        <div class="row pageBooking">
            <div class="col-md-7">
                <div class="ks-booking-form">
                    <h5>Vui lòng điền thông tin của bạn</h5>
                    {!! Form::open(['route' => 'public.booking.post', 'id' => 'booking-available']) !!}
                        <div class="form-group">
                            <label for="txtname">Họ và tên</label>
                            <input type="text" class="form-control" id="txtname" name="fullname" value="{{old('fullname', $member?$member->name:null)}}" placeholder="Nhập họ và tên">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{old('email', $member?$member->email:null)}}" placeholder="Nhập email của bạn">
                        </div>
                                
                        <div class="form-group">
                            <label for="txtphone">Số điện thoại</label>
                            <input type="text" class="form-control" id="txtphone" name="phone" value="{{old('phone', $member?$member->phone:null)}}" placeholder="Nhập số điện thoại">
                        </div>
                        <div class="form-group">
                            <label for="txtaddress">Địa chỉ</label>
                            <input type="text" class="form-control" id="txtaddress" name="address" value="{{old('address', $member?$member->address:null)}}" placeholder="Nhập địa chỉ">
                        </div>
                        <input type="hidden" name="include_vat" value="">
                        <input type="hidden" name="booking_id" value="{{$booking->id}}">
                        <button type="submit" class="btn btn-primary">Xác nhận đặt phòng</button>
                    {!! Form::close() !!}
                </div>
                
            </div>
            <div class="col-md-5">
                <div class="ks-booking-info">
                    <h5>Thông tin về phòng đã chọn</h5>
                    <div class="row date-time">
                        <div class="col-5">
                            <span>Nhận phòng</span><br>
                            <span class="dd">{{date('d', strtotime($booking->checkin))}}</span>
                            <span>{{date('m Y', strtotime($booking->checkin))}}</span>
                        </div>
                        <div class="col-2">
                            <i class="icon-arrow fas fa-angle-right"></i>
                        </div>
                        <div class="col-5">
                            <span>Trả phòng</span><br>
                            <span class="dd">{{date('d', strtotime($booking->checkout))}}</span>
                            <span>{{date('m Y', strtotime($booking->checkout))}}</span>
                        </div>

                    </div>
                    <div class="row price-detail">
                        <div class="col-5">
                            <span>Loại phòng:</span><br>
                            <span>Giá gốc:</span><br>
                            <span>Khuyến mãi 
                                @if($booking->discount)
                                    @php $notes = null; @endphp
                                    @foreach(json_decode($booking->notes, true) as $value)
                                        @php
                                            $promotion_discount = number_format_price_nohtml($value['promotion_discount']);
                                         $notes = $notes . 'Khuyến mãi ' . $value['promotion_name'] . ': ' . $promotion_discount . '<br/>'; @endphp
                                    @endforeach
                                    <i class="fas fa-info-circle" data-html="true" data-toggle="tooltip" data-placement="bottom" title="{!! $notes !!}"></i>:
                                @endif
                            </span><br>
                            <span>
                                Phí dịch vụ : 10%
                            </span><br>
                            <span>
                                <input type="checkbox" name="include_vat" class="include_vat" value="{{$booking->tax}}"> VAT 10%
                            </span><br>
                            <span>Giá tiền:</span>
                        </div>
                        <div class="col-7">
                            <span>{{$requests['number_of_servicer']}} x <a target="_blank" href="{{route('public.single',  $servicer->slug)}}">{{$servicer->name}}</a></span><br>
                            <div @if($booking->discount) class="price-through" @endif.>
                                {!! number_format_price($booking->subtotal) !!}
                            </div>
                            <div class="price">
                                {!! number_format_price($booking->discount, true) !!}
                            </div>
                            <div class="price">
                                {!! number_format_price($booking->service_charge) !!}
                            </div>
                            <div class="price-vat">
                                {!! number_format_price(0, true) !!}
                            </div>
                            <div class="price-show" data-price="{{$booking->total}}">
                                {!! number_format_price($booking->total) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row price-final">
                        <div class="col-7">
                            <span class="giatien">Giá tiền: <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Tooltip on top"></i></span><br>
                            {{-- <span class="baogom">Giá đã bao gồm: Phí dịch vụ 5%, Thuế 10%</span> --}}
                        </div>
                        <div class="col-5">
                            <div class="price-total">
                                {!! number_format_price($booking->total) !!}
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>