<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use IanLChapman\PigLatinTranslator\Parser;
use App\Student;
use App\Author;

class PracticeController extends Controller
{

    /**
     * Week 13: Demonstrating difference between using a relationship method as
     * a dynamic property vs. a method
     */
    public function practice20()
    {
        $book = Book::first();
        dump($book->tags);
        dump($book->tags());
    }

    /**
     * Week 13: Demonstrating querying a many to many relationship
     */
    public function practice19()
    {
        $books = Book::with('tags')->get();

        foreach ($books as $book) {
            dump($book->title);
            foreach ($book->tags as $tag) {
                dump($tag->name);
            }
        }
    }

    /**
     * Week 13: Demonstrating eager loading
     */
    public function practice18()
    {
        $books = Book::with('author')->get();

        foreach ($books as $book) {
            dump('The book ' . $book->title . ' was authored by ' . $book->author->first_name . ' ' . $book->author->last_name);
        }
    }

    /**
     * Week 13: Demonstrating using the one-to-many relationship method via a dynamic property
     */
    public function practice17()
    {
        $book = Book::first();

        $author = $book->author;

        dump($author->toArray());
    }

    /**
     * Week 13: Demonstrating "create" with a one-to-many relationship
     */
    public function practice16()
    {
        $author = Author::where('first_name', '=', 'J.K.')->first();

        $book = new Book();
        $book->title = "Fantastic Beasts and Where to Find Them";
        $book->published_year = 2017;
        $book->cover_url = 'http://prodimage.images-bn.com/pimages/9781338132311_p0_v2_s192x300.jpg';
        $book->purchase_url = 'http://www.barnesandnoble.com/w/fantastic-beasts-and-where-to-find-them-j-k-rowling/1004478855';
        $book->author()->associate($author); # <--- Associate the author with this book
        #$book->author_id = $author->id;
        $book->save();
        dump($book->toArray());
    }

    /**
     *
     */
    public function practice15()
    {
        $books = Book::all();
        dump($books->toArray());
    }

    /**
     * [6 of 6] Solution to query practice from Week 11 assignment
     * Remove any/all books with an author name that includes the string “Rowling”.
     */
    public function practice14()
    {
        # Show books before we do the delete
        Book::dump();

        # Do the delete
        Book::where('author', 'LIKE', '%Rowling%')->delete();
        dump('Deleted all books where author %Rowling%');

        # Show books after the delete
        Book::dump();
        # Underlying SQL: delete from `books` where `author` LIKE '%Rowling%'
    }

    /**
     * [5 of 6] Solution to query practice from Week 11 assignment
     * Find any books by the author “J.K. Rowling” and update the author name to be “JK Rowling”.
     */
    public function practice13()
    {
        Book::dump();

        # Approach # 1
        # Get all the books that match the criteria
//        $books = Book::where('author', '=', 'J.K. Rowling')->get();
//
//        $matches = $books->count();
//        dump('Found ' . $matches . ' ' . str_plural('book', $matches) . ' that match this search criteria');
//
//        if ($matches > 0) {
//            # Loop through each book and update them
//            foreach ($books as $book) {
//                $book->author = 'JK Rowling';
//                $book->save();
//                # Underlying SQL: update `books` set `updated_at` = '20XX-XX-XX XX:XX:XX', `author` = 'JK Rowling' where `id` = '4'
//            }
//        }

        # Approach #2
        # More ideal - Requires 1 query instead of 3
        Book::where('author', '=', 'J.K. Rowling')->update(['author' => 'JK Rowling']);

        Book::dump();
    }

    /**
     * [4 of 6] Solution to query practice from Week 11 assignment
     * Retrieve all the books in descending order according to published date
     */
    public function practice12()
    {
        $books = Book::orderByDesc('published_year')->get();
        Book::dump($books);
        # Underlying SQL: select * from `books` order by `published_year` desc
    }

    /**
     * [3 of 6] Solution to query practice from Week 11 assignment
     * Retrieve all the books in alphabetical order by title
     */
    public function practice11()
    {
        $books = Book::orderBy('title', 'asc')->get();
        Book::dump($books);
        # Underlying SQL: select * from `books` order by `title` asc
    }

    /**
     * [2 of 6] Solution to query practice from Week 11 assignment
     * Retrieve all the books published after 1950.
     */
    public function practice10()
    {
        $students = Student::where('last_name', '=', 'Affleck')->first();
        dump($students->last_name);
        dump($students);
        dump($students->toArray());
        dump($students->credits);
        echo $students;
        # Underlying SQL: select * from `books` where `published` > '1950'
    }

    /**
     * [1 of 6] Solution to query practice from Week 11 assignment
     * Retrieve the last 2 books that were added to the books table.
     */
    public function practice9()
    {
        $books = Book::orderBy('id', 'desc')->limit(2)->get();

        # Alternative approach using the `latest` convenience method:
        #$books = Book::latest()->limit(2)->get();

        Book::dump($books);
        # Underlying SQL: select * from `books` order by `id` desc limit 2
    }

    /**
     * Week 11 - DELETE example
     */
    public function practice8()
    {
        # First get a book to delete
        $student = Student::where('last_name', '=', 'Rowling')->first();

        if (!$student) {
            dump('Did not delete- Book not found.');
        } else {
            $student->delete();
            dump('Deletion complete; check the database to see if it worked...');
        }
    }

    /**
     * Week 11 - UPDATE example
     */
    public function practice7()
    {
        # First get a book to update
        $student = Student::where('last_name', '=', 'Rowling')->first();

        if (!$student) {
            dump("Student not found, can't update.");
        } else {
            # Change some properties
            $student->reading_level = '2.1';
            $student->fluency_level = '210';

            # Save the changes
            $student->save();

            dump('Update complete; check the database to confirm the update worked.');
        }
    }

    /*
     * Week 11 - READ example
     */
    public function practice6()
    {
        $student = new Student();
        $students = $student->where('first_name', 'LIKE', '%Harry%')->get();

        if ($students->isEmpty()) {
            dump('No matches found');
        } else {
            foreach ($students as $student) {
                dump($student->first_name);
            }
        }
    }

    /*
     * Week 11 - CREATE example
     */
    public function practice5()
    {
        $student = new Student();
        # Set the properties
        # Note how each property corresponds to a field in the table
        $student->first_name = 'Harry';
        $student->last_name = 'Rowling';
        $student->grade = 5;
        $student->reading_level = '1.2';
        $student->fluency_level = '180';
        $student->category = 'ESL';
        $student->team = 'Cat';

        $student->save();

        dump($student->toArray());
    }

    /**
     * Example for Bret
     * https://github.com/susanBuck/dwa15-spring2019/issues/35
     */
    public function practice4()
    {
        return view('practice.practice4')->with(['day' => 'tue']);
    }

    /**
     *
     */
    public function practice3()
    {
        $translator = new Parser();
        $translation = $translator->translate('Hello World');
        dump($translation);
    }

    /**
     *
     */
    public function practice2()
    {
        return 'Need help? Email us at ' . config('mail.supportEmail');
    }

    /**
     * Demonstrating the first practice example
     */
    public function practice1()
    {
        dump('This is the first example.');
    }

    /**
     * ANY (GET/POST/PUT/DELETE)
     * /practice/{n?}
     * This method accepts all requests to /practice/ and
     * invokes the appropriate method.
     * http://foobooks.loc/practice => Shows a listing of all practice routes
     * http://foobooks.loc/practice/1 => Invokes practice1
     * http://foobooks.loc/practice/5 => Invokes practice5
     * http://foobooks.loc/practice/999 => 404 not found
     */
    public function index($n = null)
    {
        $methods = [];

        # Load the requested `practiceN` method
        if (!is_null($n)) {
            $method = 'practice' . $n; # practice1

            # Invoke the requested method if it exists; if not, throw a 404 error
            return (method_exists($this, $method)) ? $this->$method() : abort(404);
        } # If no `n` is specified, show index of all available methods
        else {
            # Build an array of all methods in this class that start with `practice`
            foreach (get_class_methods($this) as $method) {
                if (strstr($method, 'practice')) {
                    $methods[] = $method;
                }
            }

            # Load the view and pass it the array of methods
            return view('practice')->with(['methods' => $methods]);
        }
    }
}
