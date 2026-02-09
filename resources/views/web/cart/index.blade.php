@include('frontend/header')
  <div class="container" style="margin-top:200px;margin-bottom:100px;">
      <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col" style="background-color: #FBFBFB;padding: 18px 10px;">Remove item</th>
              <th scope="col" style="background-color: #FBFBFB;padding: 18px 10px;">Product</th>
              <th scope="col" style="background-color: #FBFBFB;padding: 18px 10px;">Price</th>
              <th scope="col" style="background-color: #FBFBFB;padding: 18px 10px;">Quantity</th>
              <th scope="col" style="background-color: #FBFBFB;padding: 18px 10px;">Subtotal</th>
            </tr>
          </thead>
          <tbody>
              @php $grandTotal = 0; @endphp
              @foreach($cart as $id => $item)
              
              @php 
                    $subtotal = $item['price'] * $item['quantity'];
                    $grandTotal += $subtotal;
              @endphp
            <tr>
              <td style="padding: 30px 10px;">
                  <img src="{{url('images/'.$item['image'])}}" alt="No Preview Available" width="100"/>
                  <form method="POST" action="{{ url('/cart/remove/'.$id).'/' }}" style="text-align: center;display: inline-flex;">
                      @csrf
                      <button type="submit" class="btn" style="background-color:#fff;color:#C4C8CE;border:1px solid #C4C8CE;font-size: 20px;border-radius:50%;padding: 0px 12px 4px 12px;">x</button>
                  </form>
                  
              </td>
              <td style="padding: 30px 10px;color: #86c242;font-weight: 600;font-size: 19px;">{{ $item['name'] }}</td>
              <td style="padding: 30px 10px;">$ {{ $item['price'] }}</td>
              <td style="padding: 30px 10px;">
                  <form method="POST" action="{{ url('/cart/update/'.$id).'/' }}">
                    @csrf
                  <input name="quantity" type="number" value="{{ $item['quantity'] }}" style="width: 60px;border:1px solid #C4C8CE;padding: 5px;">
                  <button type="submit" class="btn" style="background-color: #86c242;color: #fff;border-radius: 3px;margin-left: 15px;">Update</button>
                  </form>
              </td>
              <td style="padding: 30px 10px;">${{ number_format($subtotal, 2) }}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
                <td colspan="4" class="text-end fw-bold" style="font-size: 20px;padding: 20px 20px;">Total</td>
                <td class="fw-bold" style="font-size: 20px;padding: 20px 20px;">${{ number_format($grandTotal, 2) }}</td>
            </tr>
        </tfoot>
      </table>
      <div class="text-end pt-4">
          <a href="{{ url('/checkout').'/' }}" style="padding: 8px 40px 12px 40px;color:#fff;background-color: #86c242;text-decoration: none;font-size:20px;">Buy Now</a>
      </div>
      
  </div>
@include('frontend/footer')