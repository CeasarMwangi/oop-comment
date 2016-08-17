<?php

//single tone class
class DB
{
    private static $_instance = null;//store instance of our db
    private $_pdo,
            $_query,
            $_error = false, 
            $_results,
            $_count = 0;


//private help connect or create and maintain only a single connection to 
//our database
    private function __construct(){
        try{
            $this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='. Config::get('mysql/db'), Config::get('mysql/username'),Config::get('mysql/password'));
                //echo 'connected';
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    //check the single tone instance
    public static function getInstance(){

            //accessing class/static variable
            //class_name::instance_name
            //self::$_instance
            //self here refer to this class name
            if(!isset(self::$_instance)){
                    self::$_instance =  new DB();
            }
            return self::$_instance;
    }

    public function query($sql, $params = array()){
            $this->_error = false;
            if($this->_query = $this->_pdo->prepare($sql)){
                    $x = 1;
                    if(count($params)){
                            foreach ($params as $param){
                                    $this->_query->bindValue($x, $param);
                                    $x++;
                            }

                    }
                    if($this->_query->execute()){

                            //note we want results as objects and not as an array
                            $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                            $this->_count = $this->_query->rowCount();
                    }else{
                        $this->_error = true;

                    }
            }
            return $this;
    }



    public function action($action, $table, $where = array()){
            if(count($where)===3){
                    $operators = array('=','>','>=','<','<=');

                    $field    = $where[0];
                    $operator = $where[1];
                    $value    = $where[2];

                    if(in_array($operator, $operators)){
                            //$sql = "SELECT * FROM users WHERE username = 'kanja";

                            $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? ";

                            if(!$this->query($sql, array($value))->_error){

                                return $this;
                                    
                            }
                    }

            }
            return false;
    }
    public function orderbyaction($action, $table, $where = array()){
            if(count($where)===3){
                    $operators = array('=','>','>=','<','<=');

                    $field    = $where[0];
                    $operator = $where[1];
                    $value    = $where[2];

                    if(in_array($operator, $operators)){
                            //$sql = "SELECT * FROM users WHERE username = 'kanja";

                            $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? ORDER BY id DESC";
                            if(!$this->query($sql, array($value))->_error){

                                return $this;
                                    
                            }
                    }

            }
            return false;
    }
    
    public function get($table, $where){
            return $this->action('SELECT *',$table,$where );
    }
    
    public function getordered($table, $where){
            return $this->orderbyaction('SELECT *',$table,$where );
    }
    
    public function delete($table, $where){
            return $this->action('DELETE',$table,$where );
    }		
    
    
    	
    public function insert($table, $fields = array()){
            //if(count($fields)){
                    $keys = array_keys($fields);
                    //$values = null;
                    $values = '';
                    $x = 1;

                    foreach ($fields as $field) 
                    {

                            $values .= '?';
                            if($x < count($fields))
                            {
                                    $values .=',';

                            }
                            $x++;
                    }
                    //die($values);

                    //$sql = "INSERT INTO users (username, password, salt) VALUES ()"
                    $sql = "INSERT INTO {$table} (`".implode('`,`', $keys)."`) VALUES ({$values})"; //(` - this is called backtick)					
                   // echo $sql;
                    //die();

                    if(!$this->query($sql, $fields)->error()){
                            return true;
                    }
            //}
            return false;


    }
    
    
    public function update($table, $id, $fields){
            $set = '';
            $x = 1;
            //$sql = "UPDATE users SET password = 'newpassword' WHERE member_id = 3";
            foreach ($fields as $name => $value){
                    $set .= "{$name} = ?";//binding
                    if($x<count($fields)){
                            $set .=', ';
                            //die($set);
                    }
                    $x++;
            }				

            $sql = "UPDATE {$table} SET {$set} WHERE member_id = {$id}";

            //echo $sql;

            if(!$this->query($sql,$fields)->error()){
                    return true;

            }
            return false;
    }
    
    
    public function results(){
            return $this->_results;
    }
    //return the first result
    //result at position 0
    public function first(){

            //using the above (results) method here
            return $this->results()[0]; //depends on the version of your PHP server
            //return $this->results[0];
    }
    public function next($index=1){

            //using the above (results) method here
            return $this->results()[$index]; //depends on the version of your PHP server
            //return $this->results[0];
    }
    public function error(){
            return $this->_error;
    }	

    public function count(){
            return $this->_count;

    }


    public function find_posts_and_their_authors(){


        $sql = "SELECT post.title, post.content, post.publish_date, author.username as 'author_name'  FROM post LEFT OUTER JOIN author ON post.author_id = author.id ORDER BY post.id DESC";

        if(!$this->query($sql)->_error){
            return $this;

        }
        return 0;
    }

    public function find_posts_and_their_comments(){


        $sql = "SELECT post.title, post.content, post.publish_date, comment.content AS 'comment_text' FROM post LEFT OUTER JOIN comment ON post.id = comment.post_id ORDER BY post.id DESC";

        if(!$this->query($sql)->_error){
            return $this;

        }
        return 0;
    }

    public function find_comments_and_their_authors(){


        $sql = "SELECT comment.content, comment.date, author.username FROM comment LEFT OUTER JOIN author ON comment.author_id = author.id ORDER BY comment.id DESC";

        if(!$this->query($sql)->_error){
            return $this;

        }
        return 0;
    }

    public function find_post_comments($id){


        $sql = "SELECT post.title, post.content, post.publish_date, comment.date, comment.content AS 'comment_text' FROM post LEFT OUTER JOIN comment ON comment.post_id = post.id WHERE post.id = $id ORDER BY comment.id DESC";

        if(!$this->query($sql)->_error){
            return $this;

        }
        return 0;
    }


//    public function find_post_author_and_comments_and_their_authors($id){
//
//
//        $sql = "SELECT a.username as author, p.title, p.content, c.content as comment FROM post p, comment c, author a
//                WHERE p.id = $id AND c.post_id = p.id";
//
//        if(!$this->query($sql)->_error){
//            echo "q success";
//            return $this;
//
//        }
//        return 0;
//    }


}