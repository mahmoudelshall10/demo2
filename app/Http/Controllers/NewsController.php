<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_news = News::withTrashed()->orderBy('id','asc')->get();
        $all_news_trashed = News::onlyTrashed()->orderBy('id','asc')->get();
        return view('news',compact('all_news','all_news_trashed'));
    }

    public function create(){
        return view('data');
    }

    public function store(Request $request){
        $attribute = 
        [
            'title' => trans('admin.title'),
            'desc'  => trans('admin.desc'),
            'body'  => trans('admin.body'),
            'addby' => trans('admin.title'),
        ];
        
        $data = $this->validate(request(),[
            'title' => 'required|string',
            'desc'  => 'required|string',
            'body'  => 'required|string',
            'addby' => 'required|numeric',
        ], [], $attribute);
        News::create($data);
        return redirect('admin/news');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function delete($id=null)
    {
        if($id != null){
            $del = News::find($id);
            $del->delete();
        }else if(request()->has('restore') and request()->has('id')){

            News::whereIn('id',request('id'))->restore();

        }else if(request()->has('forcedelete') and request()->has('id')){

            News::whereIn('id',request('id'))->forceDelete();
            
        }else if(request()->has('softdelete') and request()->has('id')){

            News::destroy(request('id'));
        }
        return redirect('admin/news');
    }


}
