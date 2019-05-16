<?php

/*
 * Misc "static" pages
 */
Route::view('/', 'welcome');
Route::view('/about', 'about');
Route::view('/contact', 'contact');

Route::view('/students', 'book');

/*
 * welcome page
 */
Route::get('/', 'FormController@welcome');

/*
 * Students
 */
Route::get('/students/create', 'FormController@create');
Route::post('/students', 'FormController@store');

# Show the search form
Route::get('/students/search', 'FormController@search');

# Processing the search form
Route::get('/students/search-process', 'FormController@searchProcess');

Route::get('/students', 'FormController@index');
Route::get('/students/{id}', 'FormController@show');

# Update functionality
# Show the form to edit a specific book
Route::get('/students/{id}/edit', 'FormController@edit');

# Process the form to edit a specific book
Route::put('/students/{id}', 'FormController@update');

# DELETE
# Show the page to confirm deletion of a book
Route::get('/students/{id}/delete', 'FormController@delete');

# Process the deletion of a book
Route::delete('/students/{id}', 'FormController@destroy');


/**
 * Practice
 */
Route::any('/practice/{n?}', 'PracticeController@index');


# Example routes from the discussion of P3 development (Week 6, Part 8 video)
//Route::get('/', 'TriviaController@index');
//Route::get('/check-answer', 'TriviaController@checkAnswer');