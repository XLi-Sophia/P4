<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    /*
     * GET /books
     */
    public function index()
    {
        # Get all the books from our library
        $students = P4::with('grade')->orderBy('last_name')->get();

        # Query on the existing collection to get our recently added books
        $newStudents = $students->sortByDesc('created_at')->take(3);

        return view('students.index')->with([
            'students' => $students,
            'newStudents' => $newStudents,
        ]);
    }

    /*
     * GET /books/{id}
     */
    public function show($id)
    {
        $book = P4::with('author')->find($id);

        if (!$book) {
            return redirect('/books')->with(['alert' => 'Book not found']);
        }

        return view('books.show')->with([
            'book' => $book
        ]);
    }

    /*
     * GET /books/search
     */
    public function search(Request $request)
    {
        $searchTerm = $request->session()->get('searchTerm', '');
        $caseSensitive = $request->session()->get('caseSensitive', false);
        $searchResults = $request->session()->get('searchResults', null);

        return view('students.search')->with([
            'searchTerm' => $searchTerm,
            'caseSensitive' => $caseSensitive,
            'searchResults' => $searchResults,
        ]);
    }

    /**
     * GET /books/search-process
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function searchProcess(Request $request)
    {
        $request->validate([
            'searchTerm' => 'required'
        ]);

        $searchTerm = $request->searchTerm;
        $caseSensitive = $request->has('caseSensitive');

        if ($caseSensitive) {
            # Ref: https://stackoverflow.com/questions/25494849/case-sensitive-where-statement-in-laravel
            $searchResults = P4::whereRaw("BINARY `grade`= ?", [$searchTerm])->get();
        } else {
            $searchResults = P4::where('grade', $searchTerm)->get();
        }

        return redirect('/students/search')->with([
            'searchTerm' => $request->searchTerm,
            'caseSensitive' => $caseSensitive,
            'searchResults' => $searchResults
        ]);
    }

    /*
     * GET /books/create
     */
    public function create()
    {
        $grade = Grade::getForDropdown();

        $category = Category::getForCheckboxes();

        return view('students.create')->with([
            'grade' => $grade,
            'category' => $category
        ]);
    }

    /*
     * POST /students
     */
    public function store(Request $request)
    {
        # Validate the request data
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'author_id' => 'required',
            'grade' => 'required|digits:1',
            'reading_level' => 'required|decimal:2,1',
            'fluency_level' => 'required|digits:3',
            'category' => 'required',
            'team' => 'required',
        ]);

        # Note: If validation fails, it will redirect the visitor back to the form page
        # and none of the code that follows will execute.

        $book = new Book();
        $book->title = $request->title;
        $book->author_id = $request->author_id;
        $book->published_year = $request->published_year;
        $book->cover_url = $request->cover_url;
        $book->purchase_url = $request->purchase_url;
        $book->save();

        # Note: Have to sync tags *after* the book has been saved so there's a book_id to store in the pivot table
        $book->tags()->sync($request->tags);

        return redirect('/students/create')->with(['alert' => 'The book ' . $book->title . ' was added.']);
    }

    /*
     * GET /books/{id}/edit
     */
    public function edit($id)
    {
        $book = Book::find($id);

        $authors = Author::getForDropdown();

        $tags = Tag::getForCheckboxes();

        $bookTags = $book->tags->pluck('id')->toArray();

        if (!$book) {
            return redirect('/books')->with(['alert' => 'Book not found.']);
        }

        return view('books.edit')->with([
            'book' => $book,
            'authors' => $authors,
            'tags' => $tags,
            'bookTags' => $bookTags,
        ]);
    }

    /*
     * PUT /books/{id}
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        $book->title = $request->title;
        $book->author_id = $request->author_id;
        $book->published_year = $request->published_year;
        $book->cover_url = $request->cover_url;
        $book->purchase_url = $request->purchase_url;
        $book->tags()->sync($request->tags);

        $book->save();

        return redirect('/books/' . $id . '/edit')->with(['alert' => 'Your changes were saved.']);
    }

    /*
    * Asks user to confirm they want to delete the book
    * GET /books/{id}/delete
    */
    public function delete($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return redirect('/books')->with(['alert' => 'Book not found']);
        }

        return view('books.delete')->with([
            'book' => $book,
        ]);
    }

    /*
    * Deletes the book
    * DELETE /books/{id}/delete
    */
    public function destroy($id)
    {
        $book = Book::find($id);

        $book->tags()->detach();

        $book->delete();

        return redirect('/books')->with([
            'alert' => '“' . $book->title . '” was removed.'
        ]);
    }

    // helper email
    public function help()
    {
        return 'Need help? Email us at ' . config('mail.supportEmail');
    }
}
