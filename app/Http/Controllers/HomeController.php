<?php

namespace App\Http\Controllers;

// use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Reply;
use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use Stripe\Reporting\ReportRun;
use RealRashid\SweetAlert\Facades\Alert;



class HomeController extends Controller
{
    public function index()
    {
        $product = product::paginate(3);
        $comment=comment::all();
        $reply=reply::all();
        $count =cart::all()->count();
        return view('home.userpage', compact('product','comment','reply','count'));
    }
    public function redirect()
    {
        $usertype = Auth::user()->usertype;

        if ($usertype == '1') {

            $total_product = product::all()->count();
            $total_order = order::all()->count();
            $total_user = user::all()->count();
            $order = order::all();
            $total_revenue = 0;

            foreach ($order as $order) {
                $total_revenue = $total_revenue + $order->price;
            }

            $total_delivered = order::where('deleivery_status', '=', 'delivered')->get()->count();
            $total_processing = order::where('deleivery_status', '=', 'processing')->get()->count();

            return view('admin.home', compact('total_product', 'total_order', 'total_user',
             'total_revenue', 'total_delivered', 'total_processing'));

        } else {
            $user_id=Auth::id();
            $product = product::paginate(3);
            $comment = comment::all();
            $reply = reply::all();
            $count =cart::where('user_id',$user_id)->count();

            return view('home.userpage', compact('product','comment','reply','count'));
        }
    }

    public function add_cart($id, Request $request)
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userid=$user->id;
            $product = product::find($id);
            $product_exist_id =cart::where('Product_id','=',$id
            )->where('user_id','=',$userid)->get('id')->first();

            if ($product_exist_id)
            {
                $cart=cart::find($product_exist_id)->first();
                $quantity=$cart->quantity;
                $cart->quantity = $quantity + $request->quantity;
                if ($product->discount_price != null) {
                    $cart->price = $product->discount_price * $cart->quantity;
                } else {
                    $cart->price = $product->price * $cart->quantity;
                }
                $cart->save();

                Alert::success('Product Added successfully','We have added product to cart');
                return redirect()->back();
            }
            else
            {
                $cart = new Cart();

                $cart->name = $user->name;
                $cart->email = $user->email;
                $cart->phone = $user->phone;
                $cart->address = $user->address;
                $cart->user_id = $user->id;

                $cart->product_title = $product->title;
                if ($product->discount_price != null) {
                    $cart->price = $product->discount_price * $request->quantity;
                } else {
                    $cart->price = $product->price * $cart->quantity;
                }

                $cart->image = $product->image;
                $cart->product_id = $product->id;
                $cart->quantity = $request->quantity;

                $cart->save();
                return redirect()->back()->with('message','Product Added successfully');
            }

        } else {
            return redirect('login');
        }
    }

    public function show_cart($id)
    {
        if (Auth::id()) {
            $id = Auth::user()->id;
            $count =cart::where('user_id',$id)->count();
            $cart = cart::where('user_id', '=', $id)->get();
            return view('home.showcart', compact('cart', 'count'));
        } else {
            return redirect('login');
        }
    }

    public function remove_cart($id)
    {
        $cart = cart::find($id);

        $cart->delete();

        return redirect()->back()->with('message', 'Cart Deleted successfully');
    }

    public function cash_order()
    {
        $user = Auth::user();
        $userid = $user->id;

        $data = cart::where('user_id', '=', $userid)->get();

        foreach ($data as $data) {
            $order = new Order();
            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->user_id;
            $order->product_title = $data->product_title;
            $order->price = $data->price;
            $order->quantity = $data->quantity;
            $order->image = $data->image;
            $order->product_id = $data->product_id;
            $order->payment_status = 'cash on delivery';

            $order->deleivery_status = 'processing';
            $order->save();

            $cart_id = $data->id;
            $cart = cart::find($cart_id);
            $cart->delete();
        }
        return redirect()->back()->with('message', 'We have Received your order. We will continue to process your order');
    }

    public function stripe($totalprice)
    {

        return view('home.stripe', compact('totalprice'));
    }

    public function stripePost(Request $request, $totalprice)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create([
            "amount" => $totalprice * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Thanks for payment."
        ]);

        $user = Auth::user();
        $userid = $user->id;

        $data = cart::where('user_id', '=', $userid)->get();

        foreach ($data as $data) {
            $order = new Order();
            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->user_id;
            $order->product_title = $data->product_title;
            $order->price = $data->price;
            $order->quantity = $data->quantity;
            $order->image = $data->image;
            $order->product_id = $data->product_id;
            $order->payment_status = 'Paid';

            $order->deleivery_status = 'processing';
            $order->save();

            $cart_id = $data->id;
            $cart = cart::find($cart_id);
            $cart->delete();
        }

        Session::flash('success', 'Payment successful!');

        return back();
    }

    public function show_order()
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count =cart::where('user_id',$userid)->count();
            $order = order::where('user_id', '=', $userid)->get();
            return view('home.order', compact('order', 'count'));
        } else {
            return redirect('login');
        }
    }

    public function cancel_order($id)
    {
        $order = order::find($id);
        $order->deleivery_status = 'Your canceled the order';
        $order->save();

        return redirect()->back();
    }

    public function add_comment(Request $request)
    {
        if (Auth::id())
        {
            $comment = new comment();

            $comment->name=Auth::user()->name;
            $comment->user_id=Auth::user()->id;
            $comment->comment=$request->comment;
            $comment->save();

            return redirect()->back();

        } else {
            return redirect('login');
        }
    }

    public function add_reply(Request $request)
    {
        if (Auth::id())
        {
            $reply= new reply;

            $reply->name=Auth::user()->name;
            $reply->user_id=Auth::user()->id;
            $reply->comment_id=$request->commentId;
            $reply->reply=$request->reply;
            $reply->save();

            return redirect()->back();

        } else {
            return redirect('login');
        }
    }

    public function product_search(Request $request)
    {
        $comment=comment::orderby('id','desc')->get();

        $reply=reply::all();

        $search_text=$request->search;

        $product=product::where('title','LIKE',"%$search_text%")->orWhere
        ('catagory','LIKE',"%$search_text")->paginate(3);

        return view('home.userpage',compact('product','comment','reply'));
    }
    public function product(Request $request)
    {
        $product = product::paginate(10);
        $comment=comment::all();
        $reply=reply::all();
        $user_id=Auth::id();
        $count =cart::where('user_id',$user_id)->count();
        return view('home.all_product',compact('product','comment','reply','count'));
    }

    public function search_product(Request $request)
    {
        $comment=comment::orderby('id','desc')->get();

        $reply=reply::all();

        $search_text=$request->search;

        $product=product::where('title','LIKE',"%$search_text%")->orWhere
        ('catagory','LIKE',"%$search_text")->paginate(3);

        return view('home.all_product',compact('product','comment','reply'));
    }
}
