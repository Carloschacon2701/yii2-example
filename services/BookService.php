<?php

namespace App\Services;

use app\models\Book;
use app\models\Author;

class BookService
{

    public $bookModel;
    public $authorModel;

    function __construct()
    {
        $this->bookModel = new Book();
        $this->authorModel = new Author();
    }

    public function getAllBooks()
    {
        return $this->bookModel->find()->all();
    }

    public function getBookById($id)
    {
        return $this->bookModel->find()->where(['id' => $id])->one();
    }

    public function createBook($data)
    {
        $existingBook = $this->bookModel->find()->andFilterWhere([
            ['title' => $data['title']],
            ['author_id' => $data['author_id']]
        ])->one();

        if ($existingBook) {
            return [
                'status' => 'error',
                'message' => 'Book already exists'
            ];
        }

        $author = $this->authorModel->find()->where(['id' => $data['author_id']])->one();
        if (!$author) {
            return [
                'status' => 'error',
                'message' => 'Author not found'
            ];
        }

        $this->bookModel->load($data, '');
        $newBook = $this->bookModel->save();

        if (!$newBook) {
            return [
                'status' => 'error',
                'message' => 'Failed to create book',
                'errors' => $this->bookModel->getErrors()
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Book created successfully',
            'data' => $this->bookModel
        ];
    }

    public function updateBook($id, $data)
    {
        $book = $this->getBookById($id);
        if (!$book) {
            return [
                'status' => 'error',
                'message' => 'Book not found'
            ];
        }

        $author = $this->authorModel->find()->where(['id' => $data['author_id']])->one();
        if (!$author) {
            return [
                'status' => 'error',
                'message' => 'Author not found'
            ];
        }

        $book->load($data, '');
        if ($book->save()) {
            return [
                'status' => 'success',
                'message' => 'Book updated successfully',
                'data' => $book
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Failed to update book',
                'errors' => $book->getErrors()
            ];
        }
    }
}
