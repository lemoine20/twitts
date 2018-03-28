<?php
/**
 * @Author: Thibault Napoléon <Imothep>
 * @Company: ISEN Yncréa Ouest
 * @Email: thibault.napoleon@isen-ouest.yncrea.fr
 * @Created Date: 22-Jan-2018 - 13:57:23
 * @Last Modified: 06-Feb-2018 - 09:05:52
 */

  require_once('constants.php');

  //----------------------------------------------------------------------------
  //--- dbConnect --------------------------------------------------------------
  //----------------------------------------------------------------------------
  // Create the connection to the database.
  // \return False on error and the database otherwise.
  function dbConnect()
  {
    try
    {
      $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME.';charset=utf8',
        DB_USER, DB_PASSWORD);
    }
    catch (PDOException $exception)
    {
      error_log('Connection error: '.$exception->getMessage());
      return false;
    }
    return $db;
  }

  //----------------------------------------------------------------------------
  //--- dbRequestTwitts --------------------------------------------------------
  //----------------------------------------------------------------------------
  // Function to get all twitts (if $login='') or the twitts of a user
  // (otherwise).
  // \param db The connected database.
  // \param login The login of the user (for specific request).
  // \return The list of twitts.
  function dbRequestTwitts($db, $login = '')
  {
    try
    {
      $request = 'select * from twitts';
      if ($login != '')
        $request .= ' where login=:login';
      $statement = $db->prepare($request);
      if ($login != '')
        $statement->bindParam(':login', $login, PDO::PARAM_STR, 20);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
  }

  //----------------------------------------------------------------------------
  //--- dbAddCTwitt -----------------------------------------------------------
  //----------------------------------------------------------------------------
  // Add a twitt.
  // \param db The connected database.
  // \param login The login of the user.
  // \param text The twitt to add.
  // \return True on success, false otherwise.
  function dbAddTwitt($db, $login, $text)
  {
    try
    {
      $request = 'insert into twitts(login, text) values(:login, :text)';
      $statement = $db->prepare($request);
      $statement->bindParam(':login', $login, PDO::PARAM_STR, 20);
      $statement->bindParam(':text', $text, PDO::PARAM_STR, 80);
      $statement->execute();
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }
  
  //----------------------------------------------------------------------------
  //--- dbModifyTwitt ----------------------------------------------------------
  //----------------------------------------------------------------------------
  // Function to modify a twitt.
  // \param db The connected database.
  // \param id The id of the twitt to update.
  // \param login The login of the user.
  // \param text The new twitt.
  // \return True on success, false otherwise.
  function dbModifyTwitt($db, $id, $login, $text)
  {
    try
    {
      $request = 'update twitts set text=:text where id=:id and login=:login ';
      $statement = $db->prepare($request);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->bindParam(':login', $login, PDO::PARAM_STR, 20);
      $statement->bindParam(':text', $text, PDO::PARAM_STR, 80);
      $statement->execute();
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }

  //----------------------------------------------------------------------------
  //--- dbDeleteTwitt ----------------------------------------------------------
  //----------------------------------------------------------------------------
  // Delete a twitt.
  // \param db The connected database.
  // \param id The id of the twitt.
  // \param login The login of the user.
  // \return True on success, false otherwise.
  function dbDeleteTwitt($db, $id, $login)
  {
    try
    {
      $request = 'delete from twitts where id=:id and login=:login';
      $statement = $db->prepare($request);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->bindParam(':login', $login, PDO::PARAM_STR, 20);
      $statement->execute();
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }
?>
