<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * LibLogin is a authentication library for CodeIgniter
 *
 * You can use this library if you want authentication on a CodeIgniter website.
 * Its secure, cause passwords are stored sha1 hashed with a salt. The library
 * is very ease to use. Each function explains it self. It you want to check if a
 * user is logged in, use the function logged_in() for example.
 * Just place this file in the /application/libraries/ folder and you're done!
 *
 * If you want to use this library, it's recommanded to autoload the folling stuff:
 * -database
 * -session
 * -liblogin'
 *
 * It is based on Redux Auth, wich is written by Mathew Davies <leveldesign.info@gmail.com>
 *
 * @author Ramon Wijnands <rayman747@hotmail.com>
 * @copyright Copyright (c) <2009> Ramon Wijnands
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version 1.0
 **/
class liblogin extends liblogin_db
{
  /**
   * Default constructor for the liblogin class
   *
   * It loads the configuration file, and processes all stuff in it.
   **/
  public function __construct ()
  {
    $this->ci =& get_instance();

    $this->ci->config->load('liblogin');
    $auth = $this->ci->config->item('auth');

    foreach($auth as $key => $value)
    {
      $this->$key = $value;
    }
  }

  /**
   * Custom hash function
   *
   * This function is used for hashing a password.
   * The $salt and the $email are used as a salt in the sha1() function
   */
  public function hash ($email, $pass, $salt)
  {
    return sha1($salt.$email.$pass.$email.$salt);
  }

  /**
   * Checks in the database if the @password belongs to the $email
   *
   * @param  $email A string email address
   * @param  $password A string with a password
   * @return bool if success
   */
  public function try_login ($email, $password)
  {
    //Get info from the database
    $result = $this->_get_user_info($this->users_table, $email, 'password');

    //Hash the password
    $password_enc = $this->hash($email, $password, $this->salt);

    return ($result !== false && $result->password === $password_enc);
  }

  /**
   * Register a new user
   *
   * It hashes the password, and insets all the data in the database
   *
   * @param $username A string with the username
   * @param $password A string with a password
   * @param $email A valid email-address
   * @return The string 'REGISTRATION_SUCCESS' on success
   **/
  public function register ($username, $password, $email)
  {
    if(!isset($this->salt) || $this->salt == "")
    {
      show_error("You must set an salt in the liblogin config");
    }

    # Hash password
    $password_enc = $this->hash($email, $password, $this->salt);

    $data = array
    (
      'username'   => $username,
      'password'   => $password_enc,
      'email'      => $email,
    );

    $this->ci->db->set($data);

    if ($this->email_activation)
    {
      show_error("Email activation is not supported yet");
    }
    else
    {
      # Insert information into the users table
      $this->ci->db->insert($this->users_table);

      return 'REGISTRATION_SUCCESS';
    }
  }

 /**
  * Change a user's password
  *
  * @param $email Email Address
  * @param $new_password New password
  * @return bool if success
  **/
  public function change_password ($email, $new_password)
  {
    //New password hash
    $new_hash = $this->hash($email, $new_password, $this->salt);

    //Try to update the database
    $this->ci->db->update
    (
      $this->users_table,
      array('password' => $new_hash),
      array('email' => $email)
    );

    if($this->ci->db->affected_rows() !== 1)
    {
      return false;
    }
    else
    {
      return true;
    }
  }

  /**
   * Tries to log in, and sets the session data so the users is remembered logged in
   *
   * @param $email Vaild email address
   * @param $password Password
   * @return bool if the login was successfull
   **/
  public function login ($email, $password)
  {
    $result = $this->_get_user_info($this->users_table, $email, array('id', 'password'));

    //password ok?
    if($result !== false && $result->password === $this->hash($email, $password, $this->salt))
    {
      $this->ci->session->set_userdata
      (
        array
        (
          'id'       => $result->id, //Dont use try_login, becouse $result->id is needed
          'email'    => $email,
          'password' => $password
        )
      );
      return true;
    }
    else
    {
      return false;
    }
  }

  /**
   * Check if the user is logged in
   *
   * @return bool if the user is logged in
   **/
  public function logged_in ()
  {
    $email    = $this->ci->session->userdata('email');
    $password = $this->ci->session->userdata('password');

    // No need to do a query
    if($email === false || $password === false)
      return false;

    return $this->try_login($email, $password);
  }

  /**
   * logout, destroys the session data
   **/
  public function logout ()
  {
    $this->ci->session->unset_userdata(array('id', 'email', 'password'));
    $this->ci->session->sess_destroy();
  }

  /**
   * Check if the username is in use
   *
   * @param $username Username
   * @return bool if the username is in use
   **/
  public function check_username ($username){return $this->_check_username($this->users_table, $username);}

  /**
   * Check if the email is in use
   *
   * @param $email An email address
   * @return bool if the email is in use
   **/
  public function check_email ($email){return $this->_check_email($this->users_table, $email);}
}

/**
 * The helper class of liblogin.
 *
 * This class has only functions that use the database.
 * All functions of liblogin that require database actions, call this class
 *
 * @author Ramon Wijnands <rayman747@hotmail.com>
 * @copyright Copyright (c) <2009> Ramon Wijnands
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version 1.0
 **/
class liblogin_db
{
  /**
   * Checks if the username is already in use
   *
   * @param $users_tbl Users table
   * @param $username Username
   * @return bool if the username is in use
   **/
  protected function _check_username ($users_tbl, $username)
  {
    $i = $this->ci->db->select($users_tbl.'.username')->from($users_tbl)->where($users_tbl.'.username', $username)->get();

    return $var = ($i->num_rows() > 0) ? true : false;
  }

  /**
   * Check if the email-address is already in use
   *
   * @param $users_tbl Users table
   * @param $email Valid email address
   * @return bool if the email-address is in use
   **/
  protected function _check_email ($users_tbl, $email)
  {
    $i = $this->ci->db->select($users_tbl.'.email')->from($users_tbl)->where($users_tbl.'.email', $email)->get();

    return $var = ($i->num_rows() > 0) ? true : false;
  }

  /**
   * Gets all data from the users_table, WHERE 'email' == $email
   *
   * @param $users_tbl Users table
   * @param $email Valid email address
   * @param $fields An optional argument. If used, it only selects these fields from the database
   * @return The data or the bool false on error.
   **/
  protected function _get_user_info ($users_tbl, $email, $fields = null)
  {
    if(!is_null($fields))
    {
      $this->ci->db->select($fields);
    }
    $this->ci->db->from($users_tbl);
    $this->ci->db->where(array('email' => $email));
    $i = $this->ci->db->get();

    return ($i->num_rows() > 0) ? $i->row() : false;
  }
}