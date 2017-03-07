<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Markdown;
use Validator;
use App\Article;
use Auth;
use App\Tag;
use Redirect;

class ArticleController extends Controller
{
    public function __construct()
    {
        //限登陆用户操作，且只能操作以下方法
        $this->middleware('auth', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
        $this->middleware('canOperation',['only'=>'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //发布文章视图
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    //保存文章
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:100',
            'content' => 'required',
            'tags' => ['required', 'regex:/^\w+$|^(\w+,)+\w+$/'],
        ];
        //数据校验
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $article = Article::create($request->only('title', 'content'));
            $article->user_id = Auth::id();
            $resolved_content = Markdown::parse($request->input('content'));
            $article->resolved_content = $resolved_content;
            $tags = explode(',', $request->input('tags'));
            //添加 summary
            if (str_contains($resolved_content, '<p>')) {
                $start = strpos($resolved_content, '<p>');
                $length = strpos($resolved_content, '</p>') - $start - 4;
                $article->summary = substr($resolved_content, $start + 3, $length);
            } else if (str_contains($resolved_content, '</h')) {
                $start = strpos($resolved_content, '<h>');
                $length = strpos($resolved_content, '</h>') - $start - 4;
                $article->summary = substr($resolved_content, $start + 4, $length);
            }
            $article->save();
            //处理标签
            foreach ($tags as $tagName) {
                $tag = Tag::whereName($tagName)->first();
                if (!$tag) {
                    $tag = Tag::create(array('name' => $tagName));
                }
                $tag->count++;
                $article->tags()->save($tag);
            }
            return Redirect::route('article.show', $article->id);
        } else {
            return Redirect::route('article.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    //展示文章详情
    public function show($id)
    {
        return view('articles.show')->with('article', Article::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function preview(Request $request)
    {
        return Markdown::parse($request->input('content'));
    }
}
