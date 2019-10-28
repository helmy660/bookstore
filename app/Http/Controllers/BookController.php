<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use App\UserBook ; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use View;
use DB;
class BookController extends Controller
{

    private $paginateValue=4;

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('checkroll')->only(['index','create','store','edit','update','destroy']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();

        return view('admin.books', compact('books'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create',compact('categories' , $categories));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'book_name'=>'required',
            'author'=>'required',
            'book_image'=>'required',
            'price'=>'required',
            'copies_num'=>'required'
        ]);
        
        if ($request->hasFile('book_image')) {
            if($request->file('book_image')->isValid()) {
                try {
                    
                    $image = 'data:image/' . $request->file('book_image')->getClientOriginalExtension()  . ';base64,' . base64_encode(file_get_contents($request->file('book_image')));
                    $book = new Book([
                        'book_name' => $request->get('book_name'),
                        'author' => $request->get('author'),
                        "book_image" => $image,
                        "category_id" => $request->get('category'),
                        "description" => $request->get('description'),
                        "rate" => 0,
                        "copies_num" => $request->get('copies_num'),
                        "price" => $request->get('price')
                        ]);
            
                    $book->save();
            
                    return redirect('books')->with('success', 'Book saved successfully!');
                } 
                catch (FileNotFoundException $e) {
                    return redirect('/books/create')->withErrors('Book Image not saved')->withInput();
                }
            }
            else{
                return redirect('/books/create')->withErrors('Image not valid')->withInput();
            }
        }else{
            return redirect('/books/create')->withErrors('Image not found')->withInput();

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        // $comments = App\Post::find(1)->comments ;
        // $this->authorize('view',$book) ; 

               $book = Book::find($id);
               $relatedBooks = Book::where('category_id','=',$book->category_id)->where('id','!=',$book->id)->get() ; 
               $this->authorize('view',$book) ; 
               $user_id = auth()->user()->id  ;
               $relations = [ 
                'book_id'=> $book->id ,
                'user_id'=>$user_id , 
                'leased'=> 0 , 
                'favourite'=> 0 , 
                'rate' => 0
                   ] ;
                   $relations = json_encode($relations) ;
                   $relations = json_decode($relations) ; 

               $rel = UserBook::where('user_id','=',$user_id)->where('book_id','=',$book->id)->get() ; 
                
               if (sizeof($rel)>0)
                $relations = $rel[0] ; 

        return view('books.show', compact('book' , 'relations','relatedBooks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('admin.books.edit',['categories' => $categories,'book'=>$book]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'book_name' => [
                'required',
                Rule::unique('books','book_name')->ignore($book->id),
            ],
            'category'=>['required'],
            'copies_num'=>['required'],
            'author'=>['required'],
            'price'=>['required'],
            'description'=>['required'],
        ]);

        if ($validator->fails()) {
            return redirect('books/'. $book->id .'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        if ($request->hasFile('book_image')) {
            if($request->file('book_image')->isValid()) {
                try {
                    
                    $image = 'data:image/' . $request->file('book_image')->getClientOriginalExtension()  . ';base64,' . base64_encode(file_get_contents($request->file('book_image')));
                    $book->book_image = $image;
                } catch (FileNotFoundException $e) {
                    return redirect('books/'. $book->id .'/edit')->withErrors('Book Image not saved')->withInput();
    
                }
            }else{
                
                return redirect('books/'. $book->id .'/edit')->withErrors('Image not valid')->withInput();

            }
        }        

        $book->book_name =  $request->get('book_name');
        $book->category_id = $request->get('category');
        $book->description = $request->get('description');
        $book->author = $request->get('author');
        $book->copies_num = $request->get('copies_num');
        $book->price = $request->get('price');

        $book->save();

        return redirect('books')->with('success', 'Book Edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {

        $book->delete();
        return redirect('books')->with('success', 'Book deleted!');
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------
    //All books functions in navbar
    public function getallBooks(Request $request,$order_by)
    {
               $categories = Category::all();

               if ($order_by==1)
                     $books=DB::table('books')->leftJoin('user_books', 'books.id', '=', 'user_books.book_id')->select('books.*','user_books.leased','user_books.favourite')->orderBy('books.rate', 'DESC')->paginate($this->paginateValue);
                    
                else if($order_by==2)
                    $books=DB::table('books')->leftJoin('user_books', 'books.id', '=', 'user_books.book_id')->select('books.*','user_books.leased','user_books.favourite')->orderBy('books.created_at', 'DESC')->paginate($this->paginateValue);
                 else
                    $books=DB::table('books')->leftJoin('user_books', 'books.id', '=', 'user_books.book_id')->select('books.*','user_books.leased','user_books.favourite')->paginate($this->paginateValue);
               $view = View::make('user');
                return $view->with('books', $books)->with('categories',$categories)->with('current_cat',0)->with('filterMode','allBooks')->with('order_by',$order_by);
    }

    public function getCategoryBooks(Request $request, $cat_id,$order_by){
        
        if ($order_by==1)
            $books=DB::table('books')->leftJoin('user_books', 'books.id', '=', 'user_books.book_id')->select('books.*','user_books.leased','user_books.favourite')->where('books.category_id', '=', $cat_id)->orderBy('books.rate', 'DESC')->paginate($this->paginateValue);
        else if($order_by==2)
            $books=DB::table('books')->leftJoin('user_books', 'books.id', '=', 'user_books.book_id')->select('books.*','user_books.leased','user_books.favourite')->where('books.category_id', '=', $cat_id)->orderBy('books.created_at', 'DESC')->paginate($this->paginateValue);
        else
            $books=DB::table('books')->leftJoin('user_books', 'books.id', '=', 'user_books.book_id')->select('books.*','user_books.leased','user_books.favourite')->where('books.category_id', '=', $cat_id)->paginate($this->paginateValue);
        $categories = Category::all();
        
        return view('user')->with('books', $books)->with('categories',$categories)->with('current_cat',$cat_id)->with('filterMode','allBooks')->with('order_by',$order_by);
    }
    //-------------------------------------------------------------------------------------------------------------------------------------------------------

    // Leased Books functions in navbar
    public function getAllLeasedBooks(Request $request,$order_by)
    {
               $categories = Category::all();
               if ($order_by==1)
                    $books=$this->getUserBooksLeasedFavourite('leased')->orderBy('rate', 'DESC')->paginate($this->paginateValue);
                else if($order_by==2)
                    $books=$this->getUserBooksLeasedFavourite('leased')->orderBy('books.created_at', 'DESC')->paginate($this->paginateValue);
                else
                    $books=$this->getUserBooksLeasedFavourite('leased')->paginate($this->paginateValue);
               $view = View::make('user');
                return $view->with('books', $books)->with('categories',$categories)->with('current_cat',0)->with('filterMode','leasedBooks')->with('order_by',$order_by);
    }

    public function getLeasedBooksByCat(Request $request, $cat_id,$order_by){
        if ($order_by==1)
            $books=$this->getUserBooksLeasedFavourite('leased')->where('category_id', '=', $cat_id)->orderBy('rate', 'DESC')->paginate($this->paginateValue);

        else if($order_by==2)
            $books=$this->getUserBooksLeasedFavourite('leased')->where('category_id', '=', $cat_id)->orderBy('books.created_at', 'DESC')->paginate($this->paginateValue);
        else
            $books=$this->getUserBooksLeasedFavourite('leased')->where('category_id', '=', $cat_id)->paginate($this->paginateValue);
        $categories = Category::all();
        
        return view('user')->with('books', $books)->with('categories',$categories)->with('current_cat',$cat_id)->with('filterMode','leasedBooks')->with('order_by',$order_by);
    }

//---------------------------------------------------------------------------------------------------------------------------------------------


// Favourite Books functions in navbar
public function getAllFavouriteBooks(Request $request,$order_by)
{
           $categories = Category::all();
           if ($order_by==1)
                $books=$this->getUserBooksLeasedFavourite('favourite')->orderBy('rate', 'DESC')->paginate($this->paginateValue);
            else if($order_by==2)
                $books=$this->getUserBooksLeasedFavourite('favourite')->orderBy('books.created_at', 'DESC')->paginate($this->paginateValue);
             else
                $books=$this->getUserBooksLeasedFavourite('favourite')->paginate($this->paginateValue);
           $view = View::make('user');
            return $view->with('books', $books)->with('categories',$categories)->with('current_cat',0)->with('filterMode','favBooks')->with('order_by',$order_by);
}

public function getFavouriteBooksByCat(Request $request, $cat_id,$order_by){
    if ($order_by==1)
        $books=$this->getUserBooksLeasedFavourite('favourite')->where('category_id', '=', $cat_id)->orderBy('rate', 'DESC')->paginate($this->paginateValue);

    else if($order_by==2)
        $books=$this->getUserBooksLeasedFavourite('favourite')->where('category_id', '=', $cat_id)->orderBy('books.created_at', 'DESC')->paginate($this->paginateValue);
    else
        $books=$this->getUserBooksLeasedFavourite('favourite')->where('category_id', '=', $cat_id)->paginate($this->paginateValue);
    $categories = Category::all();
    
    return view('user')->with('books', $books)->with('categories',$categories)->with('current_cat',$cat_id)->with('filterMode','favBooks')->with('order_by',$order_by);
}

    
public function getUserBooksLeasedFavourite($flag){
    $user_id=auth()->user()->id;
    $books=$books=DB::table('books')
    ->join('user_books', 'books.id', '=', 'user_books.book_id')
    ->select('books.*','user_books.leased','user_books.favourite')
    ->where('user_books.user_id','=',$user_id);
    if ($flag=='favourite')
        return $books->where('user_books.favourite','=',1);
    elseif ($flag=='leased')
        return $books->where('user_books.leased','=',1);
}

}


