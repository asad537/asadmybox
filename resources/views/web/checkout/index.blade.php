@include('frontend.header')
<div class="container checkout-container" style="margin-top:200px;">
    <h2 class="mb-4">Checkout</h2>
    @if(session('cart') && count(session('cart')) > 0)

    <form method="POST" action="{{url('checkout').'/'}}" class="quote_form">
        @csrf
        <div class="row g-4">
            <!-- Billing details -->
            <div class="col-md-7">
                <h5 style="border-bottom: 1px solid #dee2e6; padding-bottom: 10px; margin-bottom: 20px;">Billing details</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName" class="form-label">First name *</label>
                        <input type="text" class="form-control" id="firstName" placeholder="First name" required name="f_name" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName" class="form-label">Last name *</label>
                        <input type="text" class="form-control" id="lastName" placeholder="Last name" required name="l_name" />
                    </div>
                </div>

                <div class="mb-3">
                    <label for="company" class="form-label">Company name*</label>
                    <input type="text" class="form-control" placeholder="Company name" id="company" required name="c_name" />
                </div>

                <div class="mb-3">
                    <label for="country" class="form-label">Country / Region *</label>
                    <select class="form-select" id="country" required name="country">
                        <option selected>United States (US)</option>
                        <option>United Kingdom (UK)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="address1" class="form-label">Street address *</label>
                    <input type="text" class="form-control mb-2" id="address1" placeholder="House number and street name" required name="address1" />
                    <input type="text" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)" name="address2" />
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="city" class="form-label">Town / City *</label>
                        <input type="text" class="form-control" id="city" placeholder="Town / City" required name="city" />
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="state" class="form-label">State *</label>
                        <input type="text" class="form-control" id="state" placeholder="State" required name="state" />
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="zip" class="form-label">ZIP Code *</label>
                        <input type="text" class="form-control" id="zip" placeholder="ZIP Code" required name="zip" />
                    </div>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone *</label>
                    <input type="text" class="form-control" id="phone" placeholder="Phone" required name="phone" />
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address *</label>
                    <input type="email" class="form-control" id="email" placeholder="Email address" required name="email" />
                </div>

                <h5 style="border-bottom: 1px solid #dee2e6; padding-bottom: 10px; margin-bottom: 20px;">Additional information</h5>
                <div class="mb-3">
                    <label for="message" class="form-label">Order notes*</label>
                    <textarea class="form-control" id="message" placeholder="Message" name="message" required></textarea>
                </div>
                <button class="btn btn-primary" style="color:#fff;background-color: #86c442c7; border-color: #86c442c7; border-radius: 0px; font-size: 20px;" type="submit" name="submit">Place order</button>
            </div>

            <!-- Order summary -->
            <div class="col-md-5">
                <div class="order-summary">
                    <h5 class="mb-3">Your order</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($cart as $item)
                                @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                                <tr>
                                    <td><img src="{{url('images/'.$item['image'])}}" width="50" style="margin-right: 10px;" />{{ $item['name'] }}</td>
                                    <td class="text-end">${{ number_format($subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td><strong>Total</strong></td>
                                <td class="text-end"><strong>${{ number_format($total, 2) }}</strong></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- CARD SECTION -->
                   

                    <!-- UNAVAILABLE MESSAGE -->
                    <div id="card-error-msg" class="payment-box" style="display: none; background-color: #ffdede; color: #a94442; margin-top: 15px;">
                        ⚠️ Card payment is temporarily unavailable. Please use Cash on Delivery.
                    </div>

                    <!-- COD -->
                    <div id="cod-section" class="mb-3" style="padding: 15px 0px;">
                        <input type="hidden" name="payment_method" value="cod" />
                        Cash on delivery
                        <div class="payment-box mt-2">
                            Pay with cash upon delivery.
                        </div>
                    </div>

                    <p class="text-muted small" style="font-size: 16px;">
                        Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy.
                    </p>
                </div>
            </div>
        </div>
    </form>
    @else
    <p>Your cart is empty. <a href="{{ url('/') }}">Go back to shop</a></p>
    @endif
</div>

@include('frontend.footer')
<style>
    .payment-box {
        background-color: #eee;
        padding: 20px;
        max-width: 400px;
        margin: auto;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
    .payment-box h3 { font-size: 16px; margin-bottom: 20px; color: #2c2c2c; }
    .required { color: red; }
    .quote_form i {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 16px;
        color: #5c6f85;
    }
    .flex-row { display: flex; gap: 10px; }
    .flex-row input { flex: 1; }
    .quote_form input, .quote_form select, .quote_form textarea {
        background-color: #f6f8fa;
        border-top: none; border-left: none; border-right: none;
        margin-bottom: 15px;
        border-radius: 0px;
        padding: 10px 10px;
    }
    .checkout-container { max-width: 1200px; margin: 40px auto; }
    .order-summary {
        background-color: #fff;
        border: 1px solid #dee2e6;
        padding: 20px;
        border-radius: 5px;
        margin-left: 20px;
    }
    .payment-box { background-color: #f0f0f0; padding: 10px; font-size: 0.9rem; border-radius: 5px; }
    .btn-primary { width: 100%; }
    .error { color: red; }
</style>