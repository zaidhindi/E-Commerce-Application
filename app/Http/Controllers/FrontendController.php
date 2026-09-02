<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Mockery\Generator\Method;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use App\Mail\ForgotPassword;
use App\Models\Cart;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\Favorite;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\OrderShip;
use App\Models\Products;
use App\Models\ProductViewd;
use App\Models\Support;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Exception\ApiErrorException;

class FrontendController extends Controller
{
    public function home()
    {
        $fproducts = Products::where('isFeatured', 1)->latest()->paginate(8);
        $first = Products::first();
        $weak_deals = Products::latest()->paginate(3);
        $categories = Category::all();
        $hotsale = Products::where('old_price', '!=', null)->latest()->paginate(8);
        $ip = $_SERVER['REMOTE_ADDR'];
        $view = ProductViewd::where('ip', $ip)->latest()->paginate(6);
        return view('frontend.index', compact('fproducts', 'first', 'weak_deals', 'categories', 'hotsale', 'view',));
    }
    public function user_login(Request $request)
    {
        if ($request->isMethod('post')) {
            $check = $request->all();
            if (Auth::guard('web')->attempt(['email' => $check['email'], 'password' => $check['password']])) {
                $user = User::where('email', $check['email'])->first();
                if ($user->hasRole('admin')) {
                    Auth::login($user);
                    return response()->json(['data' => 1]);
                } else {
                    Auth::login($user);
                    return response()->json(['data' => 2]);
                }
            } else {
                return response()->json(['data' => 0]);
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function new_account(Request $request)
    {
        if ($request->isMethod('post')) {
            $check = User::where('email', $request->email)->first();
            if (isset($check)) {
                return response()->json(['data' => 0]);
            } else {
                $user = new User();
                $user->name = strip_tags($request->name);
                $user->password = Hash::make($request->password);
                $user->email = strip_tags($request->email);
                $user->created_at = Carbon::now();
                $user->save();
                $user->assignRole('user');
                Auth::login($user);
                return response()->json(['data' => 1]);
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function UserLogout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('home');
    }
    public function user_forget_password()
    {
        return view('auth.forgot-password');
    }
    public function user_reset_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $check = User::where('email', $request->email)->first();

            if (($check)) {

                Mail::to($check->email)->send(new ForgotPassword(route('user.update.password', ['id' => $check->id])));
            } else {
                return response()->json(['data' => 0]);
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function user_update_password($id)
    {
        $user = User::findOrFail($id);
        return view('auth.update_password', compact('user'));
    }
    public function user_updated_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $user = User::where('id', $request->userID)->update([
                'password' => Hash::make($request->password)
            ]);
            return response()->json(['data' => 1]);
        } else {
            return redirect()->route('home');
        }
    }
    /*public function error_403()
    {
        if (Auth::check()) {
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('dashboard');
            } else if (Auth::user()->hasRole('user')) {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('/');
        }
    }
    public function error_404()
    {
        if (Auth::check()) {
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('dashboard');
            } else if (Auth::user()->hasRole('user')) {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('/');
        }
    }*/
    public function products_by_category($id)
    {
        $data = Products::where('category', $id)->latest()->paginate(10);
        $cat = Category::all();
        $selectedcat = Category::findOrFail($id);
        return view('frontend.products_by_category', compact('data', 'cat', 'selectedcat'));
    }
    public function product_view($id)
    {
        $data = Products::findOrFail($id);
        $category = Category::where('id', $data->category)->first();
        $ip = $_SERVER['REMOTE_ADDR'];
        $check = ProductViewd::where('ip', $ip)->where('product_id', $id)->first();
        if ($check) {
            return view('frontend.products.view', compact('data', 'category'));
        }
        ProductViewd::insert([
            'ip' => $ip,
            'product_id' => $id,
            'created_at' => Carbon::now()
        ]);
        return view('frontend.products.view', compact('data', 'category'));
    }
    public function super_delas()
    {
        $cat = Category::all();
        $data = Products::whereNotNull('old_price')->latest()->paginate(20);
        $ip = $_SERVER['REMOTE_ADDR'];
        $view = ProductViewd::where('ip', $ip)->latest()->paginate(6);
        return view('frontend.super_deals', compact('cat', 'data', 'view'));
    }
    public function products()
    {
        $cat = Category::all();
        $data = Products::latest()->paginate(20);
        $ip = $_SERVER['REMOTE_ADDR'];
        $view = ProductViewd::where('ip', $ip)->latest()->paginate(6);
        return view('frontend.products', compact('cat', 'data', 'view'));
    }
    public function search_products(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = Products::where('name', 'LIKE', '%' . $request->search . '%')->get();
            if (count($data)) {
                return response()->json(['data' => $data]);
            } else {
                return response()->json(['data' => 0]);
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function search_result($input)
    {
        $cat = Category::all();
        $data = Products::where('name', 'LIKE', '%' . $input . '%')->paginate(8);
        $ip = $_SERVER['REMOTE_ADDR'];
        $view = ProductViewd::where('ip', $ip)->latest()->paginate(6);
        return view('frontend.result', compact('cat', 'data', 'view'));
    }
    public function add_cart(Request $request)
    {
        if ($request->isMethod('post')) {
            $quantity = $request->quantity;
            $product_id = $request->product_id;
            $cart = "";
            if (Auth::check()) {
                $check = Cart::where([
                    ['user_id', Auth::user()->id],
                    ['product_id', $request->product_id]
                ])->first();
                if ($check != null) {
                    return response()->json(['data' => 0]);
                }

                $cart = Cart::insert([
                    'user_id' => Auth::user()->id,
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'created_at' => Carbon::now()
                ]);
            } else {
                $check = Cart::where([
                    ['user_ip', $_SERVER['REMOTE_ADDR']],
                    ['product_id', $request->product_id]
                ])->first();
                if ($check != null) {
                    return response()->json(['data' => 0]);
                }
                $cart = Cart::insert([
                    'user_ip' => $_SERVER['REMOTE_ADDR'],
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'created_at' => Carbon::now()
                ]);
            }
            return response()->json(['data' => $cart]);
        } else {
            return redirect()->route('home');
        }
    }
    public function cart_view()
    {
        if (Auth::check()) {
            $data = DB::table('carts')->where('user_id', Auth::user()->id)->join('products', 'carts.product_id', 'products.id')
                ->select('products.*', 'carts.quantity')->latest()->paginate(8);
        } else {
            $data = DB::table('carts')->where('user_ip', $_SERVER['REMOTE_ADDR'])->join('products', 'carts.product_id', 'products.id')
                ->select('products.*', 'carts.quantity')->latest()->paginate(8);
        }
        return view('frontend.cart', compact('data'));
    }
    public function cart_delete($product_id)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::user()->id)->where('product_id', $product_id)->delete();
            return response()->json(['data' => 1]);
        } else {
            Cart::where('user_ip', $_SERVER['REMOTE_ADDR'])->where('product_id', $product_id)->delete();
            return response()->json(['data' => 1]);
        }
    }
    public function cart_empty()
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::user()->id)->delete();
            return response()->json(['data' => 1]);
        } else {
            Cart::where('user_ip', $_SERVER['REMOTE_ADDR'])->delete();
            return response()->json(['data' => 1]);
        }
    }
    public function add_wishlist($id)
    {
        if (Auth::check()) {
            $data = Favorite::where('user_id', Auth::user()->id)->where('product_id', $id)->first();
            if (isset($data)) {
                return response()->json(['data' => 0]);
            } else {
                Favorite::insert([
                    'user_id' => Auth::user()->id,
                    'product_id' => $id,
                    'created_at' => Carbon::now()
                ]);
                return response()->json(['data' => 1]);
            }
        } else {
            $data = Favorite::where('user_ip', $_SERVER['REMOTE_ADDR'])->where('product_id', $id)->first();
            if (isset($data)) {
                return response()->json(['data' => 0]);
            } else {
                Favorite::insert([
                    'user_ip' => $_SERVER['REMOTE_ADDR'],
                    'product_id' => $id,
                    'created_at' => Carbon::now()
                ]);
                return response()->json(['data' => 1]);
            }
        }
    }
    public function wishlist()
    {
        if (Auth::check()) {
            $data = DB::table('favorites')->where('user_id', Auth::user()->id)
                ->join('products', 'favorites.product_id', '=', 'products.id')
                ->select('products.*')->latest()->paginate(8);
        } else {
            $data = DB::table('favorites')->where('user_ip', $_SERVER['REMOTE_ADDR'])
                ->join('products', 'favorites.product_id', '=', 'products.id')
                ->select('products.*')->latest()->paginate(8);
        }
        return view('frontend.wishlist', compact('data'));
    }
    public function wishlist_delete($id)
    {
        if (Auth::check()) {
            $data = Favorite::where('user_id', Auth::user()->id)->where('product_id', $id)->firstOrFail();
            $data->delete();
        } else {
            $data = Favorite::where('user_ip', $_SERVER['REMOTE_ADDR'])->where('product_id', $id)->firstOrFail();
            $data->delete();
        }
        return response()->json([
            'data' => 1
        ]);
    }
    public function pay_now()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $cart = Cart::where('user_id', $user_id)->get();
        } else {
            $user_ip =  $_SERVER['REMOTE_ADDR'];
            $cart = Cart::where('user_ip', $user_ip)->get();
        }

        if ($cart->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }


        $lineItems = [];
        foreach ($cart as $val) {
            $product = Products::find($val->product_id);
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => $product->new_price * 100,
                ],
                'quantity' => $val->quantity,
            ];
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
        ]);

        return redirect($session->url);
    }
    public function checkout_succees(Request $request)
    {
        if (!$request->filled('session_id')) {
            return redirect()->route('home')->with('error', 'Invalid checkout session id');
        }
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session = StripeSession::retrieve($request->session_id);
        } catch (ApiErrorException $e) {
            return redirect()->route('home')->with('error', 'Invalid checkout session id');
        }

        if ($session->payment_status != 'paid') {
            return redirect()->route('frontend.cart')->with('error', 'Payment is not Compelted');
        }
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $user_ip = null;
            $cart = Cart::where('user_id', $user_id)->get();
        } else {
            $user_id = null;
            $user_ip = $_SERVER['REMOTE_ADDR'];
            $cart = Cart::where('user_ip', $user_ip)->get();
        }
        $order = Order::where('stripe_session_id', $session->id)->first();
        if ($order) {
            return view('frontend.checkout.success', compact('order'));
        }
        $quantity = [];
        $price = [];
        $pro = [];
        foreach ($cart as $val) {
            $product = Products::find($val->product_id);
            $price[] = $product->new_price;
            $quantity[] = $val->quantity;
            $pro[] = $val->product_id;
        }
        $order = new Order();
        $order->user_id = $user_id;
        $order->user_ip = $user_ip;
        $order->product_id = json_encode($pro);
        $order->price = array_sum($price);
        $order->ref = 'ORD-' . strtoupper(Str::random(10)) . Carbon::now();
        $order->status = 'paid';
        $order->quantity = json_encode($quantity);
        $order->created_at = Carbon::now();
        $order->stripe_session_id = $session->id;
        $order->save();
        if ($user_id != null) {
            Cart::where('user_id', $user_id)->delete();
        } else {
            Cart::where('user_ip', $user_ip)->delete();
        }
        return view('frontend.checkout.success', compact('order'));
    }
    public function checkout_cancel()
    {
        return view('frontend.checkout.cancel');
    }
    public function order_ship_store(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'country' => 'required',
                'city' => 'required',
                'address' => 'required',
            ]);
            $check = OrderShip::where('order_id', $request->order_id)->first();
            if ($check) {
                return redirect()->route('order.confirmed');
            }
            $data = OrderShip::insert([
                'order_id' => $request->order_id,
                'name' => strip_tags($request->name),
                'phone' => strip_tags($request->phone),
                'country' => strip_tags($request->country),
                'city' => strip_tags($request->city),
                'address' => strip_tags($request->address),
                'verfiy' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return redirect()->route('order.confirmed');
        } else {
            return redirect()->route('home');
        }
    }
    public function order_confirmed()
    {
        return view('frontend.order_confirmed');
    }
    public function my_orders()
    {
        if (Auth::check()) {
            $data = Order::where('user_id', Auth::user()->id)->latest()->paginate(8);
        } else {
            $data = Order::where('user_ip', $_SERVER['REMOTE_ADDR'])->latest()->paginate(8);
        }
        return view('frontend.my_order', compact('data'));
    }
    public function contact_us()
    {
        return view('frontend.contact_us');
    }
    public function contact_us_submit(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|numeric',
                'email' => 'required|email',
                'message' => 'required'
            ]);
            $name = strip_tags($request->name);
            $email = strip_tags($request->email);
            $phone = strip_tags($request->phone);
            $message = strip_tags($request->message);
            $data = ContactUs::insert([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'message' => $message,
                'created_at' => Carbon::now()
            ]);

            if ($data == true) {
                return back()->with('success', 'your message sent to admin');
            } else {
                return back()->with('error', 'somthing went wrong');
            }
        } else {
            return redirect()->route('home');
        }
    } //end method
    public function user_account()
    {
        $user = Auth::user();
        return view('frontend.my_account', compact('user'));
    }
    public function update_profile(Request $request)
    {
        if ($request->isMethod('post')) {
            $name = strip_tags($request->name);
            $email = strip_tags($request->email);
            if ($request->password != null) {
                $password = Hash::make($request->password);
            } else {
                $password = Auth::user()->password;
            }
            $user = User::where('id', Auth::user()->id)->update([
                'name' => $name,
                'email' => $email,
                'password' => $password
            ]);
            if ($user) {
                Auth::login($user);
                return response()->json(['data' => 1]);
            } else {
                return response()->json(['data' => 0]);
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function user_support_tickets()
    {
        $userId = Auth::id();


        $data = Support::whereIn('id', function ($query) {
            $query->selectRaw('MAX(id)')
                ->from('supports')
                ->groupBy('ticket_no');
        })
            ->whereExists(function ($query) use ($userId) {
                $query->selectRaw(1)
                    ->from('supports as s')
                    ->whereColumn('s.ticket_no', 'supports.ticket_no')
                    ->where('s.user_id', $userId);
            })
            ->addSelect([
                'unread_count' => Support::selectRaw('count(*)')
                    ->whereColumn('ticket_no', 'supports.ticket_no')
                    ->where('read', 0)
                    ->where('sender', 'admin')
            ])
            ->latest()
            ->paginate(10);

        return view('frontend.support.index', compact('data'));
    }
    public function user_support_ticket_add()
    {
        return view('frontend.support.add');
    }
    public function user_support_ticket_store(Request $request)
    {
        $title = strip_tags($request->title);
        $description = strip_tags($request->des);
        $user_id = Auth::user()->id;
        $check = Support::where([
            ['user_id', $user_id],
            ['status', false]
        ])->latest()->first();
        if (isset($check)) {
            $data = Support::insert([
                'user_id' => $user_id,
                'title' => $title,
                'description' => $description,
                'ticket_no' => $check->ticket_no,
                'sender' => 'user',
                'created_at' => Carbon::now(),
            ]);
            return response()->json(['data' => $data]);
        } else {
            $rand = rand(1000, 100000);
            $data = Support::insert([
                'user_id' => $user_id,
                'title' => $title,
                'description' => $description,
                'ticket_no' => $rand,
                'sender' => 'user',
                'created_at' => Carbon::now(),
            ]);
            return response()->json(['data' => $data]);
        }
    }
    public function support_view($id)
    {
        $check = Support::where('id', $id)->first();
        $data = Support::where('ticket_no', $check->ticket_no)->get();
        $chang = Support::where('ticket_no', $check->ticket_no)->where('sender', 'admin')->update(['read' => 1]);
        return view('frontend.support.view', compact('data'));
    }
    public function support_ticket_update(Request $request)
    {
        $user_id = Auth::user()->id;
        $ticket_no = strip_tags($request->ticket_no);
        $messages = strip_tags($request->message);
        $check = Support::where('ticket_no', $request->ticket_no)->get();
        if (count($check) > 0) {
            $data = Support::insert([
                'user_id' => $user_id,
                'description' => $messages,
                'ticket_no' => $ticket_no,
                'title' => $check->first()->title,
                'sender' => 'user',
                'created_at' => Carbon::now(),
            ]);
            return response()->json(['message' => $messages, 'status' => true, 'created_at' => Carbon::now()->format('M d, Y - h:i A'),]);
        }
    }
    public function user_support_ticket_close(Request $request)
    {
        $data = Support::where('ticket_no', $request->ticket_no)->update(['status' => 1]);
        return response()->json([
            'data' => $data,
        ]);
    }
}
