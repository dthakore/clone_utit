<div class="cart-data">
    @if(!empty($products))
        <div class="row" id="product-list">
            <div class="col-lg-12 col-xl-9 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Shopping Cart-->
                        <input type="hidden" value="{{$cashback_id}}" name="cb_type" />
                        <div class="product-details table-responsive text-nowrap">
                            <table class="table table-bordered table-hover mb-0 text-nowrap">
                                <thead>
                                <tr>
                                    <th class="text-start">PRODUCT</th>
                                    <th class="w-150">QUANTITY</th>
                                    <th>PRICE</th>
                                    <th>SUBTOTAL</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr id="{{$product['cart_id']}}">
                                        <td class="product-name">
                                            <a href="@if($product['sku'] !=  'NTTP1') {{Url('product/'.$product['id'])}} @endif">{{$product['name']}}</a>
                                            @if($product['bot'] > 0)
                                                <select required class="form-control required" style="width: 100%;" id="bot-price" tabindex="-1" aria-hidden="true">
                                                    @if(!empty($final_price))
                                                        @foreach($final_price as $key=>$value)
                                                            <option value="{{$key . "#" .$value}}" {{ $product['bot'] == $key ? 'selected="selected"' : '' }}>up to {{$key}} bots / €{{ number_format($value, 2, ',')}} for  platform</option>
                                                            {{--                                                                        <option value="{{$key . "#" .$value}}" {{ $product['bot'] == $key ? 'selected="selected"' : '' }}>up to {{$key}} bots / €{{ $value}} for  platform</option>--}}
                                                        @endforeach
                                                    @endif
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="input-group mt-0 handle-counter ms-2" style="flex-wrap: unset">
                                                <input type="button" value="-" class="button-minus" data-field="quantity" @if($product['sku'] !=  'NTBOT') disabled @endif>
                                                <input type="number" step="" min="1" value="{{$product['qty']}}" name="quantity" id="quantity_{{$product['id']}}" @if($product['sku'] !=  'NTBOT')  disabled @endif class="quantity-field productTextInput">
                                                <input type="button" value="+" class="button-plus" data-field="quantity" @if($product['sku'] !=  'NTBOT') disabled @endif>
                                            </div>
                                        </td>
                                        {{--                                                    <td class="text-center text-lg text-medium font-weight-bold  tx-15">€ {{ $product['price'] }}</td>--}}
                                        <td class="text-center text-lg text-medium font-weight-bold  tx-15">€ {{ number_format($product['price'] , 2, ',')}}</td>
                                        {{--                                                    <td class="text-center text-md-right">€ {{ $product['subtotal'] }}</td>--}}
                                        <td class="text-center text-md-right">€ {{ number_format($product['subtotal'] , 2, ',') }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-danger-light delete-item" href="javascript:void(0);" data-id="{{$product['cart_id']}}" data-product="{{$product['sku']}}" data-product-id="{{$product['id']}}"><i class="fe fe-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="shopping-cart-footer bd-0">
                            {{-- <div class="column">
                                <a href="{{Url('product/'.$cashback_product)}}" @if($cashback_id != 0)class="hide"@endif id="cashback">I want to buy cashback licenses</a>
                            </div> --}}
                            <div class="column">
                                <a class="btn btn-secondary" href="{{ route('frontend.shop') }}"><i class="fe fe-corner-up-left  mx-2"></i>Back to Shopping</a>
                                <button class="btn btn-primary update_cart" name="update_cart" value="Update Cart" aria-disabled="false"><i class="fe fe-refresh-cw mx-2"></i>Update Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card addCashbackBanner">
                    <div class="card-header">
                        <h5>ADD PRODUCTS TO YOUR ORDER</h5>
                        <hr>
                        <img src="{{ asset('assets/img/image.png') }}" alt="user-avatar" class="img-circle img-fluid">
                        <a href="{{Url('product/'.$cashback_product)}}" id="cashback" class="btn btn-secondary orderLicenceBtn"  aria-disabled="false" style=""><h6>CONTINUE ORDERING LICENSES</h6></a><br/>
                        <a href="#" class="btn btn-primary tellMeMore" aria-disabled="false" ><h6> TELL ME MORE</h6></a>&nbsp;
                    </div>
                </div>

            </div>
            <div class="col-lg-12 col-xl-3 col-md-12">
                <div class="card custom-card cart-details">
                    <div class="card-body">
                        <h5 class="mb-3 font-weight-bold tx-14">CART TOTALS</h5>
                        <dl class="dlist-align">
                            <dt class="">Subtotal (Excl VAT)</dt>
                            {{--                                        <dd class="text-end ms-auto">€ <span id="sub-total">{{ $order_total['subtotal'] }}</span></dd>--}}
                            <dd class="text-end ms-auto">€ <span id="sub-total">{{ number_format($order_total['subtotal'] , 2, ',') }}</span></dd>
                        </dl>
                        <dl class="dlist-align">
                            <dt class="">Vat@21%</dt>
                            {{--                                        <dd class="text-end ms-auto">€ <span id="vat">{{ $order_total['vat']}}</span></dd>--}}
                            <dd class="text-end ms-auto">€ <span id="vat">{{ number_format($order_total['vat'] , 2, ',') }}</span></dd>
                        </dl>
                        <dl class="dlist-align" style="font-size: 17px">
                            <dt>Total Amount</dt>
                            {{--                                        <dd class="text-end  ms-auto tx-20"><strong>€ <span id="grand-total">{{ $order_total['grand_total']  }}</span></strong></dd>--}}
                            <dd class="text-end  ms-auto tx-20"><strong>€ <span id="grand-total">{{ number_format($order_total['grand_total'] , 2, ',') }}</span></strong></dd>
                        </dl>
                    </div>
                    <div class="card-footer">
                        <div class="column"><a href="{{Url('checkout')}}" class="btn btn-outline-primary">Proceed to checkout</a></div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="card card-solid">
                    <div class="card-body" style="text-align: center">
                        <h5>Oops! Your Cart is empty.</h5>
                        <a href="{{ Url("shop")}}" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
