<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 16-Aug-16
 * Time: 12:41
 */
class Comment
{
    private $_db,
        $_data,
        $_total_comments;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    /**
     * @param array $fields
     * @throws Exception
     * Create/insert a single comment into the database
     */
    public function create($fields = array())
    {
        if(!$this->_db->insert('comment',$fields))
        {
            throw new Exception("There was a problem saving the post.");
        }
    }

    /**
     * @param null $post_id
     * @return $this|bool|DB|int
     * find a all comments for a single post by id
     */
    public function find_all_comments($post_id = null)
    {

        $data = $this->_db->getordered('comment', array('post_id', '=', $post_id));

        if($data->count())
        {
            $this->_total_comments = $data->count();
            $this->_data = $data;
            return $this->_data;
        }

        return 0;
    }

    /**
     * @param null $post_id
     * @return $this|bool|DB|int
     * find a all comments and their authors for a single post by id
     */
    public function find_comments_authors($post_id = null)
    {

        $data = $this->_db->getordered('post', array('post_id', '=', $post_id));

        if($data->count())
        {
            $this->_total_comments = $data->count();
            $this->_data = $data;
            return $this->_data;
        }

        return 0;
    }


    public function find_comments_and_their_authors()
    {

        $data = $this->_db->find_comments_and_their_authors();

        if($data->count())
        {
            $this->_total_comments = $data->count();
            $this->_data = $data;
            return $this->_data;
        }

        return 0;
    }

    public function get_total_comments()
    {
        return $this->_total_comments;
    }

    public function data()
    {
        return $this->_data;
    }
}