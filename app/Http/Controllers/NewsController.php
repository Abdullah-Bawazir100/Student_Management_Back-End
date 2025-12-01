<?php

namespace App\Http\Controllers;

use App\Http\Requests\store_news_request;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all(); 

        if($news->isEmpty()){
            return response()->json('No News Exists .' , 200);
        }
        else{
        return response()->json($news , 200);
        }
    }

    // إنشاء خبر جديد (للمشرف فقط)
    public function store(store_news_request $request)
    {
        $validated = $request->validated();

        $newData = News::create(attributes:$validated);
        return response()->json([
            'success' => true,
            'data' => $newData,
            'message' => 'The New stored successfully'
        ], 201);
    }

    // حذف خبر
    public function destroy($id)
    {
       $newData = News::find($id);
    
        if(!$newData) {
            return response()->json([
                'success' => false,
                'message' => 'No New With id [' . $id . ']'
            ], 404);
        }
        
        $newData->delete();
        
        return response()->json([
            'data' => $newData,
            'success' => true,
            'message' => 'New deleted successfully.'
        ], 200);
    }
}
