<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\News;
use App\Models\User;


class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display icons page
     *
     * @return \Illuminate\View\View
     */
    public function icons()
    {
        return view('pages.icons');
    }

    /**
     * Display maps page
     *
     * @return \Illuminate\View\View
     */
    public function maps()
    {
        return view('pages.maps');
    }

    public function index()
    {        
        return view('news.index', [ 'news' => News::where('user_id', Auth::id())->get() ]);
    }

    public function create()
    {        
        return view('news.create');
    }

    public function store(Request $request) {       
        
        $news = new News([
            'title' => $request->get('title'),
            'lead' => $request->get('lead'),
            'image' => 'https://image.freepik.com/fotos-gratis/tres-jovens-sorrindo-hipster-mulheres-em-roupas-de-verao-garotas-tirando-fotos-de-auto-retrato-de-selfie-em-smartphone-modelos-posando-na-rua-feminino-mostrando-emocoes-de-rosto-positivo_158538-6901.jpg',
            'body' => $request->get('body'),
            'user_id' => Auth::id(),
        ]);
        $news->save();
        return redirect('noticias');
        //echo(2);
    }

    public function edit($id) {   
        return view('news.edit', [ 'news' => News::where('id', $id)->first() ]);
    }

    public function update($id) {   
        $news = new News([
            'title' => $request->get('title'),
            'lead' => $request->get('lead'),
            'image' => 'https://image.freepik.com/fotos-gratis/tres-jovens-sorrindo-hipster-mulheres-em-roupas-de-verao-garotas-tirando-fotos-de-auto-retrato-de-selfie-em-smartphone-modelos-posando-na-rua-feminino-mostrando-emocoes-de-rosto-positivo_158538-6901.jpg',
            'body' => $request->get('body'),
            'user_id' => Auth::id(),
        ]);
        $news->save();

        return redirect('noticias');
    }

    public function delete($id) {
        // Noticia
        $news = News::findOrFail($id);

        // Exclui a noticia
        $news->delete();

        // Retorna com a mensagem
        return redirect('noticias');
    }

    public function search(Request $request) {

        $news = News::where([
            ['title','!=', Null],
            ['user_id','=', Auth::id()],
            [function ($query) use ($request) {
                if(($search = $request->search)) {
                    $query->orWhere('title', 'LIKE', '%'.$search.'%')->get();
                }
            }]
        ])
        ->orderBy("id","desc")
        ->paginate(10);

        return view('news.index', [ 'news' => $news ]);
    }

    public function users(Request $request) {
        return view('users.users', [ 'users' => User::get() ]);
    }

}
