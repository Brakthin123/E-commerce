<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      @include('home.css')
   </head>
   <body>
      <div class="hero_area">
         <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->


          <div class="col-sm-6 col-md-4 col-lg-4" style="margin: auto; width: 50%; padding: 30px;">
             <div class="box">
                <div class="img-box" style="padding: 20px">
                   <img src="/product/{{$product->image}}" alt="">
                </div>
                <div class="detail-box">
                   <h5>
                      {{$product->title}}
                   </h5>

                    @if($product->discount_price != null)
                   <h6 style="color: red;">
                        Discount price
                        <br>
                        $ {{$product->discount_price}}
                   </h6>

                   <h6 style="text-decoration: line-through; color: blue;">
                        Price
                        <br>
                        $ {{$product->price}}
                   </h6>
                   @else
                   <h6>
                        Price
                        <br>
                        $ {{$product->price}}
                   </h6>
                    @endif

                    <h6>
                        Product Catagory : {{$product->catagory}}
                    </h6>
                    <h6>
                        Product Description : {{$product->description}}
                    </h6>
                    <h6>
                        Product Quantity : {{$product->quantity}}
                    </h6>


                </div>
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
