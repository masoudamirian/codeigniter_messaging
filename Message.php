<?php
/**
 * Created by PhpStorm.
 * User: masoud
 * Date: 12/22/2018
 * Time: 3:55 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Message
{
	protected $CI;
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function send($sender,$receiver,$title,$body,$send_date)
	{
		try
		{
			$values = array('sender'=>$sender,'receiver'=>$receiver,'title'=>$title,'body'=>$body,'date'=>$send_date,'is_sent'=>1);
			$this->CI->db->insert('messages',$values);
		}
		catch (Exception $e)
		{
			echo 'خطایی پیش آمده است!';
			echo $e->getMessage();
		}
	}

	public function receive($username)
	{
		$query = $this->CI->db->get_where('messages',array('receiver'=>$username));
		return $query->result_array();
	}

	public function mark_as_read($username,$msg_id)
	 {
		 try
		 {
		 	$this->CI->db->where(array('receiver'=>$username,'id'=>$msg_id));
			 $this->CI->db->update('messages',array('is_read'=>1));
		 }
		 catch (Exception $e)
		 {
			 echo 'خطایی پیش آمده است!';
			 echo $e->getMessage();
		 }
	 }

	public function received_messages_count($username)
	{
		try
		{
			$this->CI->db->select('id');
			$this->CI->db->from('messages');
			$this->CI->db->where(array('receiver'=>$username));
			$query = $this->CI->db->count_all_results();
			return $query;
		}
		catch (Exception $e)
		{
			echo 'خطایی پیش آمده است!';
			echo $e->getMessage();
		}
	}

	public function sent_messages_count($username)
	{
		try
		{
			$this->CI->db->select('id');
			$this->CI->db->from('messages');
			$this->CI->db->where(array('sender'=>$username));
			$query = $this->CI->db->count_all_results();
			return $query;
		}
		catch (Exception $e)
		{
			echo 'خطایی پیش آمده است!';
			echo $e->getMessage();
		}
	}

	public function unread_messages_count($username)
	{
		try
		{
			$this->CI->db->select('id');
			$this->CI->db->from('messages');
			$this->CI->db->where(array('receiver'=>$username,'is_read'=>0));
			$query = $this->CI->db->count_all_results();
			return $query;
		}
		catch (Exception $e)
		{
			echo 'خطایی پیش آمده است!';
			echo $e->getMessage();
		}
	}

	public function send_comment($sender,$msg_id,$date,$comment)
	{
		try
		{
			$values = array('sender'=>$sender,'msg_id'=>$msg_id,'date'=>$date,'comment'=>$comment);
			$this->CI->db->insert('comments',$values);
		}
		catch (Exception $e)
		{
			echo 'خطایی پیش آمده است!';
			echo $e->getMessage();
		}
	}

	public function comments_json($msg_id)
	{
		$query = $this->CI->db->get_where('comments',array('msg_id'=>$msg_id));
		$returned_values = $query->result_array();
		return ($returned_values);
	}
}
