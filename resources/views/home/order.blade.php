<!DOCTYPE html>
<html>
   <head>
    
    @include('home.css')

      <style type="text/css">

         .center
         {
            margin: auto;
            width: 50%;
            padding: 30px;
            text-align: center;
         }

         table,th,td
         {
            border: 1px solid black;
         }

         .th_deg
         {
            padding: 10px;
         }

      </style>

   </head>
   <body>
         <!-- header section strats -->

         @include('home.header')
         <!-- end header section -->

        <div class="center">
            <table>
                <tr>
                    <th class="th_deg">ID</th>
                    <th class="th_deg">Product Title</th>
                    <th class="th_deg">Quantity</th>
                    <th class="th_deg">Price</th>
                    <th class="th_deg">Payment Status</th>
                    <th class="th_deg">Delivery Status</th>
                    <th class="th_deg">Image</th>
                    <th class="th_deg">Cancel Order</th>
                </tr>

                @foreach($order as $order)
                <tr>
                <th class="th_deg">{{$order->id}}</th>
                    <th class="th_deg">{{$order->product_title}}</th>
                    <th class="th_deg">{{$order->quantity}}</th>
                    <th class="th_deg">{{$order->price}}</th>
                    <th class="th_deg">{{$order->payment_status}}</th>
                    <th class="th_deg">{{$order->deleivery_status}}</th>
                    <th>
                     <img height="100" width="180" src="product/{{$order->image}}">
                    </th>
                     <th>
                        @if($order->deleivery_status=='processing')

                        <a onclick="return confirm('Are you Sure to Cancel this Order!!!')"
                        class="btn btn-danger" href="{{url('cancel_order',$order->id)}}">Cancel Order</a>
                        @else
                        <p style="color: blue;">Not Allowed</p>

                        @endif
                     </th>
                </tr>

                @endforeach

            </table>
        </div>

      <!-- jQery -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>
   </body>
</html>
