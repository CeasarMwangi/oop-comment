<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 16-Aug-16
 * Time: 12:41
 */
class Post
{
    private $_db,
        $_data,
        $_total_posts;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    /**
     * @param array $fields
     * @throws Exception
     * Create/insert a single post into the database
     */
    public function create($fields = array())
    {
        if(!$this->_db->insert('post',$fields))
        {
            throw new Exception("There was a problem saving the post.");
        }
    }

    /**
     * @param null $id
     * @return $this|bool|DB|int
     * find a single post by id
     */
    public function find($id = null)
    {

            $data = $this->_db->get('post', array('id', '=', $id));

            if($data->count())
            {
                $this->_total_posts = $data->count();
                $this->_data = $data;
                return $this->_data;
            }

        return 0;
    }

    /**
     * @param null $id
     * @return $this|bool|DB|int
     * select all posts
     */
    public function findAll()
    {
            $field = 'id';
            $data = $this->_db->getordered('post', array($field, '>', 0));

            if($data->count())
            {
                $this->_total_posts = $data->count();
                $this->_data = $data;
                return $this->_data;
            }

        return 0;
    }

    public function get_total_posts()
    {
        return $this->_total_posts;
    }

    public function data()
    {
        return $this->_data;
    }

    public function find_posts_and_their_authors(){
        $data = $this->_db->find_posts_and_their_authors();

        if($data->count())
        {
            $this->_total_posts = $data->count();
            $this->_data = $data;
            return $this->_data;
        }

        return 0;
    }
    public function find_posts_and_their_comments(){
        $data = $this->_db->find_posts_and_their_comments();

        if($data->count())
        {
            $this->_total_posts = $data->count();
            $this->_data = $data;
            return $this->_data;
        }

        return 0;
    }

    public function find_post_comments($id){
        $data = $this->_db->find_post_comments($id);

        if($data->count())
        {
            $this->_total_posts = $data->count();
            $this->_data = $data;
            return $this->_data;
        }

        return 0;
    }
//    public function find_post_author_and_comments_and_their_authors($id){
//        $data = $this->_db->find_post_author_and_comments_and_their_authors($id);
//
//        if($data->count())
//        {
//            $this->_total_posts = $data->count();
//            $this->_data = $data;
//            return $this->_data;
//        }
//
//        return 0;
//    }

}