<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;

class BookApiController extends Controller
{
    public function index() {
        $books = Book::latest()->paginate(5);

        return new BookResource(true, 'List Data Buku', $books);
    }
}
