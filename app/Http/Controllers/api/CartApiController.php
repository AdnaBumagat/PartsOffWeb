<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Province;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartApiController extends Controller
{
    //* Add to cart
    public function addToCart(Request $request)
    {
        $product = Product::with('product_images')->find($request->id);

        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Record not Found'
            ], 404);
        }

        if (Cart::count() > 0) {
            //* echo "Product already in cart";
            //* Product found in cart
            //* check if this product already in the cart
            //* Return as message that product already added in cart
            //* if product not found in the cart, then add product in cart

            $cartContent = Cart::content();
            $productAlreadyExist = false;

            foreach ($cartContent as $item) {
                if ($item->id == $product->id) {
                    $productAlreadyExist = true;
                }
            }

            if ($productAlreadyExist == false) {
                Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']);

                $status = true;
                $message = $product->title . ' added in your cart succesfully.';
            } else {
                $status = false;
                $message = $product->title . ' already added in cart';
            }
        } else {
            Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']);
            $status = true;
            $message = $product->title . ' added in your cart succesfully.';
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function cart()
    {
        $cartContent = Cart::content();
        return response()->json($cartContent);
    }

    public function updateCart(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;

        $itemInfo = Cart::get($rowId);

        $product = Product::find($itemInfo->id);
        //* check qty available in stock

        if ($product->track_qty == 'Yes') {
            if ($qty <= $product->qty) {
                Cart::update($rowId, $qty);
                $message = 'Cart updated successfully';
                $status = true;
            } else {
                $message = 'Requested quantity(' . $qty . ') not available in stock';
                $status = false;
            }
        } else {
            Cart::update($rowId, $qty);
            $message = 'Cart updated successfully';
            $status = true;
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function deleteItem(Request $request)
    {

        $itemInfo = Cart::get($request->rowId);

        if ($itemInfo == null) {
            $errorMessage = 'Item not found in cart';

            return response()->json([
                'status' => false,
                'message' => $errorMessage
            ], 404);
        }
        Cart::remove($request->rowId);
        $message = 'Item removed from cart successfully';

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function checkout()
    {

        //-- if cart is empty redirect to cart page
        if (Cart::count() == 0) {
            return response()->json([
                "message" => "cart is empty"
            ]);
        }

        $customerAddress = CustomerAddress::where('user_id', Auth::user()->id)->first();

        $provinces = Province::orderBy('name', 'ASC')->get();

        return response()->json([
            'provinces' => $provinces,
            '$customerAddress' => $customerAddress
        ]);
    }


    public function processCheckout(Request $request)
    {

        //Apply Validition

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'first_name' => 'required|min:3',
            'last_name' => 'required',
            'email' => 'required|email',
            'province' => 'required',
            'address' => 'required|min:5',
            'city' => 'required',
            'barangay' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
            'subtotal' => 'required',
            'grand_total' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fix the errors',
                'status' => false,
                'errors' => $validator->errors()
            ], 401);
        }

        CustomerAddress::updateOrCreate(
            ['user_id' => $request->id],
            [
                'user_id' => $request->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'province_id' => $request->province,
                'address' => $request->address,
                'city' => $request->city,
                'barangay' => $request->barangay,
                'zip' => $request->zip,
            ]
        );

        //Store Data in orders table

        $order = new Order;
        $order->subtotal = $request->subtotal;
        $order->grand_total = $request->grand_total;
        $order->payment_status = 'not paid';
        $order->status = 'pending';
        $order->user_id = $request->id;

        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->email = $request->email;
        $order->mobile = $request->mobile;
        $order->address = $request->address;
        $order->barangay = $request->barangay;
        $order->city = $request->city;
        $order->zip = $request->zip;
        $order->province_id = $request->province;
        $order->save();

        //store order items in order items table
        foreach ($request->order_items as $item) {
            $productData = Product::find($item['product_id']);

            $orderItem = new OrderItem;
            $orderItem->product_id = $item['product_id'];
            $orderItem->order_id = $order->id;
            $orderItem->name = $productData->title;
            $orderItem->qty = $item['qty'];
            $orderItem->price = $productData->price;
            $orderItem->total = $productData->price * $item['qty'];
            $orderItem->save();

            //Update Product Stock

            if ($productData->track_qty == 'Yes') {

                $currentQty = $productData->qty;
                $updatedQty = $currentQty - $item['qty'];
                $productData->qty = $updatedQty;
                $productData->save();
            }
        }

        return response()->json([
            'message' => 'Order saved succesfully',
            'orderId' => $order->id,
            'status' => true,
        ], 200);
    }
}
