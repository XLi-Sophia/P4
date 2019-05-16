<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Student;

class FormController extends Controller
{
    // GET all students (welcome.blade.php)
    public function welcome()
    {
        # Get all the students from our database
        $students = Student::orderBy('last_name')->get();

        return view('welcome')->with([
            'students' => $students,
        ]);
    }

    /*
     * GET /books
     */
    public function index()
    {
        # Get all the students from our database
        $students = Student::orderBy('last_name')->get();

        # Query on the existing collection to get recently added students
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
        $student = Student::find($id);

        if (!$student) {
            return redirect('/students')->with(['alert' => 'Student not found']);
        }

        return view('students.show')->with([
            'student' => $student
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
            $searchResults = Student::whereRaw("BINARY `last_name`= ?", [$searchTerm])->get();
        } else {
            $searchResults = Student::where('last_name', $searchTerm)->get();
        }

        return redirect('/students/search')->with([
            'searchTerm' => $request->searchTerm,
            'caseSensitive' => $caseSensitive,
            'searchResults' => $searchResults
        ]);
    }

    /*
     * GET /students/create
     */
    public function create()
    {
        return view('students.create');
    /*
        $grade = Student::getForDropdown();

        $category = Category::getForCheckboxes();

        return view('students.create')->with([
            'grade' => $grade,
            'category' => $category
        ]);
    */
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
            'grade' => 'required|digits:1',
            'reading_level' => 'required',
            'fluency_level' => 'required|digits:3',
            'category' => 'required',
            'team' => 'required',
        ]);

        # Note: If validation fails, it will redirect the visitor back to
        # the form page and none of the code that follows will execute.

        $student = new Student();
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->grade = $request->grade;
        $student->reading_level = $request->reading_level;
        $student->fluency_level = $request->fluency_level;
        $student->category = $request->category;
        $student->team = $request->team;

        $student->save();

        # Note: Have to sync tags *after* the book has been saved so there's a book_id to store in the pivot table

        /*
        $student->tags()->sync($request->tags);
        */
        return redirect('/students/create')->with(['alert' => 'A new student ' . $student->last_name . ', ' . $student->first_name . ' was added.']);
    }

    /*
     * GET /books/{id}/edit
     */
    public function edit($id)
    {
        $student = Student::find($id);

        /*
        $authors = Author::getForDropdown();

        $tags = Tag::getForCheckboxes();

        $bookTags = $book->tags->pluck('id')->toArray();
    */
        if (!$student) {
            return redirect('/students')->with(['alert' => 'Book not found.']);
        }
        return view('students.edit')->with(['student' => $student]);
        /*
        return view('books.edit')->with([
            'book' => $book,
            'authors' => $authors,
            'tags' => $tags,
            'bookTags' => $bookTags,
        ]);
        */
    }

    /*
     * PUT /books/{id}
     */
    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->grade = $request->grade;
        $student->reading_level = $request->reading_level;
        $student->fluency_level = $request->fluency_level;
        $student->category = $request->category;
        $student->team = $request->team;

        /**$student->tags()->sync($request->tags);**/

        $student->save();

        return redirect('/students/' . $id . '/edit')->with(['alert' => 'Your changes were saved.']);
    }

    /*
    * Asks user to confirm they want to delete the book
    * GET /books/{id}/delete
    */
    public function delete($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return redirect('/students')->with(['alert' => 'Book not found']);
        }

        return view('students.delete')->with([
            'student' => $student,
        ]);
    }

    /*
    * Deletes the book
    * DELETE /books/{id}/delete
    */
    public function destroy($id)
    {
        $student = Student::find($id);

        /*$student->tags()->detach();*/

        $student->delete();

        return redirect('/')->with([
            'alert' => '“' . $student->last_name . ', ' . $student->first_name . '” was removed.'
        ]);
    }

    // helper email
    public function help()
    {
        return 'Need help? Email us at ' . config('mail.supportEmail');
    }
}
