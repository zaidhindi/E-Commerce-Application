<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContactUs;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\Products;
use App\Models\Support;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isNull;

class BackendController extends Controller
{
    public function dashboard()
    {
        $cat = Category::count('id');
        $order = Order::where('status', 'paid')->sum('price');
        $fproduct = Products::where('isFeatured', 1)->count('id');
        $product = Products::where('isFeatured', 0)->count('id');
        $sales = Order::where('status', 'paid')->latest()->paginate(10);
        return view('backend.index', compact('cat', 'product', 'fproduct', 'order', 'sales'));
    }

    public function AdminLogout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('home');
    } //end method
    public function AddCategory()
    {
        return view('backend.categories.add');
    }
    public function AddCategoryStore(Request $request)
    {
        if ($request->isMethod('post')) {
            $check = Category::where('name', $request->name)->first();
            if (isset($check)) {
                return response()->json(['data' => 0]);
            } else {
                $img = $request->file('img');
                $iname = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
                $source = $img->storeAs('categories', $iname, 'public');

                Category::insert([
                    'name' => $request->name,
                    'order' => $request->order,
                    'img' => $source,
                    'created_at' => Carbon::now()
                ]);
                return response()->json(['data' => 1]);
            }
        } else {
        }
        return redirect()->route('home');
    }
    public function ShowCategory()
    {
        $data = Category::paginate(10);
        return view('backend.categories.index', compact('data'));
    }
    public function CategoryEdit($id)
    {
        $data = Category::findOrFail($id);
        return view('backend.categories.edit', compact('data'));
    }
    public function CategoryUpdate(Request $request)
    {
        $cat = Category::where('id', $request->id);
        $source = "";
        if (isset($request->img)) {
            $img = $request->file('img');
            $iname = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            $source = $img->storeAs('categories', $iname, 'public');
        }
        $data = Category::where('id', $request->id)->update([
            'name' => strip_tags($request->name ?? ''),
            'order' => strip_tags($request->order ?? ''),
            'img' => $source
        ]);
        return response()->json(['data' => 1]);
    }
    public function CategoryDelete(Request $request)
    {
        $data = Category::where('id', $request->id)->delete();
        return response()->json(['data' => 1]);
    } //end method
    public function ProductAdd()
    {
        $categories = Category::all();
        return view('backend.products.add', compact('categories'));
    }
    //end method
    public function productStore(Request $request)
    {
        $category = $request->category;
        $name2 = strip_tags($request->productName);
        $oldPrice = strip_tags($request->oldPrice);
        $newPrice = strip_tags($request->newPrice);
        $des = strip_tags($request->des);
        $img = $request->file('img');
        $iname = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
        $source = $img->storeAs('products', $iname, 'public');

        $data = Products::insert([
            'name' => $name2,
            'category' => $category,
            'old_price' => $oldPrice,
            'new_price' => $newPrice,
            'img' => $source,
            'des' => $des,
            'created_at' => Carbon::now(),
        ]);


        return response()->json(['data' => 1]);
    }
    public function productView()
    {
        $products = Products::latest()->paginate();
        return view('backend.products.index', compact('products'));
    }
    public function ProductEdit($id)
    {
        $product = Products::findOrFail($id);
        $category = Category::all();
        return view('backend.products.edit', compact(['product', 'category']));
    }
    public function productUpdate(Request $request)
    {
        $product = Products::where('id', $request->id)->first();
        if (isset($request->img)) {
            Storage::disk('public')->delete($product->img);
            $img = $request->file('img');
            $iname = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            $product->img = $img->storeAs('products', $iname, 'public');
        }
        $product->name = strip_tags($request->name);
        $product->category = $request->category;
        $product->old_price = strip_tags($request->oldPrice);
        $product->new_price = strip_tags($request->newPrice);
        $product->des = strip_tags($request->des);
        $product->save();
        if ($product) {
            return response()->json(['data' => 1]);
        }
    }
    public function productDelete(Request $request)
    {
        $product = Products::findOrFail($request->id);
        if ($product->img != null) {
            Storage::disk('public')->delete($product->img);
            $product->delete();
        } else {
            $product->delete();
        }
        return response()->json(['data' => 1]);
    }
    // Featured Products code
    public function featured_view()
    {
        $data = Products::where('isFeatured', 1)->latest()->paginate(10);
        return view('backend.featured.index', compact('data'));
    }
    public function featured_add()
    {
        $categories = Category::all();
        return view('backend.featured.add', compact('categories'));
    }
    public function featured_products_store(Request $request)
    {
        $category = $request->category;
        $name2 = strip_tags($request->productName);
        $oldPrice = strip_tags($request->oldPrice);
        $newPrice = strip_tags($request->newPrice);
        $des = strip_tags($request->des);
        $img = $request->file('img');
        $iname = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
        $source = $img->storeAs('products', $iname, 'public');

        $data = Products::insert([
            'name' => $name2,
            'category' => $category,
            'old_price' => $oldPrice,
            'new_price' => $newPrice,
            'img' => $source,
            'des' => $des,
            'isFeatured' => 1,
            'created_at' => Carbon::now(),
        ]);


        return response()->json(['data' => 1]);
    }
    public function featured_product_edit($id)
    {
        $product = Products::findOrFail($id);
        $category = Category::all();
        return view('backend.featured.edit', compact('product', 'category'));
    }
    public function featured_product_update(Request $request)
    {
        $product = Products::where('id', $request->id)->first();
        if (isset($request->img)) {
            Storage::disk('public')->delete($product->img);
            $img = $request->file('img');
            $iname = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            $product->img = $img->storeAs('products', $iname, 'public');
        }
        $product->name = strip_tags($request->name);
        $product->category = $request->category;
        $product->old_price = strip_tags($request->oldPrice);
        $product->new_price = strip_tags($request->newPrice);
        $product->des = strip_tags($request->des);
        $product->save();
        if ($product) {
            return response()->json(['data' => 1]);
        }
    }
    public  function featured_product_delete(Request $request)
    {
        $product = Products::findOrFail($request->id);
        if ($product->img != null) {
            Storage::disk('public')->delete($product->img);
            $product->delete();
        } else {
            $product->delete();
        }
        return response()->json(['data' => 1]);
    }
    public function admin_profile()
    {
        $user = Auth::user();
        return view('backend.profile', compact('user'));
    }
    public function admin_update_account(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->password == '') {
                $user = User::findOrFail(Auth::user()->id);
                $user->update([
                    'name' => strip_tags($request->name),
                    'email' => strip_tags($request->email),
                ]);
                return response()->json(['data' => 1]);
            } else {
                $user = User::find(Auth::user()->id);
                $user->update([
                    'name' => strip_tags($request->name),
                    'email' => strip_tags($request->email),
                    'password' => Hash::make($request->password),
                ]);
                return response()->json(['data' => 1]);
            }
        } else {
            return response()->json(['data' => 0]);
        }
    }
    public function general_setting()
    {
        $data = GeneralSetting::first();
        return view('backend.setting.general.index', compact('data'));
    }
    public function general_setting_edit()
    {
        $data = GeneralSetting::first();
        return view('backend.setting.general.edit', compact('data'));
    }
    public function general_setting_update(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = GeneralSetting::first();
            $data->name = $request->name == '' ? $data->name : strip_tags($request->name);
            $data->phone = $request->phone == '' ? $data->phone : strip_tags($request->phone);
            $data->address = $request->address == '' ? $data->address : strip_tags($request->address);
            $data->email = $request->email == '' ? $data->email : strip_tags($request->email);
            if ($request->hasFile('img')) {
                if ($data->img && Storage::disk('public')->exists($data->img)) {
                    Storage::disk('public')->delete($data->img);
                }
                $img = $request->file('img');
                $iname = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
                $data->img = $img->storeAs('logo', $iname, 'public');
            }
            $data->save();
            return response()->json(['data' => 1]);
        } else {
            return  redirect()->route('home');
        }
    }
    public function contact_us_all()
    {
        $data = ContactUs::latest()->paginate();
        return view('backend.contact_us.index', compact('data'));
    }
    public function contact_us_delete($id)
    {
        $data = ContactUs::findOrFail($id);
        $data->delete();
        return back()->with('success', 'message with id ' . $id . '  deleted ');
    }
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('backend.users', compact('users'));
    }
    public function delete_user(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $user->delete();
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }
    public function admin_support_tickets()
    {
        $latestIds = Support::selectRaw('MAX(id) as id')
            ->groupBy('ticket_no');

        $data = Support::with([
            'user' => function ($q) {
                $q->select(['id', 'name']);
            }
        ])
            ->whereIn('id', $latestIds)
            ->addSelect([
                'unread_count' => Support::selectRaw('count(*)')
                    ->whereColumn('ticket_no', 'supports.ticket_no')->where('sender', 'user')
                    ->where('read', 0)
            ])
            ->latest()
            ->paginate(10);

        return view('backend.support.index', compact('data'));
    }
    public function admin_support_tickets_view($ticket_no)
    {
        $change = Support::where('ticket_no', $ticket_no)->where('sender', 'user')->update(['read' => 1]);
        $data = Support::where('ticket_no', $ticket_no)->with(
            ['user' => function ($e) {
                $e->select(['id', 'name']);
            }]
        )->get();
        $first = $data->first();
        return view('backend.support.view', compact('data', 'first'));
    }
    public function admin_support_ticket_reply(Request $request)
    {
        $title = $request->title;
        $ticket_no = $request->ticket_no;
        $message = $request->message;
        $data = new Support();
        $data->insert([
            'user_id' => Auth::user()->id,
            'title' => $title,
            'ticket_no' => $ticket_no,
            'description' => $message,
            'sender' => 'admin',
            'created_at' => Carbon::now()
        ]);
        if ($data) {
            return response()->json(['data' => true]);
        }
    }
    public function admin_support_ticket_close(Request $request)
    {
        $data = Support::where('ticket_no', $request->ticket_no)->update([
            'status' => 1
        ]);
        return response()->json([
            'data' => 1
        ]);
    }
}
