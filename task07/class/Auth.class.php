<?php

require ('DBController.class.php');

class Auth {

    /*public function getAuthResultAndData(string $login, string $password): array
    {
        $result = array();
        foreach ($this->users_data as $user) {
            if (($user['login'] == $login) && ($user['password'] == $password)) {
                $result = $user;
                break;
            }
        }
        return $result;
    }

    public function checkUserHomedir(array $user, string $homedirs_location): bool
    {
        $user_home_dir = $homedirs_location . '/' . $user['homedir'] . '/';
        if (is_dir($user_home_dir)) {
            return true;
        } else {
            return false;
        }
    }
    */
    public function getMemberByUsername($username) {
        $db_handle = new DBController();
        $query = "Select * from `members` where member_name = ?";
        $result = $db_handle->runQuery($query, 's', array($username));
        return $result;
    }
    
	public function getTokenByUsername($username,$expired) {
	    $db_handle = new DBController();
	    $query = "Select * from `tbl_token_auth` where username = ? and is_expired = ?";
	    $result = $db_handle->runQuery($query, 'si', array($username, $expired));
	    return $result;
    }
    
    public function markAsExpired($tokenId) {
        $db_handle = new DBController();
        $query = "UPDATE `tbl_token_auth` SET is_expired = ? WHERE id = ?";
        $expired = 1;
        $result = $db_handle->update($query, 'ii', array($expired, $tokenId));
        return $result;
    }
    
    public function insertToken($username, $random_password_hash, $random_selector_hash, $expiry_date) {
        $db_handle = new DBController();
        $query = "INSERT INTO `tbl_token_auth` (username, password_hash, selector_hash, expiry_date) values (?, ?, ?,?)";
        $result = $db_handle->insert($query, 'ssss', array($username, $random_password_hash, $random_selector_hash, $expiry_date));
        return $result;
    }
    
    public function update($query) {
        mysqli_query($this->conn,$query);
    }
}
?>