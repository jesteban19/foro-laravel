<?php
Route::get('posts/create', [
    'uses' => 'CreatePostController@create',
    'as' => 'posts.create'
]);

Route::post('posts/create', [
    'uses' => 'CreatePostController@store',
    'as' => 'posts.store'
]);

Route::post('posts/{post}/comment',[
   'uses' => 'CommentsController@store',
    'as' => 'comments.store',
]);
Route::post('comments/{comment}/accept',[
    'uses' => 'CommentsController@accept',
    'as' => 'comments.accept',
]);

Route::post('comments/{post}/subscribe',[
    'uses' => 'SubscriptionController@subscribe',
    'as' => 'posts.subscribe',
]);

Route::delete('comments/{post}/unsubscribe',[
    'uses' => 'SubscriptionController@unsubscribe',
    'as' => 'posts.unsubscribe',
]);
