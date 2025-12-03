<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use Carbon\Carbon;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'judul' => 'Sherlock Holmes: The Sign of Four',
                'penulis' => 'Sir Arthur Conan Doyle',
                'harga' => 50000,
                'tgl_terbit' => Carbon::parse('1890-02-01'),
            ],
            [
                'judul' => 'Sherlock Holmes: The Hound of Baskervilles',
                'penulis' => 'Sir Arthur Conan Doyle',
                'harga' => 65000,
                'tgl_terbit' => Carbon::parse('1902-04-01'),
            ],
            [
                'judul' => 'Sherlock Holmes: A Study in Scarlet',
                'penulis' => 'Sir Arthur Conan Doyle',
                'harga' => 45000,
                'tgl_terbit' => Carbon::parse('1887-11-01'),
            ],
            [
                'judul' => 'A Dance with Dragons',
                'penulis' => 'George R.R. Martin',
                'harga' => 125000,
                'tgl_terbit' => Carbon::parse('2011-07-12'),
            ],
            [
                'judul' => 'A Song of Ice and Fire',
                'penulis' => 'George R.R. Martin',
                'harga' => 110000,
                'tgl_terbit' => Carbon::parse('1996-08-01'),
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
