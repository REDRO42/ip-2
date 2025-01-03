<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'save_address' => 'sometimes|boolean',
            'is_default' => 'sometimes|boolean'
        ]);

        $addressData = [
            'title' => $request->title,
            'address' => $request->address,
            'city' => $request->city,
            'district' => $request->district,
            'phone' => $request->phone
        ];

        
        if ($request->save_address) {
            $isDefault = $request->is_default || !Address::where('user_id', Auth::id())->exists();
            
            if ($isDefault) {
                
                Address::where('user_id', Auth::id())->update(['is_default' => false]);
            }

           
            $address = new Address($addressData);
            $address->user_id = Auth::id();
            $address->is_default = $isDefault;
            $address->save();

            Session::flash('success', 'Adres başarıyla kaydedildi ve seçildi.');
        } else {
            // Adres kaydedilmek istenmiyorsa, geçici olarak session'da tut
            Session::put('temp_address', $addressData);
            Session::flash('success', 'Adres geçici olarak kaydedildi.');
        }

        return back();
    }

    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403, 'Bu adres size ait değil.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'phone' => 'required|string|max:255'
        ]);

        $address->update($request->only([
            'title', 'address', 'city', 'district', 'phone'
        ]));

        return back()->with('success', 'Adres başarıyla güncellendi.');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403, 'Bu adres size ait değil.');
        }

        $address->delete();

        return back()->with('success', 'Adres başarıyla silindi.');
    }

    public function setDefault(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403, 'Bu adres size ait değil.');
        }

      
        Address::where('user_id', Auth::id())->update(['is_default' => false]);
        
      
        $address->update(['is_default' => true]);

        return back()->with('success', 'Varsayılan adres güncellendi.');
    }
}
