<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Image;
use App\Models\News;
use App\Models\User;
use App\Models\Feedback;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use App\Exports\ProductExport;
class AdminController extends Controller
{
    public function index(){
        $user = User::where('role_type','User')->get()->count();
        $product = Product::all()->count();
        $order = Order::all()->count();
        // Đếm số lượng đơn hàng có trạng thái 'completed'
        $totalDelivered = Order::where('status', 'completed')->count();
        return view('admin.index',compact('user','product','order','totalDelivered'));
    }
    public function view_category(){
        $data = Category::all();
        return view('admin.category',compact('data'));
    }
    public function add_category(Request $request) {
        // Kiểm tra xem danh mục đã tồn tại chưa
        $existingCategory = Category::where('name', $request->name)->first();
        
        if ($existingCategory) {
            // Nếu danh mục đã tồn tại, hiển thị thông báo lỗi
            toastr()->timeOut(10000)->closeButton()->addError('Danh mục đã tồn tại!');
            return redirect()->back();
        }
    
        // Nếu không tồn tại, thêm danh mục mới
        $category = new Category;
        $category->name = $request->name;
        $category->save();
    
        // Thông báo thành công
        toastr()->timeOut(10000)->closeButton()->addSuccess('Thêm danh mục thành công');
        return redirect()->back();
    }
    public function delete_category($id){
        $category = Category::find($id);
        $category->delete();
        toastr()->timeOut(10000)->closeButton()->addSuccess('Xóa danh mục thành công');
        return redirect()->back();
    }
    public function edit_category($id){
        $data = Category::find($id);
        return view('admin.edit_category',compact('data'));
    }
    public function update_category(Request $request, $id){
        $data = Category::find($id);
        $data->name = $request->category;
        $data->save();
        toastr()->timeOut(10000)->closeButton()->addSuccess('Cập nhật danh mục thành công');
        return redirect()->route('admin.category');
    }
    public function add_product(){
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.add_product',compact('categories','brands'));
    }
    public function upload_product(Request $request){
        $data = new Product;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->category_id = $request->category_id;
        $data->discount = $request->discount;
        $data->quantity = $request->quantity;
        $data->brand_id = $request->brands_id;
        // Tạo product_code dựa trên tên hãng và danh mục
        $brand = Brand::find($request->brands_id);
        $category = Category::find($request->category_id);
        
        // Giả sử bạn chỉ cần 3 ký tự đầu của tên hãng và tên danh mục
        $brandCode = substr($brand->name, 0, 3); // Lấy 3 ký tự đầu tiên của tên hãng
        $categoryCode = substr($category->name, 0, 1); // Lấy 2 ký tự đầu tiên của tên danh mục
        
        // Tạo mã sản phẩm
        $randomNumber = rand(1000, 9999); // Số ngẫu nhiên từ 1000 đến 9999
        $data->product_code = strtoupper($categoryCode . '_' . $brandCode . '_' . $randomNumber); // Tạo mã sản phẩm
        $thumbnail = $request->thumbnail;
        if($thumbnail){
            $thumbnailName = time().'_'.$thumbnail->getClientOriginalExtension();
            $thumbnail->move('products',$thumbnailName);
            $data->thumbnail = $thumbnailName;
        }
        $data->save();
        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName(); // Đổi tên file
                $image->move('products/images', $imageName); // Di chuyển file vào thư mục images
    
                // Lưu thông tin hình ảnh vào bảng images
                Image::create([
                    'product_id' => $data->id,
                    'image_path' => 'products/images/' . $imageName,
                ]);
            }
        }
        
        toastr()->timeOut(10000)->closeButton()->addSuccess('Thêm sản phẩm thành công');
        return redirect()->back();
    }
    public function view_product(){
        $data = Product::with(['brand', 'category'])->paginate(5);
        return view('admin.view_product',compact('data'));
    }
    public function delete_product(Request $request){
        $data = Product::find($request->id);
        $thumbnail_path = public_path('products/'.$data->thumbnail);
        if(file_exists($thumbnail_path)){
            unlink($thumbnail_path);
        }
        $data->delete();
        toastr()->timeOut(10000)->closeButton()->addSuccess('Xóa sản phẩm thành công');
        return redirect()->back();
    }
    public function update_product($id){
        $data = Product::find($id);
        return view('admin.update_page',compact('data'));
    }
    public function edit_product(Request $request){
        $data = Product::find($request->id);
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->quantity = $request->quantity;
        $data->discount = $request->discount;

        $thumbnail = $request->thumbnail;
        if ($thumbnail) {
            // Xóa ảnh cũ nếu có
            $oldThumbnailPath = public_path('products/'.$data->thumbnail);
            if (file_exists($oldThumbnailPath)) {
                unlink($oldThumbnailPath);
            }
    
            // Upload ảnh mới
            $thumbnailname = time().'.'.$thumbnail->getClientOriginalExtension();
            $request->thumbnail->move('products', $thumbnailname);
    
            // Cập nhật trường thumbnail trong cơ sở dữ liệu
            $data->thumbnail = $thumbnailname;
        }
        $data ->save();
        toastr()->timeOut(10000)->closeButton()->addSuccess('Cập nhật sản phẩm thành công');
        return redirect()->route('admin.viewproduct');

    }
    public function search_product(Request $request) {
        $search = $request->search;
        
        // Kiểm tra xem tìm kiếm có phải là số (id sản phẩm)
        if (is_numeric($search)) {
            $data = Product::where('id', '=', $search)
                ->paginate(5);
        } else {
            // Nếu không phải là số, tìm kiếm theo title hoặc product_code
            $data = Product::where('product_code', 'like', '%' . $search . '%')
                ->orWhere('title', 'like', '%' . $search . '%')
                ->paginate(5);
        }
    
        return view('admin.view_product', compact('data'));
    }

    public function view_brands(){
        $data = Brand::all();
        return view('admin.brands',compact('data'));
    }

    public function add_brands(request $request){
        $data = new Brand();
        $data->name = $request->name;
        $data->save();
        toastr()->timeOut(timeOut: 10000)->closeButton()->addSuccess('Thêm hãng thành công');
        return redirect()->back();
    }

    public function delete_brands($id){
        $data = Brand::find($id);
        $data->delete();
        toastr()->timeOut(10000)->closeButton()->addSuccess('Xóa hãng thành công');
        return redirect()->back();
    }

    public function edit_brands($id){
        $data = Brand::find($id);
        return view('admin.edit_brands',compact('data'));
    }

    public function update_brands(Request $request, $id){
        $data = Brand::find($id);
        $data->name = $request->brands;
        $data->save();
        toastr()->timeOut(10000)->closeButton()->addSuccess('Cập nhật hãng thành công');
        return redirect()->route('admin.brands');
    }

    public function viewOrders(Request $request) {
        // Lấy trạng thái từ request (nếu có)
        $status = $request->input('status');

        // Lấy danh sách các đơn hàng từ cơ sở dữ liệu, hỗ trợ lọc theo trạng thái
        $ordersQuery = Order::query();

        // Nếu có trạng thái thì lọc theo trạng thái đó
        if ($status) {
            $ordersQuery->where('status', $status);
        }

        // Phân trang kết quả
        $orders = $ordersQuery->paginate(5);

        // Truyền danh sách đơn hàng vào view
        return view('admin.orders', compact('orders', 'status'));
    }
    
    public function orderDetails($id) {
        // Lấy thông tin chi tiết đơn hàng theo ID
        $order = Order::with('orderDetails.product')->findOrFail($id);
        return view('admin.order_details', compact('order'));
    }
    
    public function updateOrderStatus($id) {
        // Cập nhật trạng thái đơn hàng thành "completed"
        $order = Order::findOrFail($id);
        $order->status = 'completed';
        $order->save();
    
        return redirect()->back()->with('success', 'Đơn hàng đã được xử lý');
    }
    
    public function searchOrder(Request $request) {
        $search = $request->search;
        $orders = Order::where('fullname', 'like', '%' . $search . '%')
                       ->orWhere('email', 'like', '%' . $search . '%')
                       ->paginate(5);
    
        return view('admin.orders', compact('orders'));
    }

    public function add_news(){
        return view('admin.add_news');
    }

    public function upload_news(Request $request)
    {
    $request->validate([
        'title' => 'required',
        'href_param' => 'required',
        'thumbnail' => 'required|image',
        'content' => 'required',
    ]);

    $news = new News();
    $news->title = $request->title;
    $news->href_param = $request->href_param;

    // Upload thumbnail
    if ($request->hasFile('thumbnail')) {
        $imageName = time() . '.' . $request->thumbnail->extension();
        $request->thumbnail->move(public_path('uploads/news'), $imageName);
        $news->thumbnail = 'uploads/news/' . $imageName;
    }

    $news->content = $request->content;
    $news->save();
    toastr()->timeOut(10000)->closeButton()->addSuccess('Thêm tin tức thành công');
    return redirect()->back();
    }

    public function view_users (){
        $data = User::paginate(5);
        return view('admin.users',compact('data'));
    }

    public function update_user(Request $request, $id){
        $user = User::find($id);
        if($user){
            $user->role_type = $request->input('role_type');
            $user->save();
            toastr()->timeOut(10000)->closeButton()->addSuccess('Cập nhật thành công');
            return redirect()->back();
        }
        // Nếu không tìm thấy người dùng, trả về lỗi 404 hoặc thông báo khác
        return redirect()->back()->withErrors('User not found');
    }

    public function view_feedback(){
        $data = Feedback::paginate(5);
        return view('admin.feedback',compact('data'));
    }

    public function update_feedback(Request $request, $id){
         // Tìm feedback theo ID
        $data = Feedback::find($id);

        if ($data) {
            // Cập nhật status thành 1 (Đang xử lý)
            $data->status = 1;
            $data->save();

            toastr()->success('Đã thay đổi trạng thái thành "Đang xử lý"');
        } else {
            toastr()->error('Không tìm thấy feedback');
        }

        // Quay lại trang feedbacks
        return redirect()->route('admin.feedback');
    }

    public function import(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);
    
        try {
            Excel::import(new ProductImport, $request->file('file'));
            return redirect()->back()->with('success', 'Import thành công');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Import thất bại: ' . $e->getMessage()]);
        }
    }

    public function importProduct(){
        return view('admin.import_product');
    }

    public function export(){
        return Excel::download(new ProductExport, 'products.xlsx');
    }

    public function upload(Request $request)
    {
       if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('media'), $fileName);

            $url = asset('media/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
    }

}
