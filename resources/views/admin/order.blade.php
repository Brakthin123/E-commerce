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
                <h1 class="title_text">All Order</h1>

                <div style="padding-left: 400px; padding-bottom: 30px;">
                    <form action="{{url('search')}}" method="get">

                    @csrf
                        <input style="color: black" type="text" name="search" placeholder="Search For Something">

                        <input type="submit" value="Search" class="btn btn-outline-primary">
                    </form>
                </div>


               @include('admin.message')



               <table class="table table-bordered table-light center">
                    <tr class="table_desgin">
                        <th class="col_font">ID</th>
                        <th class="col_font">Name</th>
                        <th class="col_font">Email</th>
                        <th class="col_font">Address</th>
                        <th class="col_font">Phone</th>
                        <th class="col_font">Product Title</th>
                        <th class="col_font">Quantity</th>
                        <th class="col_font">Price</th>
                        <th class="col_font">Payment Status</th>
                        <th class="col_font">Delivery Status</th>
                        <th class="col_font">Image</th>
                        <th class="col_font">Delivered</th>
                        <th class="col_font">Print PDF</th>
                        <th class="col_font">Send Email</th>

                    </tr>

                    @forelse ($order as $order)
                    <tr>
                        <th>{{$order->id}}</th>
                        <th>{{$order->name}}</th>
                        <th>{{$order->email}}</th>
                        <th>{{$order->address}}</th>
                        <th>{{$order->phone}}</th>
                        <th>{{$order->product_title}}</th>
                        <th>{{$order->quantity}}</th>
                        <th>{{$order->price}}</th>
                        <th>{{$order->payment_status}}</th>
                        <th>{{$order->deleivery_status}}</th>
                        <th>
                            <img src="/product/{{$order->image}}" style="height: 86px; width: 86px; object-fit: cover;" alt="">
                        </th>
                        <th>
                            @if ($order->deleivery_status =='processing')


                            <a class="btn btn-primary" onclick="return confirm('Are you sure this product is delivered !!!')" href="{{url('/delivered',$order->id)}}">Delivered</a>

                            @else
                            <p style="color: green">Delivered</p>

                            @endif

                        </th>
                        <th>
                            <a href="{{url('print_pdf',$order->id)}}" class="btn btn-secondary">Prind PDF</a>
                        </th>
                        <th>
                            <a href="{{url('send_email',$order->id)}}" class="btn btn-info">Send Email</a>
                        </th>
                    </tr>

                    @empty
                        <tr>
                            <td colspan="16">
                                No Data Found
                            </td>
                        </tr>

                    @endforelse
                    
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
