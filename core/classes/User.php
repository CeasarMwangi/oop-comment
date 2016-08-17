<?php
class User
{
    private $_db,
            $_data,
            $_sessionName,
            $_isLoggedIn;

    public function __construct($user = null)
    {
        $this->_db = DB::getInstance();

        $this->_sessionName = Config::get('session/session_name');
        if(!$user)
        {
            if(Session::exists($this->_sessionName))
            {
                $user = Session::get($this->_sessionName);
                if($this->find($user))
                {
                        $this->_isLoggedIn = true;
                }
                else
                {
                    //
                }
            }
        }
        else
        {
            $this->find($user);
        }
    }

    public function create($fields = array())
    {
        if(!$this->_db->insert('author',$fields))
        {
            throw new Exception("There was a problem creating an account.");
        }
    }
    public function find($user = null)
    {
    	
        if($user)
        {
		
            $field = (is_numeric($user)) ? 'id': 'username';

            $data = $this->_db->get('author', array($field, '=', $user));

            if($data->count())
            {
                $this->_data = $data->first();

                return true;
            }
        }
        return false;
    }

    
    //returns true or false
    public function login($username = null, $password = null)
    {

        if(!$username && !$password && $this->exists())
        {
            Session::put($this->_sessionName, $this->data()->username);
        }
        else
        {
            $user = $this->find($username); //here $user is either true or false

            if($user)
            {
                echo Hash::make($password).'<br>';
                echo $this->data()->password;
                if($this->data()->password === Hash::make($password))
                {
                    Session::put($this->_sessionName, $this->data()->username);

                    return true;
                }	
            }
                    
        }
        return false;
    }

    public function data()
    {
        return $this->_data;
    }

    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }
    public function logout()
    {
        Session::delete($this->_sessionName);
    }
    public function exists()
    {
        return (!empty($this->_data)) ? true : false;
    }   

    public function update($fields = array(), $id=null)
    {
        if(!$id && $this->isLoggedIn())
        {
            $id = $this->data()->member_id;
        }
        if(!$this->_db->update('author', $id, $fields))
        {
            throw new Exception('There was an error updating your profile. Please try again later.');
        }
    }

}