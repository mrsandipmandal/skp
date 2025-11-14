<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\DeliveryPerson;
use App\Models\Signup;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;


class SetupController extends Controller
{

    /* Game Entry */

     public function Person_Entry(Request $request)
    {
        $page_title = "Person Entry";
        $Person = DeliveryPerson::paginate(10);
        $menus = session()->get("menu");
        $data = compact('page_title', 'menus', 'Person');
        return view('admin.person_entry')->with($data);
    }

     public function Person_Entrys(Request $request)
    {
        //return $request;
        // Validate the input data
        $request->validate([
             'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:255',
        ]);

         $eby = session()->get("username");

        // Start database transaction
        DB::beginTransaction();
        try {
            $err = false;

            $personExist = DeliveryPerson::where('name', $request->name)->where('mobile', $request->mobile)
                ->when($request->id != 0, function ($query) use ($request) {
                    return $query->where('id', '!=', $request->id);
                })
                ->exists();

            if ($personExist) {
                $err = true;
                return redirect()->back()
                    ->with('person_typ', 'error')
                    ->with('person_message', 'Delivery Person already exists.');
            }

            if ($err == false) {
                $dp = $request->id > 0 ? DeliveryPerson::find($request->id) : new DeliveryPerson();
                $dp->name = $request->name;
                $dp->mobile = $request->mobile;
                $dp->save();

                // Commit transaction after successful save
                DB::commit();
                $message = $request->id > 0 ? 'Delivery Person updated successfully.' : 'Delivery Person created successfully.';
                return redirect('/person-entry')
                    ->with('person_typ', 'success')
                    ->with('person_message', $message);
            }

        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollback();
            return redirect()->back()
                ->with('person_typ', 'error')
                ->with('person_message', 'Exception:404 Something went wrong!');
        }




       
   
    }
    public function Person_Status(Request $request)
    {
        $dp = DeliveryPerson::find($request->id);
        if ($dp) {
            $dp->stat = $request->stat;
            $dp->save();
            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Delivery Person not found.'], 404);
        }
        
    }
   public function Person_Edit(Request $request)
{
    // Removed the erroneous return $request; line
    if (empty($request->id)) {
        return response()->json(['message' => 'Something went wrong!'], 400);
    }
    
    $id = $request->id;
    $data = DeliveryPerson::find($id);
    
    if (!$data) {
        return response()->json(['message' => 'Person not found!'], 404);
    }
    
    return response()->json(['data' => $data]);
}


    public function CustomerList(Request $request)
    {
        $query = Signup::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                ;
            });
        }
      
        $users = $query->where('userlevel', '=', 10)->paginate(10)->appends($request->query()); // keep filters in pagination links
        $page_title = "Customer List";
        $menus = session()->get("menu");
        $data = compact('page_title', 'menus', 'users');
        return view('admin.customerlist')->with($data);
    }


}
