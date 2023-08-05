<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('admin.css')

    <style type="text/css">

        .div_center
        {
            text-align: center;
            padding-top: 40px;
        }

        .h2font
        {
            font-size: 40px;
            padding-bottom: 40px
        }

        .input_color
        {
            color: black
        }
        .center
        {
            margin: auto;
            width: 50%;
            text-align: center;
            margin-top: 30px;
            color: white;
        }
        .tr
        {
            color: black;
            font-size: 55px bold;

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
                    <h2 class="h2font">Add Catagory</h2>

                    <form action="{{url('/add_catagory')}}" method="POST">
                        @csrf
                        <input class="input_color" type="text" name="catagory" placeholder="Write catagory name">

                        <input type="submit" class="btn btn-primary" name="submit" value="Add Catagory">
                    </form>
                </div>
                <form class="center" action="">
                    <table class="table table-border bg-white">
                        <tr class="tr">
                            <td>Catagory Name</td>
                            <td>Action</td>
                        </tr>

                        @foreach ($data as $data)


                        <tr style="color: black">
                            <td>{{$data->catagory_name}}</td>
                            <td>
                                <a class="btn btn-danger" onclick="return confirm('Are You Sure To Delete This?')" href="{{url('delete_catagory', $data->id)}}">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </form>
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
