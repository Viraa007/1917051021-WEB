<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
	protected $table                = 'posts';		# mendefiniskan table mana yg dipakai
	protected $primaryKey           = 'post_id';	# pm dari table
	protected $allowedFields        = ['judul', 'deskripsi', 'gambar', 'author', 'kategori', 'slug', 'created_at', 'updated_at'];
	protected $useTimestamps        = true;			# untuk created_at dan updated_at

	public function getPosts($post_id = false){
		if($post_id == false) {
			return $this->findAll();
		}
		return $this->where(['post_id' => $post_id])->first();
	}
}
