<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Feedback;
use App\Models\News;
use Stripe;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    //
    
     public function home()
    {
        // Lấy tất cả sản phẩm từ bảng 'products' và kèm theo thông tin thương hiệu
        $products = Product::with('brand')->get();
        // Lấy bàn phím từ bảng 'products' theo category_id
        $keyboardCategoryId = 1; // Giả sử category_id cho bàn phím là 1
        $keyboards = Product::where('category_id', $keyboardCategoryId)
            ->limit(4)
            ->get();

        // Lấy tin tức từ bảng 'news'
        $news = News::all(); // Lấy tất cả tin tức

        // Kiểm tra nếu người dùng đã đăng nhập
        if (Auth::check()) {
            $user_id = Auth::id();  // Lấy id của người dùng
            $count = Cart::where('user_id', $user_id)->sum('quantity');  // Đếm số lượng giỏ hàng
        } else {
            $count = 0;  // Nếu chưa đăng nhập thì giỏ hàng là 0
        }

        // Truyền biến 'products' và 'count' vào view 'home.index'
        return view('home.index', compact('products','keyboards', 'count', 'news'));
    }
    // public function login_home()
    // {
    //     // Lấy tất cả sản phẩm từ bảng 'products'
    //     $products = Product::all();
    //     $user = Auth::user();
    //     $user_id = $user->id;
    //     $count = Cart::where('user_id',$user_id)->sum('quantity');
        
    //     // Truyền biến 'products' vào view 'home.index'
    //     return view('home.index', compact('products','count'));

    // }

    public function product_details($id)
    {
        // Lấy sản phẩm từ bảng 'products' kèm theo hình ảnh với id trùng với tham số truyền vào
        $product = Product::with('images')->find($id);
        if (Auth::id()){
            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where('user_id',$user_id)->sum('quantity');
            
        }
        else{
            $count = '';
        }
        
        // Truyền biến 'product' vào view 'home.product_details'
        return view('home.product_details', compact('product','count'));
    }

    public function add_cart($id){
        $product_id = $id;
        $user = Auth::user();
        $user_id = $user->id;
        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
        $existing_cart_item = Cart::where('user_id', $user_id)
        ->where('product_id', $product_id)
        ->first();
        if ($existing_cart_item){
             // Nếu sản phẩm đã có, tăng số lượng lên
            $existing_cart_item->quantity += 1; // Tăng số lượng lên 1
            $existing_cart_item->save(); // Lưu lại thay đổi
        }
        else {
            $data = new Cart;
            $data->user_id = $user_id;
            $data->product_id = $product_id;
            $data->save();
            
        }
        toastr()->timeOut(timeOut: 10000)->closeButton()->addSuccess('Thêm vào giỏ hàng thành công');
        return redirect()->back();
    }  

    public function mycart(){
        if (Auth::id()){
            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where('user_id',$user_id)->sum('quantity');
            $cart = Cart::with('product')->where('user_id', $user_id)->get();        
        }
        return view('home.mycart',compact('count','cart'));
    }
    public function delete_cart(Request $request){
        $id = $request->id;
        $cart = Cart::find($id);
        $cart->delete();
        toastr()->timeOut(timeOut: 10000)->closeButton()->addSuccess('Xóa sản phẩm khỏi giỏ hàng thành công');
        return redirect()->back();
    }
    public function updateCartQuantity(Request $request, $id){
        $cart = Cart::find($id);
    
    if ($request->action == 'increase') {
        // Tăng số lượng
        $cart->quantity += 1;
    } elseif ($request->action == 'decrease') {
        // Giảm số lượng, nếu số lượng lớn hơn 1 thì giảm, ngược lại sẽ xóa sản phẩm
        if ($cart->quantity > 1) {
            $cart->quantity -= 1;
        } else {
            $cart->delete();
            toastr()->addSuccess('Sản phẩm đã được xóa khỏi giỏ hàng');
            return redirect()->back();
        }
    }

    $cart->save();
    toastr()->addSuccess('Cập nhật số lượng thành công');
    return redirect()->back();
    }

    public function placeOrder(Request $request)
{
    // Xác thực dữ liệu đầu vào
    $validatedData = $request->validate([
        'fullname' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:15',
        'address' => 'required|string|max:255',
        'note' => 'nullable|string|max:255',
    ]);

    // Tạo đơn hàng mới
    $order = new Order();
    $order->user_id = Auth::id(); // Nếu có đăng nhập
    $order->fullname = $validatedData['fullname'];
    $order->email = $validatedData['email'];
    $order->phone = $validatedData['phone'];
    $order->address = $validatedData['address'];
    $order->note = $validatedData['note'];
    $order->status = 'pending'; // Hoặc trạng thái mặc định khác
    $order->total_money = 0; // Sẽ cập nhật sau
    $order->order_date = now();
    $order->save(); // Lưu đơn hàng vào cơ sở dữ liệu

    // Lấy thông tin giỏ hàng
    $cartItems = Cart::where('user_id', Auth::id())->get(); // Lấy tất cả sản phẩm trong giỏ hàng của người dùng
    $totalMoney = 0; // Biến tổng tiền

    foreach ($cartItems as $item) {
        $product = Product::find($item->product_id); // Tìm sản phẩm theo ID

        if ($product) {
            // Kiểm tra xem số lượng trong kho có đủ để đáp ứng đơn hàng không
            if ($product->quantity >= $item->quantity) {
                // Tạo chi tiết đơn hàng
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id; // Liên kết với đơn hàng
                $orderDetail->product_id = $item->product_id; // ID sản phẩm
                $orderDetail->price = $product->price; // Giá sản phẩm
                $orderDetail->num = $item->quantity; // Số lượng
                $orderDetail->total_money = $product->price * $item->quantity; // Tính tổng tiền cho sản phẩm
                $orderDetail->save(); // Lưu chi tiết đơn hàng vào database

                // Cập nhật số lượng sản phẩm sau khi khách hàng mua
                $product->quantity -= $item->quantity;
                $product->save(); // Lưu thay đổi về số lượng sản phẩm vào database

                // Cộng tổng tiền vào đơn hàng
                $totalMoney += $orderDetail->total_money;
            } else {
                // Nếu không đủ số lượng, trả về lỗi
                return back()->withErrors(['error' => 'Sản phẩm ' . $product->name . ' không đủ số lượng.']);
            }
        }
    }

    // Cập nhật tổng tiền cho đơn hàng
    $order->total_money = $totalMoney;
    $order->save(); // Lưu lại thông tin đơn hàng với tổng tiền

    // Xóa giỏ hàng sau khi đặt hàng thành công
    Cart::where('user_id', Auth::id())->delete(); // Xóa tất cả sản phẩm trong giỏ hàng của người dùng

    // Thông báo thành công
    toastr()->success('Đặt hàng thành công!'); // Hiển thị thông báo thành công

    // Chuyển hướng về trang chủ hoặc trang khác
    return redirect()->route('home'); // Chuyển hướng về trang chủ
}
    public function myOrders()
    {
        // Lấy tất cả đơn hàng của người dùng với chi tiết sản phẩm
        $orders = Order::where('user_id', Auth::id())->with('orderDetails.product')->get();
        
        // Kiểm tra người dùng đã đăng nhập chưa và lấy số lượng sản phẩm trong giỏ hàng
        $count = 0;
        if (Auth::check()) {
            $user_id = Auth::id();
            $count = Cart::where('user_id', $user_id)->sum('quantity');
        }
    
        // Truyền biến $orders và $count vào view
        return view('home.orders', compact('orders', 'count'));
    }
    public function orderDetails($id)
    {
        // Lấy đơn hàng cùng với các chi tiết sản phẩm
        $order = Order::with('orderDetails.product')->findOrFail($id);
    
        // Kiểm tra người dùng đã đăng nhập chưa và lấy số lượng sản phẩm trong giỏ hàng
        $count = 0;
        if (Auth::check()) {
            $user_id = Auth::id();
            $count = Cart::where('user_id', $user_id)->sum('quantity');
        }
    
        // Truyền biến $order và $count vào view
        return view('home.order_detail', compact('order', 'count'));
    }
    public function shop()
    {
        // Lấy tất cả sản phẩm từ bảng 'products' và kèm theo thông tin thương hiệu
        $products = Product::with('brand')->get();
    
        // Kiểm tra nếu người dùng đã đăng nhập
        if (Auth::check()) {
            $user_id = Auth::id();  // Lấy id của người dùng
            $count = Cart::where('user_id', $user_id)->sum('quantity');  // Đếm số lượng giỏ hàng
        } else {
            $count = 0;  // Nếu chưa đăng nhập thì giỏ hàng là 0
        }
    
        // Truyền biến 'products' và 'count' vào view 'home.index'
        return view('home.shop', compact('products', 'count'));
    }

    public function whyUs()
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (Auth::check()) {
            $user_id = Auth::id();  // Lấy id của người dùng
            $count = Cart::where('user_id', $user_id)->sum('quantity');  // Đếm số lượng giỏ hàng
        } else {
            $count = 0;  // Nếu chưa đăng nhập thì giỏ hàng là 0
        }
    
        // Truyền biến 'count' vào view 'home.why-us'
        return view('home.why', compact('count'));
    }
    
    public function feedback()
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (Auth::check()) {
            $user_id = Auth::id();  // Lấy id của người dùng
            $count = Cart::where('user_id', $user_id)->sum('quantity');  // Đếm số lượng giỏ hàng
        } else {
            $count = 0;  // Nếu chưa đăng nhập thì giỏ hàng là 0
        }
    
        // Truyền biến 'count' vào view 'home.feedback'
        return view('home.feedback', compact('count'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject_name' => 'required|string|max:255',
            'note' => 'required|string',
        ]);

        Feedback::create($request->all()); // Giả định bạn đã tạo model Feedback và bảng tương ứng

        toastr()->timeOut(10000)->closeButton()->addSuccess('Phản hồi đã được gửi thành công');
        return redirect()->back();
    }

    public function stripe($total)
    {
        
        return view('home.stripe', compact('total'));
    }

    public function stripePost(Request $request, $total)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // Đảm bảo rằng $total không vượt quá 99,999,999 VND
        if ($total > 99999999) {
            return back()->withErrors(['error' => 'Số tiền vượt quá giới hạn thanh toán của Stripe.']);
        }

        try {
            // Xử lý thanh toán qua Stripe
            Stripe\Charge::create([
                "amount" => $total,
                "currency" => "vnd",
                "source" => $request->stripeToken,
                "description" => "Payment from Gear Shop"
            ]);

            // Sau khi thanh toán thành công, bắt đầu lưu thông tin đơn hàng

            // Xác thực thông tin từ form người dùng
            $validatedData = $request->validate([
                'fullname' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:15',
                'address' => 'required|string|max:255',
                'note' => 'nullable|string|max:255',
            ]);

            // Tạo đơn hàng mới
            $order = new Order();
            $order->user_id = Auth::id(); // Lấy ID người dùng nếu có đăng nhập
            $order->fullname = $validatedData['fullname'];
            $order->email = $validatedData['email'];
            $order->phone = $validatedData['phone'];
            $order->address = $validatedData['address'];
            $order->note = $validatedData['note'];
            $order->status = 'pending'; 
            $order->payment_status = 'paid'; // Trạng thái thanh toán
            $order->total_money = 0; // Sẽ cập nhật sau
            $order->order_date = now();
            $order->save(); // Lưu đơn hàng vào cơ sở dữ liệu

            // Lấy thông tin giỏ hàng của người dùng
            $cartItems = Cart::where('user_id', Auth::id())->get();
            $totalMoney = 0; // Biến tổng tiền

            // Lưu chi tiết từng sản phẩm trong đơn hàng
            foreach ($cartItems as $item) {
                $product = Product::find($item->product_id); // Tìm sản phẩm theo ID
    
                if ($product) {
                    // Kiểm tra xem số lượng trong kho có đủ để đáp ứng đơn hàng không
                    if ($product->quantity >= $item->quantity) {
                        // Tạo chi tiết đơn hàng
                        $orderDetail = new OrderDetail();
                        $orderDetail->order_id = $order->id; // Liên kết với đơn hàng
                        $orderDetail->product_id = $item->product_id; // ID sản phẩm
                        $orderDetail->price = $product->price; // Giá sản phẩm
                        $orderDetail->num = $item->quantity; // Số lượng
                        $orderDetail->total_money = $product->price * $item->quantity; // Tính tổng tiền cho sản phẩm
                        $orderDetail->save(); // Lưu chi tiết đơn hàng vào database
    
                        // Cập nhật số lượng sản phẩm sau khi khách hàng mua
                        $product->quantity -= $item->quantity;
                        $product->save(); // Lưu thay đổi về số lượng sản phẩm vào database
    
                        // Cộng tổng tiền vào đơn hàng
                        $totalMoney += $orderDetail->total_money;
                    } else {
                        // Nếu không đủ số lượng, trả về lỗi
                        return back()->withErrors(['error' => 'Sản phẩm ' . $product->name . ' không đủ số lượng.']);
                    }
                }
            }
    
            // Cập nhật tổng tiền cho đơn hàng
            $order->total_money = $totalMoney;
            $order->save(); // Lưu lại thông tin đơn hàng
    
            // Xóa giỏ hàng của người dùng sau khi đặt hàng thành công
            Cart::where('user_id', Auth::id())->delete();
    
            // Thông báo thành công
            toastr()->success('Thanh toán thành công! Đơn hàng của bạn đã được ghi nhận.');
    
            // Chuyển hướng về trang chủ hoặc trang khác
            return redirect()->route('home');
    
        } catch (\Exception $e) {
            // Nếu có lỗi trong quá trình thanh toán
            toastr()->error('Có lỗi xảy ra trong quá trình thanh toán. Vui lòng thử lại.');
            return back();
        }
    }

}