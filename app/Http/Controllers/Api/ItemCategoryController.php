<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ItemCategory;
use App\Models\User;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Exception;

class ItemCategoryController extends Controller
{
    // List all item categories
    public function index()
    {
        try {
            $categories = ItemCategory::all();
            return response()->json([
                'status' => true,
                'data' => $categories
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch item categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // View single category
    public function showbyuser(Request $request)
    {
        try {
            $id = $request->query('user_id');
            $category = ItemCategory::where('user_id',$id)->get();
            return response()->json([
                'status' => true,
                'data' => $category
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Item category not found',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch item category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Add new category
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_category_name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $category = ItemCategory::create($validator->validated());
            
              $user = User::find($category->user_id);

    // Log history if user exists
   if ($user) {
    
              $description = $user->name .' '. $category->item_category_name .' Item Category added  on ' . now()->toDateTimeString();
   

    History::create([
        'user_id' => $user->id,
        'description' => $description
    ]);
}
            return response()->json([
                'status' => true,
                'message' => 'Item category created successfully',
                'data' => $category
            ], 201);
            
                
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Database error: cannot create item category',
                'error' => $e->getMessage()
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create item category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Update category
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'item_category_name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $category = ItemCategory::findOrFail($id);
            $category->update($validator->validated());
            
              $user = User::find($category->user_id);

    // Log history if user exists
   if ($user) {
    
              $description = $user->name .' '. $category->item_category_name .' Item Category Updated On ' . now()->toDateTimeString();
   

    History::create([
        'user_id' => $user->id,
        'description' => $description
    ]);
}

            return response()->json([
                'status' => true,
                'message' => 'Item category updated successfully',
                'data' => $category
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Item category not found',
            ], 404);
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Database error: cannot update item category',
                'error' => $e->getMessage()
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update item category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Delete category
    public function destroy($id)
    {
        try {
            $category = ItemCategory::findOrFail($id);
            $category->delete();

 $user = User::find($category->user_id);

    // Log history if user exists
   if ($user) {
    
              $description = $user->name .' '. $category->item_category_name .' Item Category Deleted On ' . now()->toDateTimeString();
   

    History::create([
        'user_id' => $user->id,
        'description' => $description
    ]);
} 
            return response()->json([
                'status' => true,
                'message' => 'Item category deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Item category not found',
            ], 404);
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Database error: cannot delete item category',
                'error' => $e->getMessage()
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete item category',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
