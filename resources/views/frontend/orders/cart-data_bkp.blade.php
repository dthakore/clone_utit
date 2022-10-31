<div class="cart-data">
    @if(!empty($products))
    <div class="row" id="product-list">
        <div class="col-md-8">
            <div class="card card-solid">
                <div class="card-body">
                    <div class="responsive-table">
                        <table class="table shop_table">
                            <thead>
                            <tr>
                                <th width="100"></th>
                                <th width="30%">PRODUCT</th>
                                <th>PRICE</th>
                                <th>QUANTITY</th>
                                <th class=" text-center text-md-right">SUBTOTAL</th>
                            </tr>
                            @foreach($products as $product)
                                <tr id="{{$product['cart_id']}}">
                                    <td class="product-thumbnail">
                                        <div class="pro-cart-thumb">
                                            <a href="javascript:void(0)" class="icon-close delete-item" data-id="{{$product['cart_id']}}" data-product="{{$product['sku']}}" data-product-id="{{$product['id']}}"><i class="far fa-times-circle"></i></a>
                                        </div>
                                    </td>
                                    <td class="product-name">
                                        <a href="#">{{$product['name']}}</a>
                                        @if($product['bot'] > 0)
                                            <select required class="form-control required" style="width: 100%;" id="bot-price" tabindex="-1" aria-hidden="true">
                                                <option value="" selected="selected">Please Select</option>
                                                <option value="3#43.496" {{ $product['bot'] == 3 ? 'selected="selected"' : '' }}>up to 3 bots / €43,49 for platform</option>
                                                <option value="8#75.49" {{ $product['bot'] == 8 ? 'selected="selected"' : '' }}>up to 8 bots / €75,49 for  platform</option>
                                                <option value="15#130" {{ $product['bot'] == 15 ? 'selected="selected"' : '' }}>up to 15 bots / €130 for platform</option>
                                                <option value="35#259" {{ $product['bot'] == 35 ? 'selected="selected"' : '' }}>up to 35 bots / €259 for platform</option>
                                            </select>
                                        @endif
                                    </td>
                                    <td class="product-price">
                                            <span class="woocommerce-Price-amount amount">
                                                <bdi><span class="woocommerce-Price-currencySymbol">€ </span>{{ $product['price'] }}</bdi></span>
                                    </td>
                                    <td class="product-quantity">
                                        <div class="input-group mt-0">
                                            <input type="button" value="-" class="button-minus" data-field="quantity" @if($product['sku'] !=  'NTBOT') disabled @endif>
                                            <input type="number" step="" min="1" value="{{$product['qty']}}" name="quantity" id="quantity_{{$product['id']}}" class="quantity-field productTextInput" @if($product['sku'] !=  'NTBOT') disabled @endif>
                                            <input type="button" value="+" class="button-plus" data-field="quantity" @if($product['sku'] !=  'NTBOT') disabled @endif>
                                        </div>
                                    </td>
                                    <td class="product-subtotal text-center text-md-right" data-title="Subtotal">
                                                    <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">€ </span>{{$product['subtotal']}}</bdi>
                                                    </span>
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <td colspan="6" class="actions px-md-2">
                                    <div class="cart_totals_toggle">
                                        <div id="panel-cart-discount" class="d-sm-flex justify-content-between">
                                            <div class="coupon">
                                                <a href="{{Url('product/'.$cashback_product)}}" @if($cashback_id != 0)class="hide"@endif id="cashback">I want to buy cashback licenses</a>
                                                {{--                                                    <input type="text" name="coupon_code" class="form-control" id="coupon_code" placeholder="Coupon code" value="">--}}
                                                {{--                                                    <button type="submit" class="btn btn-default" name="apply_coupon" value="Apply coupon">Apply coupon</button>--}}
                                            </div>
                                            <button class="btn btn-default btn-upcart update_cart" name="update_cart" value="Update Cart" aria-disabled="false">Update Cart</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-sub-title">CART TOTALS</h5>
                    <table class="responsive cart-total table" cellspacing="0">
                        <tbody>
                        <tr class="cart-subtotal">
                            <th>
                                Subtotal (Excl VAT)
                            </th>
                            <td class="text-right">
                                <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">€ </span><span id="sub-total">{{$order_total['subtotal']}}</span></bdi></span>
                            </td>
                        </tr>
                        <tr class="cart-subtotal">
                            <th>
                                Vat@21%
                            </th>
                            <td class="text-right">
                                <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">€ </span><span id="vat">{{$order_total['vat']}}</span></bdi></span>
                            </td>
                        </tr>

                        <tr class="order-total">
                            <th>
                                <h4 class="text-md mb-0">Total Amount</h4>
                            </th>
                            <td class="text-right"><strong><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">€ </span><span id="grand-total">{{$order_total['grand_total']}}</span></bdi></span></strong> </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a href="{{Url('checkout')}}" class="btn btn-primary btn-block checkout">Proceed to checkout</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
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
