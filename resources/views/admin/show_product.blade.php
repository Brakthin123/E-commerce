<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('admin.css')

    <style type="text/css">
        .center
        {
            margin: auto;
            width: 50%;
            text-align: center;
            color: black;
        }
        .title_text
        {
            text-align: center;
            font-size: 40px;
            margin-bottom: 40px;
        }
        .photo
        {
            width: 300px;
            height: 300px;
        }
        .table_desgin
        {
            background-color: cyan;
        }
        .col_font
        {
            font-size: 16px;
        }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        @include('admin.header')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

               @include('admin.message')

               <h1 class="title_text">Show Products</h1>

               <table class="table table-bordered table-light center">
                    <tr class="table_desgin">
                        <th class="col_font">ID</th>
                        <th class="col_font">Product title</th>
                        <th class="col_font">Description</th>
                        <th class="col_font">Quantity</th>
                        <th class="col_font">Catagory</th>
                        <th class="col_font">Price</th>
                        <th class="col_font">Discount Price</th>
                        <th class="col_font">Product Image</th>
                        <th class="col_font">Action</th>

                    </tr>

                    @foreach ($product as $product)
                    <tr>
                        <th>{{$product->id}}</th>
                        <th>{{$product->title}}</th>
                        <th>{{$product->description}}</th>
                        <th>{{$product->quantity}}</th>
                        <th>{{$product->catagory}}</th>
                        <th>{{$product->price}}</th>
                        <th>{{$product->discount_price}}</th>
                        <th>
                            <img src="/product/{{$product->image}}" style="height: 86px; width: 86px; object-fit: cover;" alt="">
                        </th>
                        <th>
                            <a class="btn btn-primary" href="{{url('/edit_product',$product->id)}}">Edit</a>
                            <a class="btn btn-danger" onclick="return confirm('Are you sure to delete this!')"
                            href="{{url('/delete_product',$product->id)}}">Delete</a>
                        </th>
                    </tr>
                    @endforeach
               </table>

            </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>
