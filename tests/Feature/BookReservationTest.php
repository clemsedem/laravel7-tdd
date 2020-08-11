<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Book;

class BookReservationTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added()
    {
        $this->withoutExceptionHandling();


        $response = $this->post('/books', [
            'title'=> 'Cool book title',
            'author' => 'Victor'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());

    }

    /** @test */
    public function title_require() 
    {
        // $this->withoutExceptionHandling();

         $response = $this->post('/books', [
            'title'=> '',
            'author' => 'Victor'
        ]);

        $response->assertSessionHasErrors('title');

    }

     /** @test */
    public function author_require() 
    {

         $response = $this->post('/books', [
            'title'=> 'New book',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');

    }



     /** @test */
    public function a_book_can_be_updated() 
    {
        $this->withoutExceptionHandling();

         $this->post('/books', [
            'title'=> 'New book',
            'author' => 'Victor'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' .$book->id,[
            'title'=> 'Updated title',
             'author' => 'New Author'
        ]);

        $this->assertEquals('Updated title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);

    }

}

