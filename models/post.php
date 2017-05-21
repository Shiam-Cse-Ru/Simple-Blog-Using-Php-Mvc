<?php
  class Post {
    // define 3 attributes
    // they are public so that we can access them using $post->title directly
    public $id;
    public $title;
    public $description;
    public $content;
    public function __construct($id, $title, $content,$description) {
      $this->id      = $id;
      $this->title  = $title;
      $this->content = $content;
      $this->description = $description;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM posts');

      // create a list of Post objects from the database results
      foreach($req->fetchAll() as $post) {
        $list[] = new Post($post['id'], $post['title'],$post['content'] ,$post['description']);
      }

      return $list;
    }

    public static function find($id) {
      $db = Db::getInstance();
      // make sure $id is an integer
      $id = intval($id);
      $req = $db->prepare('SELECT * FROM posts WHERE id = :id');
      // the query was prepared, now I replace :id with my actual $id value
      $req->execute(array('id' => $id));
      $post = $req->fetch();

      return new Post($post['id'], $post['title'], $post['content'],$post['description']);
    }
  }
?>