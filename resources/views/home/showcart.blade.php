<!DOCTYPE html>
<html>
   <head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @include('home.css')

      <style type="text/css">

            .center
            {
                margin: auto;
                width: 50%;
                text-align: center;
            }
            .th_deg
            {
                font-size: 24px;
                padding: 5px;
                background: skyblue;
            }
            .tr_deg
            {
                margin: auto;
                height: 50%;
            }
            .total_deg
            {
                font-size: 20px;
                padding: 40px;
            }
            .title_text
            {
                text-align: center;
                margin-top: 40px;
                font-size: 30px;

            }
      </style>
    </head>
   <body>

    @include("sweetalert::alert")

      <div class="hero_area">
         <!-- header section strats -->
         @include('home.header')
         @include('admin.message')
         <!-- end header section -->
            <div>
                <h1 class="title_text">Show Cart</h1>
            </div>
        <div class="center">

            <table class="table table-bordered">
                <tr>
                    <th class="th_deg">ID</th>
                    <th class="th_deg">Product title</th>
                    <th class="th_deg">Product quantity</th>
                    <th class="th_deg">Price</th>
                    <th class="th_deg">Image</th>
                    <th class="th_deg">Action</th>
                </tr>

                <?php $totalprice=0; ?>

                @foreach ($cart as $cart)
                <tr class="tr_deg">
                    <th>{{$cart->id}}</th>
                    <th>{{$cart->product_title}}</th>
                    <th>{{$cart->quantity}}</th>
                    <th>{{$cart->price}}</th>
                    <th>
                        <img src="/product/{{$cart->image}}" style="height: 86px; width:96px; object-fit: cover;" alt="">
                    </th>
                    <th>
                        <a class="btn btn-danger" onclick="confirmation(event)"
                        href="{{url('/remove_cart',$cart->id)}}">Remove Product</a>
                    </th>
                </tr>

                <?php $totalprice=$totalprice + $cart->price ?>

                @endforeach
            </table>

            <div>
                <h1 class="total_deg">Total Price : {{$totalprice}}</h1>
            </div>

            <div>
                <h1 style="font-size: 25px; padding-bottom: 15px;">Proceed to Order</h1>
                <a href="{{url('cash_order')}}" class="btn btn-danger">Cash On Delivery</a>
                <a href="{{url('stripe',$totalprice)}}" class="btn btn-danger">Pay Using</a>
            </div>

        </div>

      </div>
      <!-- footer start -->
      @include('home.footer')
      <!-- footer end -->
      <div  class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>

            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

         </p>
      </div>

      <script>
        function confirmation(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href');
            console.log(urlToRedirect);
            swal({
                title: "Are you sure to cancel this product?",
                text: "You will not be able to revert this!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willCancel) =>{
                if (willCancel) {

                window.location.href = urlToRedirect;

                }
            });
        }
      </script>
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
