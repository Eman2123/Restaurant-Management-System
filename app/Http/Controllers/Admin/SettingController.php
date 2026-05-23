<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'restaurant_name'    => Setting::get('restaurant_name',
                                    'The Restaurant'),
            'restaurant_email'   => Setting::get('restaurant_email',
                                    'info@restaurant.com'),
            'restaurant_phone'   => Setting::get('restaurant_phone',
                                    '+92 300 1234567'),
            'restaurant_address' => Setting::get('restaurant_address',
                                    '123 Main Street, Karachi'),
            'restaurant_hours'   => Setting::get('restaurant_hours',
                                    'Daily: 12:00 PM - 11:00 PM'),
            'currency'           => Setting::get('currency', 'Rs.'),
            'tax_percentage'     => Setting::get('tax_percentage', '0'),
            'min_order_amount'   => Setting::get('min_order_amount', '0'),
            'delivery_charges'   => Setting::get('delivery_charges', '0'),
            'facebook_url'       => Setting::get('facebook_url', '#'),
            'instagram_url'      => Setting::get('instagram_url', '#'),
            'twitter_url'        => Setting::get('twitter_url', '#'),
            'whatsapp_number'    => Setting::get('whatsapp_number', ''),
            'about_text'         => Setting::get('about_text',
                                    'We believe that dining is not just about food.'),
            'maintenance_mode'   => Setting::get('maintenance_mode', '0'),
            'allow_reservations' => Setting::get('allow_reservations', '1'),
            'allow_orders'       => Setting::get('allow_orders', '1'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'restaurant_name'    => 'required|string|max:255',
            'restaurant_email'   => 'required|email',
            'restaurant_phone'   => 'required|string|max:20',
            'restaurant_address' => 'required|string|max:500',
            'restaurant_hours'   => 'nullable|string|max:255',
            'currency'           => 'required|string|max:10',
            'tax_percentage'     => 'nullable|numeric|min:0|max:100',
            'min_order_amount'   => 'nullable|numeric|min:0',
            'delivery_charges'   => 'nullable|numeric|min:0',
            'facebook_url'       => 'nullable|url',
            'instagram_url'      => 'nullable|url',
            'twitter_url'        => 'nullable|url',
            'whatsapp_number'    => 'nullable|string|max:20',
            'about_text'         => 'nullable|string|max:1000',
        ]);

        $keys = [
            'restaurant_name', 'restaurant_email', 'restaurant_phone',
            'restaurant_address', 'restaurant_hours', 'currency',
            'tax_percentage', 'min_order_amount', 'delivery_charges',
            'facebook_url', 'instagram_url', 'twitter_url',
            'whatsapp_number', 'about_text',
        ];

        foreach ($keys as $key) {
            Setting::set($key, $request->$key);
        }

        // Toggle settings
        Setting::set('maintenance_mode',
            $request->has('maintenance_mode') ? '1' : '0');
        Setting::set('allow_reservations',
            $request->has('allow_reservations') ? '1' : '0');
        Setting::set('allow_orders',
            $request->has('allow_orders') ? '1' : '0');

        return back()->with('success',
            'Settings saved successfully!');
    }
}