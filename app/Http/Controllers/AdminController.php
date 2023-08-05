<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Catagory;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use PDF;
use App\Notifications\SendEmailNotification;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;

class AdminController extends Controller
{
    public function view_catagory() // returns the category object associated with the given category
    {
        if (Auth::id())
        {
            $data=Catagory::all();
            return view('admin.catagory',compact('data'));
        }
        else
        {
            return redirect('login');
        }


    }

    public function add_catagory(Request $request)
    {
        if  (Auth::id())
        {
            $data=new catagory;

            $data->catagory_name = $request->catagory;
            $data->save();

            return redirect()->back()->with('message','Catagory Added successfully');
        }
        else
        {
            return redirect('login');
        }


    }
    public function delete_catagory($id)
    {
        $data=Catagory::find($id);

        $data->delete();

        return redirect()->back()->with('message','Catagory Deleted successfully');
    }

    public function view_product()
    {
        $catagory =catagory::all();
        return view('admin.product',compact('catagory'));
    }

    public function add_product(Request $request)
    {
        $product = new Product();

        $product->title= $request->title;
        $product->description= $request->description;
        $product->price= $request->price;
        $product->discount_price = $request->dis_price;
        $product->quantity = $request->quantity;
        $product->catagory = $request->catagory;

        $image=$request->image;
        $imagename=time().'.'.$image->getClientOriginalExtension();
        $request->image->move('product',$imagename);
        $product->image= $imagename;
        $product->save();

        return redirect()->back()->with('message','product successfully added');
    }

    public function show_product()
    {
        $product=product::all(); // get all products
        return view('admin.show_product',compact('product'));
    }

    public function delete_product($id)
    {
        $product=product::find($id);

        $product->delete();

        return redirect()->back()->with('message','Product Deleted successfully');
    }

    public function edit_product($id)
    {
        $product=product::find($id);
        $catagory =catagory::all();

        return view('admin.edit_product',compact('product','catagory'));
    }

    public function update_product(Request $request,$id)
    {
        if(Auth::id())
        {
            $product = product::find($id);

            $product->title= $request->title;
            $product->description= $request->description;
            $product->price= $request->price;
            $product->discount_price = $request->dis_price;
            $product->quantity = $request->quantity;
            $product->catagory = $request->catagory;

            $image=$request->image;
            if($image)
            {
                $imagename=time().'.'.$image->getClientOriginalExtension();
                $request->image->move('product',$imagename);
                $product->image= $imagename;
            }
            $product->save();

            return redirect()->back()->with('message','product successfully updated');
        }
        else
        {
            return redirect('login');
        }

    }

    public function product_details($id)
    {
        $product = product::find($id);
        $user_id=Auth::id();
        $count =cart::where('user_id',$user_id)->count();
        return view('home.product_details',compact('product','count'));
    }

    public function order()
    {
        $order=Order::all();
        return view('admin.order',compact('order'));
    }

    public function delivered($id)
    {
        $order=order::find($id);
        $order->deleivery_status="delivered";
        $order->payment_status="Paid";

        $order->save();

        return redirect()->back();
    }

    public function print_pdf($id)
    {
        $order = order::find($id);
        $pdf=\Barryvdh\DomPDF\Facade\Pdf::loadView('admin.pdf',compact('order'));


        return $pdf->download('order_details');

    }


    public function send_email($id)
    {
        $order=order::find($id);
        return view('admin.email_info',compact('order'));
    }

    public function send_user_email(Request $request,$id)
    {
        $order=order::find($id);

        $details = [
            'greeting' => $request->greeting,
            'firstline' => $request->firstline,
            'body' => $request->body,
            'button' => $request->button,
            'url' => $request->url,
            'lastline' => $request->lastline,
        ];

        Notification::send($order,new SendEmailNotification($details));

        return redirect()->back();
    }

    public function searchdata(Request $request)
    {
        $searchText=$request->search;

        $order=order::where('name','LIKE',"%$searchText%")->orWhere('phone','LIKE',"%$searchText%"
        )->orWhere('product_title','LIKE',"%$searchText%")->get();

        return view('admin.order',compact('order'));
    }
}
