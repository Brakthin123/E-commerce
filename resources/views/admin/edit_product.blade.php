<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <base href="/public"> // Required base href for rendering
    @include('admin.css')

    <style type="text/css">
        .div_center
        {
            text-align: center;
            padding-top: 40px
        }
        .font_size
        {
            font-size: 40px;
            margin-bottom: 40px;
        }
        .text_color
        {
            color: black
        }
        label
        {
            display: inline-block;
            width: 200px;
        }
        .div_design
        {
            padding-bottom: 15px;
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

                <div class="div_center">
                    <h1 class="font_size">Update Product</h1>

                    <form action="{{url('/update_product',$product->id)}}" method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="div_design">
                        <label>Product Title :</label>
                        <input class="text_color" type="text" value="{{$product->title}}" name="title"
                        placeholder="Write a title" required>
                    </div>
                    <div class="div_design">
                        <label>Product Description :</label>
                        <input class="text_color" type="text" value="{{$product->description}}" name="description"
                        placeholder="Write a Description" required>
                    </div>
                    <div class="div_design">
                        <label>Product Price :</label>
                        <input class="text_color" type="number" value="{{$product->price}}" name="price"
                        placeholder="Write a Price" required>
                    </div>
                    <div class="div_design">
                        <label>Discount Price :</label>
                        <input class="text_color" type="number" value="{{$product->discount_price}}" name="dis_price"
                        placeholder="Write a Discount">
                    </div>
                    <div class="div_design">
                        <label>Product Quantity :</label>
                        <input class="text_color" type="text" value="{{$product->quantity}}" min="0" name="quantity"
                        placeholder="Write a Quantity" required>
                    </div>
                    <div class="div_design">
                        <label>Product Catagory :</label>
                        <select class="text_color" name="catagory" id="" required>
                            <option value="{{$product->catagory}}">{{$product->catagory}}</option>

                            @foreach ($catagory as $catagory)
                            <option value="{{$catagory->catagory_name}}">{{$catagory->catagory_name}}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="div_design">
                        <label>Current Image Hear :</label>
                       <img style="margin: auto; height: 200px; whith: 200px; object-fit: cover;" src="/product/{{$product->image}}" alt="">
                    </div>

                    <div class="div_design">
                        <label>Product Image Hear :</label>
                        <input type="file" name="image" id="">
                    </div>
                    <div>
                        <input class="btn btn-primary" type="submit" value="Update Product">
                    </div>

                </form>
                </div>
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
